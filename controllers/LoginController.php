<?php

// Inclusion du modèle User pour accéder aux fonctions liées aux utilisateurs.
require_once __DIR__ . '/../models/User.php';

class LoginController {

    /**
     * Affiche le formulaire de connexion.
     * Cette méthode charge la vue de connexion lorsque l'utilisateur arrive sur la page de login.
     */
    public function showLoginForm() {
        require_once __DIR__ . '/../views/login.php';  // Chargement de la vue contenant le formulaire de connexion.
    }

    /**
     * Gère la logique de connexion de l'utilisateur.
     * Cette méthode est appelée lorsque le formulaire de connexion est soumis.
     * 
     * @return void
     */
    public function login() {
        // Vérification que la requête HTTP est de type POST (formulaire soumis)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Nettoyer et valider les données d'entrée pour éviter les attaques XSS et autres vulnérabilités
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Recherche de l'utilisateur dans la base de données par son adresse email
            $user = User::findByEmail($email);

            // Vérification de la validité du mot de passe
            if ($user && User::verifyPassword($password, $user['password'])) {
                // Si les identifiants sont valides, créer une session pour l'utilisateur
                $_SESSION['user_id'] = $user['id'];

                // Redirection vers la page des posts après une connexion réussie
                header("Location: /posts");
                exit();  // On s'assure de quitter immédiatement l'exécution pour éviter tout code suivant
            } else {
                // Si les identifiants sont invalides, afficher un message d'erreur
                $error_message = "Email ou mot de passe invalide.";

                // Recharger la vue de connexion avec le message d'erreur
                require_once __DIR__ . '/../views/login.php';
            }
        }
    }
}
?>
