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
    <title>Send Message</title>
    <link rel="stylesheet" href="../css/send-message-style.css">
</head>
<body>

<div class="container">
    <h1>Send a Message</h1>

    <?php if (empty($friends)): ?>
        <p class="message warning">You have no friends to message.</p>
    <?php else: ?>
        <form method="POST" action="sendMessage.php">
            <label for="friend_id">Select a Friend:</label>
            <select name="friend_id" required>
                <option value="" disabled selected>Choose a friend</option>
                <?php foreach ($friends as $friend): ?>
                    <option value="<?php echo $friend['id']; ?>">
                        <?php echo htmlspecialchars($friend['username']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="message">Your Message:</label>
            <textarea name="message" placeholder="Type your message here..." required></textarea>

            <button type="submit" class="button">Send</button>
        </form>
    <?php endif; ?>

    <a href="profil.php" class="button">Back to Profile</a>
</div>

</body>
</html>
