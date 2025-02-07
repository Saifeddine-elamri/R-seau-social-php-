<?php

class AuthController {



    // Inscription (Register)
    public function register() {
        // Vérifier si le formulaire est soumis via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer les données du formulaire
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash du mot de passe

            // Insérer l'utilisateur dans la base de données
            global $pdo;
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $password]);

            // Rediriger l'utilisateur vers la page de connexion
            header("Location: login.php");
            exit();
        }

        // Afficher la vue d'inscription
        require_once __DIR__ . '/../views/register.php';
    }



    // Déconnexion
    public function logout() {
        // Démarrer ou reprendre la session
        session_start();

        // Détruire la session
        session_destroy();

        // Rediriger vers la page de connexion
        header("Location: login");
        exit();
    }
}
?>
