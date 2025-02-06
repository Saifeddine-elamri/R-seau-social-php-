<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user = getUserById($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile Info</title>
    <link rel="stylesheet" href="../css/profil-info-style.css">
</head>
<body>

<div class="container">
    <h1>Profile Info</h1>
    
    <div class="profile-card">
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Member since:</strong> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
    </div>

    <a href="profil.php" class="button back">Back to Profile</a>
</div>

</body>
</html>
