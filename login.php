<?php
session_start();
include 'includes/db.php';

// Vérifiez si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    // Si l'utilisateur est connecté, redirigez-le vers la page d'accueil
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php"); // Redirection vers la page principale après la connexion
        exit();
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login-style.css">
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p class="register-link">You don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
