<?php
class Like {
    /**
     * Fonction pour ajouter ou retirer un "like" d'un post.
     * Si l'utilisateur a déjà aimé le post, le like est supprimé.
     * Si l'utilisateur n'a pas encore aimé le post, un like est ajouté.
     *
     * @param int $post_id L'ID du post sur lequel l'utilisateur ajoute ou retire un like.
     * @param int $user_id L'ID de l'utilisateur qui aime ou retire son like.
     * @return bool Retourne vrai en cas de succès, faux sinon.
     */
    public static function toggleLike(int $post_id, int $user_id): bool {
        global $pdo;
        
        // Vérifier si l'utilisateur a déjà aimé ce post
        $stmt = $pdo->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$post_id, $user_id]);
        $like = $stmt->fetch();

        // Si le like existe, le retirer de la base de données
        if ($like) {
            $stmt = $pdo->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
            return $stmt->execute([$post_id, $user_id]);
        } else {
            // Sinon, ajouter un nouveau like
            $stmt = $pdo->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
            return $stmt->execute([$post_id, $user_id]);
        }
    }

    /**
     * Fonction pour obtenir le nombre de likes d'un post.
     *
     * @param int $post_id L'ID du post pour lequel on souhaite compter les likes.
     * @return int Le nombre de likes pour ce post.
     */
    public static function countLikes(int $post_id): int {
        global $pdo;

        // Récupérer le nombre de likes pour un post donné
        $stmt = $pdo->prepare("SELECT COUNT(*) as like_count FROM likes WHERE post_id = ?");
        $stmt->execute([$post_id]);

        // Retourner le nombre de likes
        return (int) $stmt->fetch()['like_count'];
    }
}
?>
