<?php
require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/User.php';

class MessageController {

    /**
     * Vérifie si l'utilisateur est connecté
     * Redirige vers la page de connexion si non connecté
     */
    private function checkLogin() {
        if (!isLoggedIn()) {
            header("Location: login");
            exit();
        }
    }

    /**
     * Affiche la liste des contacts et des messages
     */
    public function index() {
        $this->checkLogin(); // Vérification de la connexion

        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $_SESSION['user_id'];

        // Récupérer la liste des contacts de l'utilisateur
        $contacts = Message::getContacts($user_id);

        // Vérifier si un contact est sélectionné dans l'URL (paramètre 'contact_id')
        $selected_contact = isset($_GET['contact_id']) ? $_GET['contact_id'] : null;
        $messages = [];

        // Si un contact est sélectionné, récupérer les messages échangés avec ce contact
        if ($selected_contact) {
            $messages = Message::getMessages($user_id, $selected_contact);
        }

        // Inclure la vue des messages (contacts et messages)
        include __DIR__ . '/../views/messages.php';
    }

    /**
     * Envoie un message à un contact
     */
    public function sendMessage() {
        $this->checkLogin(); // Vérification de la connexion

        // Récupérer l'ID de l'utilisateur connecté et l'ID du destinataire
        $user_id = $_SESSION['user_id'];
        $receiver_id = $_POST['receiver_id'];

        // Récupérer le message envoyé et vérifier qu'il n'est pas vide
        $message = !empty($_POST['message']) ? trim($_POST['message']) : null;

        // Appeler la méthode pour gérer l'upload d'image (si applicable)
        $image_name = Message::handleImageUpload();

        // Si le message est valide, l'envoyer
        if ($message) {
            $result = Message::sendMessage($user_id, $receiver_id, $message, $image_name);

            if ($result) {
                // Si le message a été envoyé avec succès, rediriger vers la conversation
                header("Location: messages?contact_id=" . $receiver_id);
                exit();
            } else {
                // Gérer l'erreur si l'envoi du message échoue
                $_SESSION['error'] = "Une erreur est survenue lors de l'envoi du message.";
            }
        } else {
            // Gérer le cas où le message est vide
            $_SESSION['error'] = "Le message ne peut pas être vide.";
        }

        // Redirection vers la page de messages
        header("Location: messages?contact_id=" . $receiver_id);
        exit();
    }
}
?>
