<?php

class AuthController {

    /**
     * Méthode pour gérer l'inscription (register) des utilisateurs.
     * Elle vérifie si le formulaire a été soumis via une requête POST et valide les données avant de les insérer dans la base de données.
     */
    public function register() {
        // Vérification de la méthode de la requête (POST)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer et nettoyer les données du formulaire
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            
            // Validation basique des données
            if (empty($username) || empty($email) || empty($password)) {
                // Si un champ est vide, renvoyer un message d'erreur
                $error_message = "Tous les champs sont obligatoires.";
                require_once __DIR__ . '/../views/register.php';
                return;
            }

            // Validation du format de l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message = "L'email n'est pas valide.";
                require_once __DIR__ . '/../views/register.php';
                return;
            }

            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insertion de l'utilisateur dans la base de données
            global $pdo;
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);

            // Rediriger l'utilisateur vers la page de connexion
            header("Location: /login");
            exit();
        }

        // Si la méthode est GET ou si le formulaire n'est pas soumis, afficher la vue d'inscription
        require_once __DIR__ . '/../views/register.php';
    }

    /**
     * Méthode pour gérer la déconnexion de l'utilisateur.
     * Elle détruit la session active et redirige l'utilisateur vers la page de connexion.
     */
    public function logout() {
        // Démarrer ou reprendre la session
        session_start();

        // Supprimer toutes les variables de session
        session_unset();

        // Détruire la session
        session_destroy();

        // Rediriger l'utilisateur vers la page de connexion
        header("Location: /login");
        exit();
    }
}
?>
