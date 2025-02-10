<?php
require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/User.php';

class MessageController {

    // Vérification de la connexion
    private function checkLogin() {
        if (!isLoggedIn()) {
            header("Location: login");
            exit();
        }
    }

    // Afficher les messages et contacts
    public function index() {
        $this->checkLogin(); // Vérification de la connexion

        $user_id = $_SESSION['user_id'];
        $contacts = Message::getContacts($user_id);

        $selected_contact = isset($_GET['contact_id']) ? $_GET['contact_id'] : null;
        $messages = [];

        if ($selected_contact) {
            $messages = Message::getMessages($user_id, $selected_contact);
        }

        include __DIR__ . '/../views/messages.php';
    }

    // Envoyer un message
    public function sendMessage() {
        $this->checkLogin(); // Vérification de la connexion

        $user_id = $_SESSION['user_id'];
        $receiver_id = $_POST['receiver_id'];
        $message = !empty($_POST['message']) ? trim($_POST['message']) : null;

        // Appeler la méthode du modèle pour gérer l'upload d'image
        $image_name = Message::handleImageUpload();

        // Si le message est valide, on l'envoie
        if ($message) {
            Message::sendMessage($user_id, $receiver_id, $message, $image_name);
        }

        // Redirection vers la conversation avec l'utilisateur
        header("Location: messages?contact_id=" . $receiver_id);
        exit();
    }
}
?>
