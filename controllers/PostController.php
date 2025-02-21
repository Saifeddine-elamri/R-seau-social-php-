<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Like.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../core/View.php'; 

class PostController {

    /**
     * Affiche tous les posts
     */
    public function index() {
        // Récupérer tous les posts depuis le modèle
        $posts = Post::getAll();

        
        // Afficher la vue des posts
        View::render('posts/index', ['posts' => $posts]);
    }

    /**
     * Ajouter un nouveau post
     */
    public function addPost() {
        // Vérifier si la requête est de type POST et que le contenu est défini
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
            // Démarrer la session et récupérer l'ID de l'utilisateur connecté
            session_start();
            $user_id = $_SESSION['user_id'];
            $content = trim($_POST['content']); // Contenu du post
            $image = $_FILES['post_image']['name'] ?? null; // Nom de l'image si elle existe
            $video = $_FILES['post_video']['name'] ?? null; // Nom de la vidéo si elle existe

            // Vérifier que le contenu du post n'est pas vide
            if (!empty($content)) {
                try {
                    // Ajouter le post dans la base de données via le modèle
                    Post::add($user_id, $content, $image, $video);
                    // Rediriger vers la page des posts après ajout réussi
                    header("Location: posts");
                    exit();
                } catch (Exception $e) {
                    // En cas d'erreur lors de l'ajout du post ou du téléchargement de fichiers
                    $_SESSION['error_message'] = $e->getMessage();
                    // Rediriger vers la page d'ajout du post avec le message d'erreur
                    header("Location: add-post");
                    exit();
                }
            } else {
                // En cas de contenu vide
                $_SESSION['error_message'] = 'Le contenu du post ne peut pas être vide.';
                // Rediriger vers la page d'ajout du post
                header("Location: add_post");
                exit();
            }
        }
    }
}
?>
