<?php

class Friend {

    /**
     * Fonction pour exécuter des requêtes préparées avec gestion des erreurs.
     * Cette méthode simplifie l'exécution des requêtes préparées tout en gérant les erreurs.
     *
     * @param string $query La requête SQL à exécuter.
     * @param array $params Les paramètres à lier à la requête SQL (par défaut, un tableau vide).
     * @return mixed Le statement préparé ou false en cas d'erreur.
     */
    private static function executeQuery(string $query, array $params = []) {
        global $pdo;
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            return $stmt;  // Retourner le statement exécuté.
        } catch (PDOException $e) {
            // Enregistrer l'erreur dans le log pour la gestion des erreurs.
            error_log("PDO Error: " . $e->getMessage());
            return false;  // Retourner false en cas d'erreur pour indiquer l'échec.
        }
    }

    /**
     * Récupérer la liste des amis d'un utilisateur.
     *
     * @param int $user_id L'ID de l'utilisateur dont on souhaite récupérer les amis.
     * @return array Liste des amis avec les informations nécessaires.
     */
    public static function getFriends(int $user_id): array {
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
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];  // Retourner la liste des amis ou un tableau vide en cas d'échec.
    }

    /**
     * Supprimer un ami de la liste d'amis.
     * Cette méthode supprime la relation d'amitié entre deux utilisateurs.
     *
     * @param int $user_id L'ID de l'utilisateur qui souhaite supprimer l'ami.
     * @param int $friend_id L'ID de l'ami à supprimer.
     * @return bool Retourne true si l'opération réussit, false sinon.
     */
    public static function removeFriend(int $user_id, int $friend_id): bool {
        $query = "
            DELETE FROM friends 
            WHERE (user_id = ? AND friend_id = ?) 
               OR (user_id = ? AND friend_id = ?)
        ";
        return self::executeQuery($query, [$user_id, $friend_id, $friend_id, $user_id]) ? true : false;  // Retourne true si la suppression est réussie.
    }

    /**
     * Récupérer les demandes d'amis en attente pour un utilisateur.
     * 
     * @param int $user_id L'ID de l'utilisateur pour lequel récupérer les demandes en attente.
     * @return array Liste des demandes d'amis en attente.
     */
    public static function getPendingRequests(int $user_id): array {
        $query = "SELECT * FROM friends WHERE friend_id = ? AND status = 'pending'";
        $stmt = self::executeQuery($query, [$user_id]);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];  // Retourner un tableau des demandes ou un tableau vide en cas d'échec.
    }

    /**
     * Accepter une demande d'ami d'un autre utilisateur.
     * Cette méthode met à jour la relation de l'ami dans la base de données.
     *
     * @param int $user_id L'ID de l'utilisateur qui accepte la demande.
     * @param int $friend_id L'ID de l'ami dont la demande est acceptée.
     * @return bool Retourne true si la demande a été acceptée, false sinon.
     */
    public static function acceptFriendRequest(int $user_id, int $friend_id): bool {
        $query = "UPDATE friends SET status = 'accepted' WHERE user_id = ? AND friend_id = ? AND status = 'pending'";
        $stmt = self::executeQuery($query, [$friend_id, $user_id]);
        return $stmt ? true : false;  // Retourne true si la mise à jour a réussi, sinon false.
    }

    /**
     * Rejeter une demande d'ami d'un autre utilisateur.
     * Cette méthode supprime la demande d'ami dans la base de données.
     *
     * @param int $user_id L'ID de l'utilisateur qui rejette la demande.
     * @param int $friend_id L'ID de l'ami dont la demande est rejetée.
     * @return bool Retourne true si la demande a été rejetée, false sinon.
     */
    public static function rejectFriendRequest(int $user_id, int $friend_id): bool {
        $query = "DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) AND status = 'pending'";
        $stmt = self::executeQuery($query, [$friend_id, $user_id]);
        return $stmt ? true : false;  // Retourne true si la suppression a réussi, sinon false.
    }

}
?>
