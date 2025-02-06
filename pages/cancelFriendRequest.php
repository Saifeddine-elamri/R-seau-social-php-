<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['friend_id'])) {
    $friend_id = intval($_POST['friend_id']);
    $user_id = $_SESSION['user_id'];

    // Vérifier si la demande existe
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE user_id = ? AND friend_id = ? AND status = 'pending'");
    $stmt->execute([$user_id, $friend_id]);
    $friendRequest = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($friendRequest) {
        // Supprimer la demande d'ami
        $stmt = $pdo->prepare("DELETE FROM friends WHERE user_id = ? AND friend_id = ? AND status = 'pending'");
        if ($stmt->execute([$user_id, $friend_id])) {
            $_SESSION['message'] = "Friend request canceled successfully.";
        } else {
            $_SESSION['message'] = "Error canceling friend request.";
        }
    } else {
        $_SESSION['message'] = "No pending friend request found.";
    }
}

header("Location: all-users.php");
exit();
?>
