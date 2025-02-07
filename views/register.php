<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="views/static/css/register-style.css">
</head>
<body>

<div class="registration-container">
    <h1>Create Your Account</h1>
    
    <!-- Formulaire d'inscription -->
    <form method="POST">
        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <div class="button-group">
            <button type="submit">Register</button>
        </div>
    </form>

    <p>Already have an account? <a href="login">Login</a></p>
</div>

</body>
</html>
