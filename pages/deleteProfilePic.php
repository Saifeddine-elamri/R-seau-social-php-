<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user = getUserById($_SESSION['user_id']);

if (!empty($user['profile_image'])) {
    $filePath = '../uploads/' . $user['profile_image'];

    // Supprimer l'image du dossier
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Mettre à jour la base de données pour supprimer l'image de profil
    $stmt = $pdo->prepare("UPDATE users SET profile_image = NULL WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
}

// Redirection vers la page de profil
header("Location: profil-info.php");
exit();
?>
