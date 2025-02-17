<?php
// Inclusion des fonctions utilitaires
require_once __DIR__ . '/../../includes/utils.php';

// Vérification de l'authentification
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
    <title>Mon Profil</title>
    <link rel="stylesheet" type="text/css" href="views/static/css/profil-style.css">
</head>
<body>

<div class="container">
    <?php include 'views/templates/header.php'; ?>
    <div class="container">
        <?php include 'post-form.php'; ?>
        <!-- Affichage des publications -->
        <?php foreach ($posts as $post): ?>
            <?php include 'post-item.php'; ?>
        <?php endforeach; ?>
    </div>
    <?php include 'views/templates/footer.php'; ?>
</div>

<script src="views/static/js/profil.js"></script>
</body>
</html>
