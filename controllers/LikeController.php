<?php

// Inclusion du modèle Like pour pouvoir utiliser la fonction liée aux likes
require_once __DIR__ . '/../models/Like.php';

class LikeController {

    /**
     * Gère l'action de liker un post ou de supprimer un like.
     * Cette méthode est appelée lorsque l'utilisateur interagit avec le bouton "J'aime" d'un post.
     * Elle bascule l'état du like (ajoute ou retire le like) selon l'état actuel de celui-ci.
     */
    public function likePost() {
        // Démarrer la session pour accéder aux données de session de l'utilisateur
        session_start();

        // Vérification que la requête est bien de type POST et que l'ID du post est fourni
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
            
            // Récupérer l'ID du post et l'ID de l'utilisateur depuis la session
            $post_id = $_POST['post_id'];
            $user_id = $_SESSION['user_id'];

            // Appeler la méthode toggleLike pour ajouter ou retirer le like
            Like::toggleLike($post_id, $user_id);

            // Après l'action, rediriger l'utilisateur vers la liste des posts
            header("Location: /posts"); // Assurez-vous que l'URL de redirection est correcte (ajouter le slash avant 'posts' si nécessaire)
            exit(); // Arrêter l'exécution du script pour éviter tout comportement inattendu après la redirection
        } else {
            // Si la requête n'est pas valide (ex: méthode GET ou post_id manquant), rediriger vers la page d'accueil ou posts
            header("Location: /posts");
            exit();
        }
    }
}
?>
