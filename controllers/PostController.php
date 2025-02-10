<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Like.php';
require_once __DIR__ . '/../models/Comment.php';

class PostController {

    // Afficher tous les posts
    public function index() {
        $posts = Post::getAll();
        require_once __DIR__ . '/../views/posts.php';
    }

    // Ajouter un nouveau post
    public function addPost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
            session_start();
            $user_id = $_SESSION['user_id'];
            $content = trim($_POST['content']);
            $image = $_FILES['post_image']['name'] ?? null;
            $video = $_FILES['post_video']['name'] ?? null;

            if (!empty($content)) {
                try {
                    // Ajouter le post
                    Post::add($user_id, $content, $image, $video);
                    header("Location: posts"); // Rediriger après ajout
                    exit();
                } catch (Exception $e) {
                    // Afficher l'erreur si le téléchargement ou la création du post échoue
                    $_SESSION['error_message'] = $e->getMessage();
                    header("Location: add_post"); // Rediriger pour afficher l'erreur
                    exit();
                }
            } else {
                $_SESSION['error_message'] = 'Le contenu du post ne peut pas être vide.';
                header("Location: add_post"); // Rediriger si le contenu est vide
                exit();
            }
        }
    }
}
?>
