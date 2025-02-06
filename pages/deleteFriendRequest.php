<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['friend_id'])) {
    $friendId = intval($_POST['friend_id']);

    // Vérifier que la demande existe et que l'utilisateur connecté est bien le destinataire
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE user_id = ? AND friend_id = ? AND status = 'pending'");
    $stmt->execute([$friendId, $_SESSION['user_id']]);
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($request) {
        // Supprimer la demande d'ami
        $stmt = $pdo->prepare("DELETE FROM friends WHERE user_id = ? AND friend_id = ? AND status = 'pending'");
        $stmt->execute([$friendId, $_SESSION['user_id']]);

        $_SESSION['message'] = "Friend request rejected.";
    } else {
        $_SESSION['message'] = "No pending friend request found.";
    }
}

// Redirection vers la page des demandes d'amis
header("Location: friend-requests.php");
exit();
?>
