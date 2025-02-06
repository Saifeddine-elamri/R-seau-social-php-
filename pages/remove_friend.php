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

    if (removeFriend($user_id, $friend_id)) {
        $_SESSION['message'] = "Friend removed successfully.";
    } else {
        $_SESSION['message'] = "Error removing friend.";
    }
}

header("Location: friends.php");
exit();
?>
