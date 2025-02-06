<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

// Vérifie si l'utilisateur est connecté
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Vérifie si les données du formulaire sont envoyées
if (isset($_POST['receiver_id']) && isset($_POST['message'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = trim($_POST['message']); // Supprime les espaces inutiles

    // Vérifie que le message n'est pas vide
    if (!empty($message)) {
        try {
            // Insère le message dans la base de données
            $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$sender_id, $receiver_id, $message]);

            // Redirige vers la conversation après l'envoi du message
            header("Location: messages.php?contact_id=" . $receiver_id);
            exit();
        } catch (PDOException $e) {
            // En cas d'erreur SQL, redirige avec un message d'erreur
            header("Location: messages.php?contact_id=" . $receiver_id . "&error=Database%20error.");
            exit();
        }
    } else {
        // Redirige si le message est vide
        header("Location: messages.php?contact_id=" . $receiver_id . "&error=Please%20enter%20a%20message.");
        exit();
    }
} else {
    // Redirige si la requête est invalide
    header("Location: messages.php?error=Invalid%20request.");
    exit();
}
?>
