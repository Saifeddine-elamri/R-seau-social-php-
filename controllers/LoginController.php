<?php

require_once __DIR__ . '/../models/User.php';

class LoginController {


    public function showLoginForm() {
        require_once __DIR__ . '/../views/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = User::findByEmail($email);

            if ($user && User::verifyPassword($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: /posts");
                exit();
            } else {
                $error_message = "Email ou mot de passe invalide.";
                require_once __DIR__ . '/../views/login.php';

            }
        }
    }
}
