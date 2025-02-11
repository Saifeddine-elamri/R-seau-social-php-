<?php

require_once __DIR__ . '/../models/User.php';

class UserController {

    /**
     * Affiche tous les utilisateurs, amis et demandes en attente
     */
    public function showAllUsers() {
        // Vérification de l'utilisateur connecté
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
            exit();
        }

        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $_SESSION['user_id'];

        // Récupérer les amis de l'utilisateur connecté
        $friends = User::getFriends($user_id);
        $friend_ids = array_column($friends, 'id'); // Liste des IDs des amis

        // Récupérer les demandes en attente envoyées par l'utilisateur
        $pendingRequests = User::getPendingRequests($user_id);

        // Récupérer tous les utilisateurs, en excluant l'utilisateur connecté
        $users = User::getAllUsers($user_id);

        // Charger la vue avec les données nécessaires
        require_once __DIR__ . '/../views/users.php';
    }

    /**
     * Ajouter un ami
     */
    public function addFriend() {
        // Vérification de l'utilisateur connecté
        if (!isLoggedIn()) {
            header("Location: login.php");
            exit();
        }

        // Récupérer l'ID de l'utilisateur connecté et l'ID de l'ami
        $user_id = $_SESSION['user_id'];
        $friend_id = $_POST['friend_id'];

        // Ajouter un ami en utilisant la méthode du modèle User
        $result = User::addFriend($user_id, $friend_id);

        // Vérification du résultat et redirection
        if ($result) {
            // Rediriger vers la liste des utilisateurs après ajout
            header("Location: /users");
            exit();
        } else {
            // Afficher un message d'erreur si la demande existe déjà
            $_SESSION['error_message'] = "You have already sent a friend request to this user.";
            header("Location: /users");
            exit();
        }
    }

    /**
     * Annuler une demande d'ami
     */
    public function cancelFriendRequest() {
        // Vérification de l'utilisateur connecté
        if (!isLoggedIn()) {
            header("Location: login.php");
            exit();
        }

        // Récupérer l'ID de l'utilisateur connecté et l'ID de l'ami
        $user_id = $_SESSION['user_id'];
        $friend_id = $_POST['friend_id'];

        // Annuler la demande d'ami via la méthode du modèle User
        $result = User::cancelFriendRequest($user_id, $friend_id);

        // Vérification du résultat et redirection
        if ($result) {
            // Rediriger vers la liste des utilisateurs après annulation
            header("Location: /users");
            exit();
        } else {
            // Afficher un message d'erreur si la demande n'existe pas ou n'est pas en attente
            $_SESSION['error_message'] = "You cannot cancel a request that doesn't exist or isn't pending.";
            header("Location: /users");
            exit();
        }
    }
}
?>
