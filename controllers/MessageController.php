<?php
require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/View.php'; 
// Inclusion des fonctions utilitaires
require_once __DIR__ . '/../includes/utils.php';


class MessageController {



    /**
     * Affiche la liste des contacts et des messages
     */
    public function index() {
        // Vérification de l'authentification sinon redirection
        isAuthenticated();
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

        foreach ($messages as &$message) {
            // Récupérer la réaction pour ce message à partir de la table message_reactions
            $reaction = Message::getReactionForMessage($message['id']);
            $message['reaction'] = $reaction;
        }

        // Inclure la vue des messages (contacts et messages)
        View::render('messages/messages', ['messages' => $messages ,
                                            'contacts' => $contacts ,
                                            'user_id' => $user_id ,
                                             'selected_contact'  =>  $selected_contact
                                        
                                        ]);

    }

    /**
     * Envoie un message à un contact
     */
    public function sendMessage() {
        isAuthenticated();

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

/**
     * Ajoute une réaction à un message via POST
     */
    public function reactToMessage() {
        isAuthenticated();

        // Vérifier si les données sont présentes
        if (!isset($_POST['message_id']) || !isset($_POST['reaction'])) {
            $_SESSION['error'] = "Données invalides.";
            header("Location: messages");
            exit();
        }

        // Récupération des données du formulaire
        $message_id = intval($_POST['message_id']);
        $reaction = htmlspecialchars($_POST['reaction']);
        $user_id = $_SESSION['user_id'];

        // Vérifier si le message existe
        if (!Message::exists($message_id)) {
            $_SESSION['error'] = "Message non trouvé.";
            header("Location: messages");
            exit();
        }

        // Ajouter ou mettre à jour la réaction
        $result = Message::addReaction($message_id, $user_id, $reaction);

        if ($result) {
            $_SESSION['success'] = "Réaction ajoutée avec succès.";
        } else {
            $_SESSION['error'] = "Impossible d'ajouter la réaction.";
        }

        // Rediriger vers la conversation
        header("Location: messages?contact_id=" . $_POST['contact_id']);
        exit();
    }












}
?>
