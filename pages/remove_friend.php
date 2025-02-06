<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || !isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Vérifier si la requête est POST et contient un ID valide
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['friend_id'])) {
    $friend_id = filter_var($_POST['friend_id'], FILTER_VALIDATE_INT);

    if ($friend_id && $friend_id !== $user_id) { // Vérification supplémentaire pour éviter la suppression de soi-même
        if (removeFriend($user_id, $friend_id)) {
            $_SESSION['message'] = "Ami supprimé avec succès.";
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression de l'ami.";
        }
    } else {
        $_SESSION['message'] = "ID d'ami invalide.";
    }
} else {
    $_SESSION['message'] = "Requête invalide.";
}

// Redirection vers la liste d'amis
header("Location: friends");
exit();
?>
