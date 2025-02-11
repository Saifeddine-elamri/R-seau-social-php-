<?php
require_once __DIR__ . '/../includes/db.php';

class User {

    // Récupérer un utilisateur par son ID
    public static function getById($id) {
        global $pdo;

        // Préparer et exécuter la requête pour récupérer l'utilisateur avec un ID spécifique
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        
        // Retourner les données de l'utilisateur
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vérifier si l'utilisateur est connecté
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Trouver un utilisateur par son adresse email
    public static function findByEmail($email) {
        global $pdo;

        // Préparer et exécuter la requête pour récupérer l'utilisateur par email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        // Retourner les résultats sous forme de tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vérifier si le mot de passe correspond au mot de passe haché
    public static function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

    // Récupérer tous les utilisateurs sauf l'utilisateur connecté
    public static function getAllUsers($user_id) {
        global $pdo;

        // Préparer et exécuter la requête pour récupérer tous les utilisateurs sauf celui spécifié
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id != ?");
        $stmt->execute([$user_id]);

        // Retourner les résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les amis d'un utilisateur donné
    public static function getFriends($user_id) {
        global $pdo;

        // Préparer et exécuter la requête pour récupérer les amis de l'utilisateur
        $stmt = $pdo->prepare("
            SELECT u.id, u.username, u.email, u.profile_image
            FROM users u
            JOIN friends f ON (u.id = f.user_id OR u.id = f.friend_id)
            WHERE (f.friend_id = ? OR f.user_id = ?) 
            AND u.id != ?
            AND f.status = 'accepted'
            ORDER BY u.username ASC
        ");
        $stmt->execute([$user_id, $user_id, $user_id]);

        // Retourner la liste des amis sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les demandes d'amis en attente pour un utilisateur donné
    public static function getPendingRequests($user_id) {
        global $pdo;

        // Préparer et exécuter la requête pour récupérer les demandes d'amis en attente
        $stmt = $pdo->prepare("SELECT friend_id FROM friends WHERE user_id = ? AND status = 'pending'");
        $stmt->execute([$user_id]);

        // Retourner la liste des IDs des amis en attente
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'friend_id');
    }

    // Ajouter un ami (créer une demande d'ami)
    public static function addFriend($user_id, $friend_id) {
        global $pdo;

        // Vérifier si une demande d'ami existe déjà
        $stmt = $pdo->prepare("SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
        $stmt->execute([$user_id, $friend_id, $friend_id, $user_id]);
        $existingRequest = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRequest) {
            // Si la demande existe déjà, on retourne false pour éviter une nouvelle demande
            return false;
        }

        // Créer une nouvelle demande d'ami (statut "pending")
        $stmt = $pdo->prepare("INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'pending')");
        return $stmt->execute([$user_id, $friend_id]);
    }

    // Annuler une demande d'ami (si elle est en attente)
    public static function cancelFriendRequest($user_id, $friend_id) {
        global $pdo;

        // Vérifier si la demande d'ami est en attente
        $stmt = $pdo->prepare("SELECT * FROM friends WHERE (user_id = ? AND friend_id = ? OR user_id = ? AND friend_id = ?) AND status = 'pending'");
        $stmt->execute([$user_id, $friend_id, $friend_id, $user_id]);
        $request = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($request) {
            // Si la demande existe, on la supprime
            $stmt = $pdo->prepare("DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
            return $stmt->execute([$user_id, $friend_id, $friend_id, $user_id]);
        }

        // Si aucune demande n'a été trouvée, retourner false
        return false;
    }

    // Supprimer l'image de profil d'un utilisateur
    public static function deleteProfileImage($userId) {
        global $pdo;

        // Récupérer l'image de profil actuelle de l'utilisateur
        $stmt = $pdo->prepare("SELECT profile_image FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur a une image de profil
        if ($user && !empty($user['profile_image'])) {
            $filePath = '../uploads/' . $user['profile_image'];

            // Si le fichier existe, le supprimer
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Supprimer l'image de profil dans la base de données
            $stmt = $pdo->prepare("UPDATE users SET profile_image = NULL WHERE id = ?");
            $stmt->execute([$userId]);

            return true;
        }

        // Si aucune image de profil n'a été trouvée, retourner false
        return false;
    }

    // Mettre à jour l'image de profil d'un utilisateur
    public static function updateProfileImage($userId, $fileName) {
        global $pdo;

        // Préparer et exécuter la requête pour mettre à jour l'image de profil dans la base de données
        $stmt = $pdo->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
        return $stmt->execute([$fileName, $userId]);
    }


    /**
     * Met à jour les informations personnelles de l'utilisateur
     */
    public static function updateProfileInfo($user_id, $first_name, $last_name, $birth_date, $phone)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            UPDATE users SET 
                first_name = ?, 
                last_name = ?, 
                birth_date = ?, 
                phone_number = ? 
            WHERE id = ?
        ");

        return $stmt->execute([$first_name, $last_name, $birth_date, $phone, $user_id]);
    }


















}
?>
