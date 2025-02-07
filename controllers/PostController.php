<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Like.php';
require_once __DIR__ . '/../models/Comment.php';

class PostController {
    public function index() {
        $posts = Post::getAll();
        require_once __DIR__ . '/../views/posts.php';
    }

    public function addPost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
            session_start();
            $user_id = $_SESSION['user_id'];
            $content = trim($_POST['content']);
            $image = $_FILES['post_image']['name'] ?? null;
            $video = $_FILES['post_video']['name'] ?? null;

            if (!empty($content)) {
                Post::add($user_id, $content, $image, $video);
                header("Location: posts");
                exit();
            }
        }
    }
}
?>
