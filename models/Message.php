<?php

class Message {

    // Récupérer les contacts d'un utilisateur
    public static function getContacts($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("
        SELECT DISTINCT u.id, u.username, u.profile_image
        FROM users u
        JOIN friends f ON (u.id = f.user_id OR u.id = f.friend_id)
        WHERE (f.friend_id = ? OR f.user_id = ?) 
        AND u.id != ? 
        AND f.status = 'accepted'
        ORDER BY u.username ASC
        ");
        $stmt->execute([$user_id, $user_id, $user_id]);
        return $stmt->fetchAll();
    }

    // Récupérer les messages entre deux utilisateurs
    public static function getMessages($user_id, $contact_id) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT m.*, 
                   sender.username AS sender_username, sender.profile_image AS sender_image, 
                   receiver.username AS receiver_username, receiver.profile_image AS receiver_image
            FROM messages m
            JOIN users sender ON m.sender_id = sender.id
            JOIN users receiver ON m.receiver_id = receiver.id
            WHERE (m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?)
            ORDER BY m.created_at ASC
        ");
        $stmt->execute([$user_id, $contact_id, $contact_id, $user_id]);
        return $stmt->fetchAll();
    }

    // Enregistrer un message dans la base de données
    public static function sendMessage($sender_id, $receiver_id, $message, $image_name) {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO messages (sender_id, receiver_id, message, image, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$sender_id, $receiver_id, $message, $image_name]);
    }

    // Gérer l'upload d'image
    public static function handleImageUpload() {
        if (empty($_FILES['image']['name'])) {
            return null; // Aucun fichier n'a été téléchargé
        }

        // Définir le répertoire et le nom du fichier
        $target_dir = __DIR__ . '/../uploads/';
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        // Vérifier l'extension du fichier (jpg, jpeg, png, gif)
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types) && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            return $image_name; // Retourne le nom du fichier si l'upload est réussi
        }

        return null; // Si l'upload échoue ou si le fichier est invalide
    }
}
?>
