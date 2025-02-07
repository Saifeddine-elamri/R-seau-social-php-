<?php
require_once __DIR__ . '/../models/Message.php';

class MessageController {


    public function index() {
        if (!isLoggedIn()) {
            header("Location: login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $contacts = Message::getContacts($user_id);

        $selected_contact = isset($_GET['contact_id']) ? $_GET['contact_id'] : null;
        $messages = [];

        if ($selected_contact) {
            $messages = Message::getMessages($user_id, $selected_contact);
        }

        include __DIR__ . '/../views/messages.php';
    }
    public function sendMessage() {
        if (!isLoggedIn()) {
            header("Location: login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $receiver_id = $_POST['receiver_id'];
        $message = !empty($_POST['message']) ? trim($_POST['message']) : null;
        $image_name = null;

        // Gérer l'upload de l'image
        if (!empty($_FILES['image']['name'])) {
            $target_dir = __DIR__ . '/../uploads/';
            $image_name = time() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $image_name;
            
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($imageFileType, $allowed_types) && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Image uploadée avec succès
            } else {
                $image_name = null;
            }
        }

        // Insérer le message
        Message::sendMessage($user_id, $receiver_id, $message, $image_name);

        // Redirection vers la conversation
        header("Location: messages?contact_id=" . $receiver_id);
        exit();
    }
}


?>
