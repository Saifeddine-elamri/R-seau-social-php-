<?php

// Définition de la classe Message qui gère les opérations liées aux messages et aux utilisateurs
class Message {

    // Récupérer les contacts d'un utilisateur
    // Cette méthode retourne les contacts (amis) d'un utilisateur donné.
    // Les utilisateurs sont sélectionnés en fonction de leur statut d'ami "accepted".
    public static function getContacts($user_id) {
        global $pdo;  // Accède à la variable globale $pdo pour l'interaction avec la base de données
        
        // Préparer la requête SQL pour récupérer les contacts
        $stmt = $pdo->prepare("
        SELECT DISTINCT u.id, u.username, u.profile_image
        FROM users u
        JOIN friends f ON (u.id = f.user_id OR u.id = f.friend_id)  /* Rejoint la table 'friends' pour obtenir les amis */
        WHERE (f.friend_id = ? OR f.user_id = ?)  /* Vérifie si l'utilisateur est dans la relation d'amitié */
        AND u.id != ?  /* Exclut l'utilisateur lui-même */
        AND f.status = 'accepted'  /* Filtre pour ne prendre que les amis avec statut 'accepted' */
        ORDER BY u.username ASC  /* Trie les résultats par le nom d'utilisateur */
        ");
        
        // Exécute la requête en passant l'ID de l'utilisateur comme paramètre
        $stmt->execute([$user_id, $user_id, $user_id]);
        
        // Retourne tous les résultats sous forme de tableau associatif
        return $stmt->fetchAll();
    }

    // Récupérer les messages échangés entre deux utilisateurs
    // Cette méthode récupère tous les messages entre l'utilisateur et un contact spécifique.
    public static function getMessages($user_id, $contact_id) {
        global $pdo;  // Accède à la variable globale $pdo pour l'interaction avec la base de données
        
        // Préparer la requête SQL pour récupérer les messages entre les deux utilisateurs
        $stmt = $pdo->prepare("
            SELECT m.*, 
                   sender.username AS sender_username, sender.profile_image AS sender_image, 
                   receiver.username AS receiver_username, receiver.profile_image AS receiver_image
            FROM messages m
            JOIN users sender ON m.sender_id = sender.id  /* Récupère les informations sur l'expéditeur */
            JOIN users receiver ON m.receiver_id = receiver.id  /* Récupère les informations sur le récepteur */
            WHERE (m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?)  /* Filtre les messages entre les deux utilisateurs */
            ORDER BY m.created_at ASC  /* Trie les messages par date de création (du plus ancien au plus récent) */
        ");
        
        // Exécute la requête en passant les IDs des deux utilisateurs
        $stmt->execute([$user_id, $contact_id, $contact_id, $user_id]);
        
        // Retourne tous les messages sous forme de tableau associatif
        return $stmt->fetchAll();
    }

    // Enregistrer un message dans la base de données
    // Cette méthode insère un message envoyé par un utilisateur vers un autre utilisateur dans la base de données.
    public static function sendMessage($sender_id, $receiver_id, $message, $image_name) {
        global $pdo;  // Accède à la variable globale $pdo pour l'interaction avec la base de données
        
        // Préparer la requête SQL pour insérer un nouveau message
        $stmt = $pdo->prepare("
            INSERT INTO messages (sender_id, receiver_id, message, image, created_at)
            VALUES (?, ?, ?, ?, NOW())  /* Utilise l'ID de l'expéditeur, de récepteur, le message, le nom de l'image et la date actuelle */
        ");
        
        // Exécute la requête avec les valeurs fournies
        $stmt->execute([$sender_id, $receiver_id, $message, $image_name]);
    }

    // Gérer l'upload d'image
    // Cette méthode gère le téléchargement d'une image envoyée avec un message.
    public static function handleImageUpload() {
        // Vérifie si un fichier a été téléchargé
        if (empty($_FILES['image']['name'])) {
            return null;  // Retourne null si aucun fichier n'a été téléchargé
        }

        // Définir le répertoire où l'image sera sauvegardée et générer un nom unique pour l'image
        $target_dir = __DIR__ . '/../uploads/';  // Répertoire où les images seront enregistrées
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);  // Génère un nom unique pour l'image basé sur l'heure actuelle
        $target_file = $target_dir . $image_name;  // Détermine le chemin complet du fichier

        // Vérifie l'extension du fichier (acceptation des formats jpg, jpeg, png, gif)
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));  // Récupère l'extension du fichier
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];  // Formats d'image autorisés

        // Si l'extension est valide et que le fichier a été déplacé avec succès
        if (in_array($imageFileType, $allowed_types) && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            return $image_name;  // Retourne le nom du fichier si l'upload est réussi
        }

        // Retourne null si l'upload échoue ou si le fichier a un format invalide
        return null;
    }
}
?>
