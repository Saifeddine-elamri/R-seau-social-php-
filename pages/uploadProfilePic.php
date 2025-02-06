<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $userId = $_SESSION['user_id'];
    $file = $_FILES['profile_pic'];

    // Vérifier le type de fichier
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        $_SESSION['message'] = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        header("Location: profil-info.php");
        exit();
    }

    // Générer un nom de fichier unique
    $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = "profile_" . $userId . "_" . time() . "." . $fileExt;
    $uploadPath = "../uploads/" . $fileName;

    // Déplacer le fichier vers le dossier uploads
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // Mettre à jour l'image de profil dans la base de données
        $stmt = $pdo->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
        $stmt->execute([$fileName, $userId]);

        $_SESSION['message'] = "Profile picture updated successfully!";
    } else {
        $_SESSION['message'] = "Error uploading the file.";
    }
}

header("Location: profil-info.php");
exit();
?>
