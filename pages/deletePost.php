<?php
session_start();

include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Vérifier si l'ID du post est passé en POST
if (isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
    $postId = $_POST['post_id'];

    // Vérifier si l'utilisateur est bien le propriétaire du post
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
    $stmt->execute([$postId, $_SESSION['user_id']]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        // Supprimer le post
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$postId]);
        
        // Redirection vers la page d'accueil après suppression
        header("Location: home.php");
        exit();
    }
}

// Si le post n'existe pas ou si l'utilisateur n'a pas l'autorisation, on le redirige
header("Location: home.php");
exit();
