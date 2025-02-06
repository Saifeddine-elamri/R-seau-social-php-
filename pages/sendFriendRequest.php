<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['friend_id'])) {
    $friendId = intval($_POST['friend_id']);

    if ($friendId <= 0) {
        header("Location: all-users.php");
        exit();
    }

    // Vérifier si une relation existe déjà
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE user_id = ? AND friend_id = ?");
    $stmt->execute([$_SESSION['user_id'], $friendId]);
    $existingRequest = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingRequest) {
        if ($existingRequest['status'] === 'pending') {
            // Si la demande est en attente, permettre l'annulation
            $stmt = $pdo->prepare("DELETE FROM friends WHERE user_id = ? AND friend_id = ?");
            $stmt->execute([$_SESSION['user_id'], $friendId]);
            $_SESSION['message'] = "Friend request cancelled.";
        } else {
            $_SESSION['message'] = "You are already friends with this user.";
        }
    } else {
        // Envoyer une demande d'amitié
        $stmt = $pdo->prepare("INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'pending')");
        $stmt->execute([$_SESSION['user_id'], $friendId]);

        $_SESSION['message'] = "Friend request sent!";
    }
} else {
    $_SESSION['message'] = "Invalid request.";
}

header("Location: all-users.php");
exit();
?>
