<?php
class Comment {

    /**
     * Ajouter un commentaire à un post
     *
     * @param int $userId L'ID de l'utilisateur qui ajoute le commentaire
     * @param int $postId L'ID du post sur lequel le commentaire est ajouté
     * @param string $content Le contenu du commentaire
     * @return bool Retourne vrai si le commentaire est ajouté avec succès, sinon faux
     */
    public static function addComment($userId, $postId, $content) {
        global $pdo;

        // Préparer et exécuter la requête d'insertion du commentaire
        $stmt = $pdo->prepare("INSERT INTO comments (user_id, post_id, content, created_at) VALUES (?, ?, ?, NOW())");

        // Utilisation de htmlspecialchars pour éviter les attaques XSS
        $escapedContent = htmlspecialchars($content);

        // Exécuter la requête et retourner le résultat
        return $stmt->execute([$userId, $postId, $escapedContent]);
    }

    /**
     * Récupérer tous les commentaires d'un post donné
     *
     * @param int $postId L'ID du post dont on souhaite récupérer les commentaires
     * @return array Un tableau associatif contenant les commentaires
     */
    public static function getCommentsByPostId($postId) {
        global $pdo;

        // Préparer et exécuter la requête pour récupérer les commentaires d'un post
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at ASC");
        $stmt->execute([$postId]);

        // Retourner les résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        public static function countCommentsByPostId($postId) {
            // Utilisation de la base de données pour compter les commentaires
            // Exemple : SELECT COUNT(*) FROM comments WHERE post_id = :postId
            global $pdo;
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM comments WHERE post_id = ?");
            $stmt->execute([$postId]);
            return $stmt->fetchColumn();
        }
    
    


}
?>
