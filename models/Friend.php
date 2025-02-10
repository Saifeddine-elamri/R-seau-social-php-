<?php

class Friend {

    // Fonction pour exécuter des requêtes préparées avec gestion des erreurs
    private static function executeQuery($query, $params = []) {
        global $pdo;
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Log de l'erreur ou gestion personnalisée
            error_log("PDO Error: " . $e->getMessage());
            return false;
        }
    }

    // Récupérer la liste des amis
    public static function getFriends($user_id) {
        $query = "
            SELECT DISTINCT u.id, u.username, u.email, u.profile_image
            FROM users u
            JOIN friends f ON (u.id = f.user_id OR u.id = f.friend_id)
            WHERE (f.friend_id = ? OR f.user_id = ?) 
            AND u.id != ? 
            AND f.status = 'accepted'
            ORDER BY u.username ASC
        ";
        $stmt = self::executeQuery($query, [$user_id, $user_id, $user_id]);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    // Supprimer un ami (suppression générique)
    public static function removeFriend($user_id, $friend_id) {
        $query = "
            DELETE FROM friends 
            WHERE (user_id = ? AND friend_id = ?) 
               OR (user_id = ? AND friend_id = ?)
        ";
        return self::executeQuery($query, [$user_id, $friend_id, $friend_id, $user_id]);
    }

    // Récupérer les demandes d'amis en attente
    public static function getPendingRequests($user_id) {
        $query = "SELECT * FROM friends WHERE friend_id = ? AND status = 'pending'";
        $stmt = self::executeQuery($query, [$user_id]);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    // Accepter une demande d'ami
    public static function acceptFriendRequest($user_id, $friend_id) {
        $query = "UPDATE friends SET status = 'accepted' WHERE user_id = ? AND friend_id = ? AND status = 'pending'";
        $stmt = self::executeQuery($query, [$friend_id, $user_id]);
        return $stmt ? true : false;
    }

    // Rejeter une demande d'ami
    public static function rejectFriendRequest($user_id, $friend_id) {
        $query = "DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) AND status = 'pending'";
        $stmt = self::executeQuery($query, [$friend_id, $user_id]);
        return $stmt ? true : false;
    }

}
?>
