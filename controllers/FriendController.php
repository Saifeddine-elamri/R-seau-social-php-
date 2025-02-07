<?php

require_once __DIR__ . '/../models/Friend.php';

class FriendController {


    // Afficher la liste des amis
    public function index() {
        if (!isLoggedIn()) {
            header("Location: login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $friends = Friend::getFriends($user_id);

        require_once __DIR__ . '/../views/friends.php';
    }

    // Supprimer un ami
    public function removeFriend() {
        if (!isLoggedIn() || empty($_POST['friend_id'])) {
            header("Location: friends");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $friend_id = $_POST['friend_id'];

        Friend::removeFriend($user_id, $friend_id);

        header("Location: friends");
        exit();
    }

    
        // Afficher les demandes d'amis
        public function showRequests() {
            // Vérifier si l'utilisateur est connecté
            if (!isLoggedIn()) {
                header("Location: login.php");
                exit();
            }
    
            $user_id = $_SESSION['user_id'];
    
            // Récupérer les demandes en attente
            $requests = Friend::getPendingRequests($user_id);
    
            // Afficher la vue des demandes d'amis
            require_once __DIR__ . '/../views/friend-requests.php';
        }
    
        // Accepter une demande d'ami
        public function acceptRequest() {
            if (!isLoggedIn()) {
                header("Location: login.php");
                exit();
            }
    
            $user_id = $_SESSION['user_id'];
            $friend_id = $_POST['friend_id'];
    
            // Accepter la demande
            $result = Friend::acceptFriendRequest($user_id, $friend_id);
    
            if ($result) {
                // Rediriger vers la page des demandes d'amis après avoir accepté
                header("Location: /friend-requests");
            } else {
                // Gérer l'erreur (par exemple, la demande n'existe pas ou elle est déjà acceptée)
                echo "Error accepting friend request.";
            }
        }
    
        // Rejeter une demande d'ami
        public function rejectRequest() {
            if (!isLoggedIn()) {
                header("Location: login");
                exit();
            }
    
            $user_id = $_SESSION['user_id'];
            $friend_id = $_POST['friend_id'];
    
            // Rejeter la demande
            $result = Friend::rejectFriendRequest($user_id, $friend_id);
    
            if ($result) {
                // Rediriger vers la page des demandes d'amis après avoir rejeté
                header("Location: /friend-requests");
            } else {
                // Gérer l'erreur (par exemple, la demande n'existe pas)
                echo "Error rejecting friend request.";
            }
        }
    
    






}
?>
