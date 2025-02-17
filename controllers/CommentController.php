<?php
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/CommentReply.php';

class CommentController {

    /**
     * Méthode pour ajouter un commentaire sur un post.
     * Vérifie si l'utilisateur est connecté, valide les données du formulaire,
     * puis enregistre le commentaire dans la base de données.
     */
    public static function addComment() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            header("Location: ../login.php");
            exit();
        }

        // Vérifier si le formulaire est soumis en méthode POST et si les paramètres nécessaires sont présents
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_post'], $_POST['post_id'], $_POST['comment_content'])) {
            
            // Récupérer les données du formulaire et les nettoyer
            $userId = $_SESSION['user_id'];  // ID de l'utilisateur connecté
            $postId = intval($_POST['post_id']);  // ID du post (s'assurer que c'est un entier)
            $content = trim($_POST['comment_content']);  // Contenu du commentaire (enlever les espaces superflus)

            // Valider que le contenu du commentaire n'est pas vide
            if (!empty($content)) {
                // Ajouter le commentaire dans la base de données
                Comment::addComment($userId, $postId, $content);
            } else {
                // Si le contenu est vide, on peut ajouter un message d'erreur ou un traitement particulier
                $_SESSION['error_message'] = "Le commentaire ne peut pas être vide.";
            }

            // Rediriger l'utilisateur vers la page précédente après avoir ajouté le commentaire
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    public static function addReply() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            header("Location: ../login.php");
            exit();
        }

        // Vérifier si le formulaire est soumis en méthode POST et si les paramètres nécessaires sont présents
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'], $_POST['reply_content'])) {
            
            // Récupérer les données du formulaire et les nettoyer
            $userId = $_SESSION['user_id'];  // ID de l'utilisateur connecté
            $commentId = intval($_POST['comment_id']);  // ID du commentaire auquel on répond (s'assurer que c'est un entier)
            $content = trim($_POST['reply_content']);  // Contenu de la réponse (enlever les espaces superflus)

            // Valider que le contenu de la réponse n'est pas vide
            if (!empty($content)) {
                // Ajouter la réponse dans la base de données
                CommentReply::addReply($userId, $commentId, $content);
            } else {
                // Si le contenu est vide, on peut ajouter un message d'erreur ou un traitement particulier
                $_SESSION['error_message'] = "La réponse ne peut pas être vide.";
            }

            // Rediriger l'utilisateur vers la page précédente après avoir ajouté la réponse
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }








}
?>
