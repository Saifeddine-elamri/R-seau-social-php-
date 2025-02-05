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

    // Vérifier si une demande d'amitié en attente existe
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE user_id = ? AND friend_id = ? AND status = 'pending'");
    $stmt->execute([$friendId, $_SESSION['user_id']]);
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($request) {
        // Accepter la demande en mettant à jour le statut à "accepted"
        $stmt = $pdo->prepare("UPDATE friends SET status = 'accepted' WHERE user_id = ? AND friend_id = ?");
        $stmt->execute([$friendId, $_SESSION['user_id']]);

        // Ajouter l'inverse pour l'autre utilisateur
        $stmt = $pdo->prepare("UPDATE friends SET status = 'accepted' WHERE user_id = ? AND friend_id = ?");
        $stmt->execute([$_SESSION['user_id'], $friendId]);

        echo "Friend request accepted!";
        header("Location: profil.php");
    } else {
        echo "No pending request found.";
    }
}
?>
