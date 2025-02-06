<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Récupérer les messages reçus
$stmt = $pdo->prepare("SELECT m.*, u.username AS sender_username 
                        FROM messages m
                        LEFT JOIN users u ON m.sender_id = u.id
                        WHERE m.receiver_id = ?
                        ORDER BY m.created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$receivedMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les messages envoyés
$stmt = $pdo->prepare("SELECT m.*, u.username AS receiver_username 
                        FROM messages m
                        LEFT JOIN users u ON m.receiver_id = u.id
                        WHERE m.sender_id = ?
                        ORDER BY m.created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$sentMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
    <link rel="stylesheet" href="../css/messages-style.css">
</head>
<body>

<div class="container">
    <h1>Messages</h1>

    <!-- Messages reçus -->
    <h2>📩 Messages Received</h2>
    <?php if (empty($receivedMessages)): ?>
        <p class="message warning">You have no received messages.</p>
    <?php else: ?>
        <?php foreach ($receivedMessages as $message): ?>
            <div class="message-card received">
                <div class="message-header">
                    <strong>From:</strong> <?php echo htmlspecialchars($message['sender_username']); ?>
                    <span class="message-time"><?php echo date('F j, Y, g:i a', strtotime($message['created_at'])); ?></span>
                </div>
                <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Messages envoyés -->
    <h2>📤 Messages Sent</h2>
    <?php if (empty($sentMessages)): ?>
        <p class="message warning">You have not sent any messages.</p>
    <?php else: ?>
        <?php foreach ($sentMessages as $message): ?>
            <div class="message-card sent">
                <div class="message-header">
                    <strong>To:</strong> <?php echo htmlspecialchars($message['receiver_username']); ?>
                    <span class="message-time"><?php echo date('F j, Y, g:i a', strtotime($message['created_at'])); ?></span>
                </div>
                <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="profil.php" class="button">Back to Profile</a>
</div>

</body>
</html>
