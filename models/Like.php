<?php
class Like {
    public static function toggleLike($post_id, $user_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$post_id, $user_id]);
        $like = $stmt->fetch();

        if ($like) {
            $stmt = $pdo->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
            return $stmt->execute([$post_id, $user_id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
            return $stmt->execute([$post_id, $user_id]);
        }
    }

    public static function countLikes($post_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT COUNT(*) as like_count FROM likes WHERE post_id = ?");
        $stmt->execute([$post_id]);
        return $stmt->fetch()['like_count'];
    }
}
?>
