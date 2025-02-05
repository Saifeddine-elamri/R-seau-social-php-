<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Vérifier que les données du formulaire sont envoyées
if (isset($_POST['friend_id']) && isset($_POST['message'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['friend_id'];
    $message = $_POST['message'];

    // Insérer le message dans la base de données
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$sender_id, $receiver_id, $message]);

    // Rediriger vers la page de profil ou une page de confirmation
    header("Location: profil.php?message=Message sent!");
    exit();
} else {
    // Si les données ne sont pas présentes, rediriger ou afficher un message d'erreur
    header("Location: profil.php?error=Please fill in all fields.");
    exit();
}
?>
