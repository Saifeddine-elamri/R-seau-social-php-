<?php
require_once __DIR__ . '/../models/Like.php';

class LikeController {
    public function likePost() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
            $post_id = $_POST['post_id'];
            $user_id = $_SESSION['user_id'];
            Like::toggleLike($post_id, $user_id);
            header("Location: posts");
            exit();
        }
    }
}
?>
