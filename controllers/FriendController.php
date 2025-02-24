<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Friend.php';
require_once __DIR__ . '/../core/View.php'; 
require_once __DIR__ . '/../core/Redirect.php'; 
require_once __DIR__ . '/../core/Session.php'; 
require_once __DIR__ . '/../core/Request.php'; 

class FriendController {

    /**
     * Affiche la liste des amis de l'utilisateur connecté
     */
    public function index() {
        // Vérifier si l'utilisateur est connecté
        if (!(Session::exists('user_id'))) {
            Redirect::to("Location: login");
            exit();
        }

        // Récupérer l'ID de l'utilisateur connecté
        $user_id = Session::get('user_id');
        // Récupérer les amis de l'utilisateur
        $friends = Friend::getFriends($user_id);

        // Afficher la vue des amis
        View::render('friends', ['user_id' => $user_id ,
                                 'friends' => $friends]);

    }

    /**
     * Supprime un ami de la liste d'amis
     */
    public function removeFriend() {
        // Vérifier si l'utilisateur est connecté
        if (!Session::exists('user_id')) {
            Redirect::to("friends");
            exit();
        }
    
        // Récupérer et filtrer l'ID de l'ami via la classe Request
        $friend_id = Request::post('friend_id', FILTER_VALIDATE_INT);
    
        if (!$friend_id) {
            Redirect::to("friends");
            exit();
        }
    
        // Récupérer l'ID de l'utilisateur
        $user_id = Session::get('user_id');
    
        // Supprimer l'ami
        Friend::removeFriend($user_id, $friend_id);
    
        // Rediriger vers la page des amis après suppression
        Redirect::to("friends");
        exit();
    }
    

    /**
     * Affiche les demandes d'amis en attente
     */
    public function showRequests() {
        // Vérifier si l'utilisateur est connecté
        if (!(Session::exists('user_id'))) {
            Redirect::to("login");
            exit();
        }

        // Récupérer l'ID de l'utilisateur
        $user_id = Session::get('user_id');

        // Récupérer les demandes d'amis en attente
        $requests = Friend::getPendingRequests($user_id);

        // Afficher la vue des demandes d'amis
        View::render('friend-requests', ['user_id' => $user_id ,
                                         'requests' => $requests]);
                                            
    }

    /**
     * Accepte une demande d'ami
     */
    public function acceptRequest() {
        // Vérifier si l'utilisateur est connecté
        if (!(Session::exists('user_id'))) {
            Redirect::to("login");
            exit();
        }

        // Vérifier si l'ID de l'ami est fourni dans le formulaire
        if (empty($_POST['friend_id'])) {
            // Si l'ID de l'ami est absent, rediriger l'utilisateur
            Redirect::to("Location: /requests");
            exit();
        }

        // Récupérer l'ID de l'utilisateur et de l'ami
        $user_id = Session::get('user_id');
        $friend_id = $_POST['friend_id'];

        // Accepter la demande d'ami
        $result = Friend::acceptFriendRequest($user_id, $friend_id);

        // Vérifier si la demande a été acceptée avec succès
        if ($result) {
            // Rediriger vers la page des demandes d'amis après l'acceptation
            Redirect::to("Location: /requests");
            exit();
        } else {
            // Afficher une erreur si l'acceptation a échoué (par exemple, demande non trouvée ou déjà acceptée)
            echo "Erreur lors de l'acceptation de la demande d'ami.";
            exit();
        }
    }

    /**
     * Rejette une demande d'ami
     */
    public function rejectRequest() {
        // Vérifier si l'utilisateur est connecté
        if (!isLoggedIn()) {
            Redirect::to("login");
            exit();
        }
    
        // Récupérer et valider l'ID de l'ami via la classe Request
        $friend_id = Request::post('friend_id', FILTER_VALIDATE_INT);
    
        if (!$friend_id) {
            Redirect::to("requests");
            exit();
        }
    
        // Récupérer l'ID de l'utilisateur
        $user_id = Session::get('user_id');
    
        // Rejeter la demande d'ami
        if (Friend::rejectFriendRequest($user_id, $friend_id)) {
            Redirect::to("requests");
            exit();
        } else {
            echo "Erreur : impossible de rejeter la demande d'ami.";
            exit();
        }
    }
    
}
?>
