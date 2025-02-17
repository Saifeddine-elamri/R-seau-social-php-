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
    public static function toggleLike(int $post_id, int $user_id, string $emoji_type): bool {
        global $pdo;
        
        // Vérifier si l'utilisateur a déjà aimé ce post
        $stmt = $pdo->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$post_id, $user_id]);
        $like = $stmt->fetch();
    
        // Si le like existe, le retirer de la base de données
        if ($like) {
            // Si l'emoji est le même, retirer le like
            if ($like['emoji_type'] === $emoji_type) {
                $stmt = $pdo->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
                return $stmt->execute([$post_id, $user_id]);
            } else {
                // Si l'emoji est différent, mettre à jour l'emoji
                $stmt = $pdo->prepare("UPDATE likes SET emoji_type = ? WHERE post_id = ? AND user_id = ?");
                return $stmt->execute([$emoji_type, $post_id, $user_id]);
            }
        } else {
            // Sinon, ajouter un nouveau like avec l'emoji
            $stmt = $pdo->prepare("INSERT INTO likes (post_id, user_id, emoji_type) VALUES (?, ?, ?)");
            return $stmt->execute([$post_id, $user_id, $emoji_type]);
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
    
    public static function getUserEmojiForPost(int $post_id, int $user_id) {
        global $pdo;

        // Récupérer l'emoji associé au post et à l'utilisateur
        $stmt = $pdo->prepare("SELECT emoji_type FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$post_id, $user_id]);
        $like = $stmt->fetch();

        // Si un like est trouvé, retourner l'emoji, sinon retourner un emoji par défaut
        return $like ? $like['emoji_type'] : null;
    }
    
    public static function getTopEmojisByPostId($post_id) {
        global $pdo;
        
        // Sélectionner les emojis les plus utilisés pour ce post
        $stmt = $pdo->prepare("
            SELECT emoji_type, COUNT(*) AS emoji_count
            FROM likes
            WHERE post_id = ?
            GROUP BY emoji_type
            ORDER BY emoji_count DESC
            LIMIT 2
        ");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll();
    }
    

















}
?>
