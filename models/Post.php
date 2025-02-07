<?php
class Post {
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
