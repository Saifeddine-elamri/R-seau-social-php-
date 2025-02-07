<?php

require_once __DIR__ . '/../models/User.php';

class UserController {

    public function showAllUsers() {
        // Vérification de l'utilisateur connecté
        if (!isLoggedIn()) {
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];

        // Récupérer les amis et les demandes en attente
        $friends = User::getFriends($user_id);
        $friend_ids = array_column($friends, 'id'); // Liste des IDs des amis

        // Récupérer les demandes en attente
        $pendingRequests = User::getPendingRequests($user_id);

        // Récupérer tous les utilisateurs sauf l'utilisateur connecté
        $users = User::getAllUsers($user_id);

        // Charger la vue avec les données nécessaires
        require_once __DIR__ . '/../views/users.php';
    }
    public function addFriend() {
        // Vérification de l'utilisateur connecté
        if (!isLoggedIn()) {
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $friend_id = $_POST['friend_id'];

        // Ajouter un ami
        $result = User::addFriend($user_id, $friend_id);

        if ($result) {
            // Rediriger après l'ajout de l'ami
            header("Location: /users");
        } else {
            // Gérer les erreurs (demande déjà existante)
            echo "You have already sent a friend request to this user.";
        }
    }


    public function cancelFriendRequest() {
        // Vérification de l'utilisateur connecté
        if (!isLoggedIn()) {
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $friend_id = $_POST['friend_id'];

        // Annuler la demande d'ami
        $result = User::cancelFriendRequest($user_id, $friend_id);

        if ($result) {
            // Rediriger vers la liste des utilisateurs après l'annulation
            header("Location: /users");
        } else {
            // Gérer les erreurs (par exemple, la demande n'existe pas ou elle n'est pas en attente)
            echo "You cannot cancel a request that doesn't exist or isn't pending.";
        }
    }












}
?>
