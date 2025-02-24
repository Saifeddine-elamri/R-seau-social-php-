<?php
// Inclusion des fonctions utilitaires
require_once __DIR__ . '/../../includes/utils.php';

// Vérification de l'authentification sinon redirection
isAuthenticated();

// Récupération de l'utilisateur connecté
$User = User::getById($_SESSION['user_id']);
$UserProfileImage = getUserProfileImage($User);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fils d'actualités</title>
    <link rel="stylesheet" type="text/css" href="views/static/css/profil-style.css">
    <link rel="stylesheet" type="text/css" href="views/static/css/posts/comment-item.css">

    <!-- Ajout de la favicon -->
    <link rel="icon" type="image/jpg" href="uploads/logo.jpg">
</head>
<body>

<div class="container">
    <!-- Inclusion du header qui contient la navigation, les liens et autres éléments de la barre supérieure -->
    <?php include 'views/templates/header.php'; ?>

    <div class="container">
        <!-- Affichage du formulaire de création de publication -->
        <?php include 'post-form.php'; ?>

        <!-- Affichage des publications -->
        <?php foreach ($posts as $post): ?>
        <!-- Inclusion de l'élément pour afficher chaque publication -->
        <?php include 'post-item.php'; ?>
        <?php endforeach; ?>
    </div>

    <!-- Inclusion du footer qui contient les informations de bas de page comme les crédits ou les liens supplémentaires -->
    <?php include 'views/templates/footer.php'; ?>
</div>

<script src="views/static/js/profil.js"></script>
<script src="views/static/js/posts/comment-item.js"></script>

</body>
</html>
