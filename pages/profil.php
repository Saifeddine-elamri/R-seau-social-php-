<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user = getUserById($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/profil-style.css">
</head>
<body>

<div class="container">


    <header>
        <h1>My Profile</h1>
        <?php
// Vérifier si l'utilisateur a une photo de profil
$profileImage = !empty($user['profile_image']) ? '../uploads/' . htmlspecialchars($user['profile_image']) : '../uploads/default.png';
?>

<div class="header-profile">
    <img src="<?php echo $profileImage; ?>" alt="Profile Picture" class="header-profile-pic">
</div>

        <nav class="nav-header">

            <a href="home.php">🏠 Home</a>
            <a href="../logout.php" class="logout">🚪 Logout</a>
        </nav>
    </header>

    <nav class="tabs-nav">
        <a href="profil-info.php">👤 Profile Info</a>
        <a href="posts.php">📝 My Posts</a>
        <a href="friends.php">👫 Friends</a>
        <a href="send-message.php">📩 Send Message</a>
        <a href="messages.php">💬 Messages</a>
        <a href="all-users.php">🌎 All Users</a>
        <a href="friend-requests.php">🔔 Friend Requests</a>
    </nav>
</div>

</body>
</html>
