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
    
        // Vérification que la requête est bien de type POST, que l'ID du post est fourni et que l'emoji est sélectionné
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'], $_POST['emoji'])) {
    
            // Récupérer l'ID du post, l'ID de l'utilisateur et l'emoji sélectionné depuis le formulaire
            $post_id = $_POST['post_id'];
            $user_id = $_SESSION['user_id'];
            $emoji_type = $_POST['emoji']; // Emoji sélectionné

    
            // Stocker l'emoji et le texte dans la session pour qu'ils soient accessibles dans la vue
            // Appeler la méthode toggleLike pour ajouter ou retirer le like avec l'emoji
            Like::toggleLike($post_id, $user_id, $emoji_type);
    
            // Après l'action, rediriger l'utilisateur vers la liste des posts
            header("Location: /posts"); // Assurez-vous que l'URL de redirection est correcte (ajouter le slash avant 'posts' si nécessaire)
            exit(); // Arrêter l'exécution du script pour éviter tout comportement inattendu après la redirection
        } else {
            // Si la requête n'est pas valide (ex: méthode GET ou post_id ou emoji manquants), rediriger vers la page des posts
            header("Location: /posts");
            exit();
        }
    }
    
}
?>
