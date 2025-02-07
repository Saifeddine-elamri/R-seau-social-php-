<?php

class Message {
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

    public static function getMessages($user_id, $contact_id) {
        global $pdo;
        $stmt=$pdo->prepare("
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

    public static function sendMessage($sender_id, $receiver_id, $message, $image_name) {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO messages (sender_id, receiver_id, message, image, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$sender_id, $receiver_id, $message, $image_name]);
    }





}
?>
