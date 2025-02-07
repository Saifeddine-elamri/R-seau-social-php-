<?php
class Post {

        // Ajouter un nouveau post
        public static function createPost($userId, $content, $image = null) {
            global $pdo;
            $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$userId, $content, $image]);
        }
    
        // Récupérer tous les posts d'un utilisateur
        public static function getPostsByUserId($userId) {
            global $pdo;
            $stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public static function add($user_id, $content, $image = null, $video = null) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image, video, created_at) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$user_id, $content, $image, $video]);
    }
}
?>
