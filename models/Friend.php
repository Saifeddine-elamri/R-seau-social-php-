<?php

class Friend {


    // Récupérer la liste des amis
    public static function getFriends($user_id) {
        global $pdo;
    
        $stmt = $pdo->prepare("
            SELECT DISTINCT u.id, u.username, u.email, u.profile_image
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
    

    // Supprimer un ami
    public static function removeFriend($user_id, $friend_id) {
        global $pdo;

        $stmt = $pdo->prepare("
            DELETE FROM friends 
            WHERE (user_id = ? AND friend_id = ?) 
               OR (user_id = ? AND friend_id = ?)
        ");
        $stmt->execute([$user_id, $friend_id, $friend_id, $user_id]);
    }

        // Récupérer les demandes d'amis en attente
        public static function getPendingRequests($user_id) {
            global $pdo;
            
            // Récupérer toutes les demandes d'amis en attente
            $stmt = $pdo->prepare("SELECT * FROM friends WHERE friend_id = ? AND status = 'pending'");
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        // Accepter une demande d'ami
        public static function acceptFriendRequest($user_id, $friend_id) {
            global $pdo;
    
            // Mettre à jour la demande pour qu'elle soit acceptée
            $stmt = $pdo->prepare("UPDATE friends SET status = 'accepted' WHERE user_id = ? AND friend_id = ? AND status = 'pending'");
            return $stmt->execute([$friend_id, $user_id]);
        }
    
        // Rejeter une demande d'ami
        public static function rejectFriendRequest($user_id, $friend_id) {
            global $pdo;
    
            // Supprimer la demande
            $stmt = $pdo->prepare("DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) AND status = 'pending'");
            return $stmt->execute([$friend_id, $user_id]);
        }
    
        
    



}
?>
