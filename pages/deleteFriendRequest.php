<?php
session_start();
include '../includes/db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Vérifier si une demande d'ami doit être supprimée
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $friendId = $_POST['friend_id'];

    // Vérifier si une demande d'ami en attente existe
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE user_id = ? AND friend_id = ? AND status = 'pending'");
    $stmt->execute([$_SESSION['user_id'], $friendId]);
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($request) {
        // Supprimer la demande d'ami
        $stmt = $pdo->prepare("DELETE FROM friends WHERE user_id = ? AND friend_id = ? AND status = 'pending'");
        $stmt->execute([$_SESSION['user_id'], $friendId]);

        // Rediriger vers le profil après suppression
        header("Location: profil.php"); // Assurez-vous que la page profil.php est correcte
        exit(); // Toujours appeler exit() après une redirection pour stopper l'exécution du script
    } else {
        echo "No pending friend request found."; // Affichage d'un message si aucune demande n'est trouvée
    }
}
?>
