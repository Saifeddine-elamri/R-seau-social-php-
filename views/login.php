<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="views/static/css/login-style.css">
</head>
<body>
    <div class="login-container">
        <h1>Connexion</h1>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form method="POST" action="/login_check">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <p class="register-link">Pas encore de compte ? <a href="/register">S'inscrire</a></p>
    </div>
</body>
</html>
