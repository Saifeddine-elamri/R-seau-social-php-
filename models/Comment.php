<?php
class Comment {
    public static function addComment($userId, $postId, $content) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO comments (user_id, post_id, content, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$userId, $postId, htmlspecialchars($content)]);
    }

    public static function getCommentsByPostId($postId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at ASC");
        $stmt->execute([$postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
