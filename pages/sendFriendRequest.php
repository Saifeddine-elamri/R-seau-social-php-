<?php
session_start();
include '../includes/db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $friendId = $_POST['friend_id'];

    // Vérifier que la demande n'a pas déjà été envoyée
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE user_id = ? AND friend_id = ?");
    $stmt->execute([$_SESSION['user_id'], $friendId]);
    $existingRequest = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingRequest) {
        echo "You have already sent a friend request to this user.";
    } else {
        // Ajouter la demande d'amitié avec le statut 'pending'
        $stmt = $pdo->prepare("INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'pending')");
        $stmt->execute([$_SESSION['user_id'], $friendId]);

        echo "Friend request sent!";
    }

    // Rediriger l'utilisateur vers sa page de profil après avoir envoyé la demande
    header("Location: profil.php");
    exit();
}
?>
