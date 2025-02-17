<?php
class CommentReply {
    // Méthode pour obtenir les réponses d'un commentaire
    public static function getRepliesByCommentId($commentId) {
        // Connexion à la base de données
        global $pdo;
        
        // Requête pour récupérer les réponses du commentaire
        $query = "SELECT * FROM comment_replies WHERE comment_id = :comment_id ORDER BY created_at ASC";
        
        // Préparation et exécution de la requête
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Retourne les résultats sous forme de tableau
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


        // Méthode pour ajouter une réponse à un commentaire
    public static function addReply($userId, $commentId, $content) {
        global $pdo;

        // Requête SQL pour insérer une réponse
        $query = "INSERT INTO comment_replies (user_id, comment_id, content, created_at) 
                    VALUES (:user_id, :comment_id, :content, NOW())";
        
        // Préparation et exécution de la requête
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        
        // Exécution de la requête
        return $stmt->execute();
    }
    
    
}
