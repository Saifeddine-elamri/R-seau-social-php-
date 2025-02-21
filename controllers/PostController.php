<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Like.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../core/View.php'; 
require_once __DIR__ . '/../core/Session.php'; 
require_once __DIR__ . '/../core/Redirect.php'; 

class PostController {

    /**
     * Affiche tous les posts
     */
    public function index() {
        // Démarrer la session pour vérifier les messages d'erreur, si nécessaire
        Session::start();

        // Récupérer tous les posts depuis le modèle
        $posts = Post::getAll();

        // Vérifier s'il y a des messages d'erreur et les récupérer
        $errorMessage = Session::get('error_message');

        // Afficher la vue des posts et passer les posts et le message d'erreur (le cas échéant)
        View::render('posts/index', [
            'posts' => $posts,
            'error_message' => $errorMessage
        ]);

        // Supprimer le message d'erreur après l'affichage (pour ne pas l'afficher à nouveau)
        Session::set('error_message', null);
    }

    /**
     * Ajouter un nouveau post
     */
    public function addPost() {
        // Vérifier si la requête est de type POST et que le contenu est défini
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
            // Démarrer la session
            Session::start();
            
            // Récupérer l'ID de l'utilisateur connecté depuis la session
            $user_id = Session::get('user_id');
            
            // Récupérer les données du formulaire
            $content = trim($_POST['content']); // Contenu du post
            $image = $_FILES['post_image']['name'] ?? null; // Nom de l'image si elle existe
            $video = $_FILES['post_video']['name'] ?? null; // Nom de la vidéo si elle existe

            // Vérifier que le contenu du post n'est pas vide
            if (!empty($content)) {
                try {
                    // Ajouter le post dans la base de données via le modèle
                    Post::add($user_id, $content, $image, $video);
                    // Rediriger vers la page des posts après ajout réussi
                    Redirect::to("posts");
                    exit();
                } catch (Exception $e) {
                    // En cas d'erreur lors de l'ajout du post ou du téléchargement de fichiers
                    Session::set('error_message', $e->getMessage());
                    // Rediriger vers la page d'ajout du post avec le message d'erreur
                    Redirect::to("add-post");
                    exit();
                }
            } else {
                // En cas de contenu vide
                Session::set('error_message', 'Le contenu du post ne peut pas être vide.');
                // Rediriger vers la page d'ajout du post
                Redirect::to("add_post");
                exit();
            }
        }
    }
}
?>
