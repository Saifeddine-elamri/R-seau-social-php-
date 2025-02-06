<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$friends = getFriends($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Friends</title>
    <link rel="stylesheet" href="../css/friends-style.css">
</head>
<body>

<div class="container">
    <h1>Your Friends</h1>

    <?php if (empty($friends)): ?>
        <p class="message warning">You have no friends yet.</p>
    <?php else: ?>
        <div class="friends-list">
            <?php foreach ($friends as $friend): ?>
                <div class="friend-card">
                    <h3><?php echo htmlspecialchars($friend['username']); ?></h3>
                    <p>Email: <?php echo htmlspecialchars($friend['email']); ?></p>
                    
                    <!-- Formulaire pour supprimer un ami -->
                    <form action="remove_friend.php" method="POST">
                        <input type="hidden" name="friend_id" value="<?php echo $friend['id']; ?>">
                        <button type="submit" class="remove-button">Remove Friend</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="profil.php" class="button">Back to Profile</a>
</div>

</body>
</html>
