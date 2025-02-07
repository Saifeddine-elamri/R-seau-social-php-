<?php
require_once __DIR__ . '/../includes/db.php';

class User {
    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }


    public static function findByEmail($email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }


    // Récupérer tous les utilisateurs sauf l'utilisateur connecté
    public static function getAllUsers($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id != ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les amis de l'utilisateur
    public static function getFriends($user_id) {
        global $pdo;
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les demandes d'amis en attente
    public static function getPendingRequests($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT friend_id FROM friends WHERE user_id = ? AND status = 'pending'");
        $stmt->execute([$user_id]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'friend_id');
    }

    public static function addFriend($user_id, $friend_id) {
        global $pdo;

        // Vérifier si la demande d'ami existe déjà
        $stmt = $pdo->prepare("SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
        $stmt->execute([$user_id, $friend_id, $friend_id, $user_id]);
        $existingRequest = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRequest) {
            // Si une demande existe déjà, on ne fait rien
            return false;
        }

        // Insérer une nouvelle demande d'ami
        $stmt = $pdo->prepare("INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'pending')");
        return $stmt->execute([$user_id, $friend_id]);
    }

    public static function cancelFriendRequest($user_id, $friend_id) {
        global $pdo;

        // Vérifier si la demande est en attente
        $stmt = $pdo->prepare("SELECT * FROM friends WHERE (user_id = ? AND friend_id = ? OR user_id = ? AND friend_id = ?) AND status = 'pending'");
        $stmt->execute([$user_id, $friend_id, $friend_id, $user_id]);
        $request = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($request) {
            // Supprimer la demande d'ami
            $stmt = $pdo->prepare("DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
            return $stmt->execute([$user_id, $friend_id, $friend_id, $user_id]);
        }
        return false;
    }




















}
        





?>
