<?php

class LikeComment {

    /**
     * Méthode pour ajouter ou retirer un like sur un commentaire.
     * Cette méthode vérifie si l'utilisateur a déjà liké le commentaire.
     * Si oui, elle retire le like ; sinon, elle l'ajoute.
     */
    public static function toggleLike($comment_id, $user_id, $emoji_type) {
        global $pdo;
        // Vérifier si l'utilisateur a déjà liké ce commentaire
        $stmt = $pdo->prepare('SELECT * FROM comment_likes WHERE user_id = ? AND comment_id = ?');
        $stmt->execute([$user_id, $comment_id]);

        if ($stmt->rowCount() > 0) {
            // Si l'utilisateur a déjà liké ce commentaire, on retire le like
            $stmt = $pdo->prepare('DELETE FROM comment_likes WHERE user_id = ? AND comment_id = ?');
            $stmt->execute([$user_id, $comment_id]);
        } else {
            // Si l'utilisateur n'a pas encore liké ce commentaire, on ajoute le like
            $stmt = $pdo->prepare('INSERT INTO comment_likes (user_id, comment_id, emoji_type) VALUES (?, ?, ?)');
            $stmt->execute([$user_id, $comment_id, $emoji_type]);
        }
    }

    /**
     * Méthode pour récupérer le nombre de likes d'un commentaire.
     * Elle retourne le nombre total de likes (nombre de lignes dans la table `comment_likes`).
     */
    public static function getLikeCountByCommentId($comment_id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM comment_likes WHERE comment_id = ?');
        $stmt->execute([$comment_id]);
        return $stmt->fetchColumn();
    }

    /**
     * Méthode pour récupérer les informations des likes d'un commentaire, par exemple pour afficher les utilisateurs qui ont aimé.
     * Retourne un tableau des utilisateurs qui ont liké ce commentaire.
     */
    public static function getLikesByCommentId($comment_id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT user_id, emoji_type FROM comment_likes WHERE comment_id = ?');
        $stmt->execute([$comment_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
