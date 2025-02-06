<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupérer la liste des contacts (personnes avec qui l'utilisateur a échangé des messages)
$stmt = $pdo->prepare("
    SELECT DISTINCT u.id, u.username, u.profile_image
    FROM users u
    JOIN messages m ON (u.id = m.sender_id OR u.id = m.receiver_id)
    WHERE (m.sender_id = ? OR m.receiver_id = ?) AND u.id != ?
");
$stmt->execute([$user_id, $user_id, $user_id]);
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les messages d'un contact spécifique si sélectionné
$selected_contact = isset($_GET['contact_id']) ? $_GET['contact_id'] : null;
$messages = [];

if ($selected_contact) {
    $stmt = $pdo->prepare("
        SELECT m.*, 
               sender.username AS sender_username, sender.profile_image AS sender_image, 
               receiver.username AS receiver_username, receiver.profile_image AS receiver_image
        FROM messages m
        JOIN users sender ON m.sender_id = sender.id
        JOIN users receiver ON m.receiver_id = receiver.id
        WHERE (m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?)
        ORDER BY m.created_at ASC
    ");
    $stmt->execute([$user_id, $selected_contact, $selected_contact, $user_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
    <link rel="stylesheet" href="../css/messages-style.css">
</head>
<body>

<div class="container">
    <h1>📨 Messages</h1>

    <!-- Liste des contacts -->
    <h2>👥 Select a Contact</h2>
    <div class="contacts">
        <?php foreach ($contacts as $contact): ?>
            <a href="?contact_id=<?php echo $contact['id']; ?>" class="contact-card">
                <img src="<?php echo !empty($contact['profile_image']) ? '../uploads/' . $contact['profile_image'] : '../uploads/default.png'; ?>" class="contact-pic">
                <span><?php echo htmlspecialchars($contact['username']); ?></span>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Affichage des messages avec le contact sélectionné -->
    <?php if ($selected_contact): ?>
        <h2>💬 Chat with <?php echo htmlspecialchars($messages[0]['sender_id'] == $user_id ? $messages[0]['receiver_username'] : $messages[0]['sender_username']); ?></h2>
        <div class="messages">
            <?php foreach ($messages as $message): ?>
                <div class="message <?php echo $message['sender_id'] == $user_id ? 'sent' : 'received'; ?>">
                    <img src="<?php echo !empty($message['sender_image']) ? '../uploads/' . $message['sender_image'] : '../uploads/default.png'; ?>" class="message-pic">
                    <div class="message-content">
                        <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                        <small><?php echo date('F j, Y, g:i a', strtotime($message['created_at'])); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Formulaire d'envoi de message -->
        <form method="POST" action="sendMessage.php">
            <input type="hidden" name="receiver_id" value="<?php echo $selected_contact; ?>">
            <textarea name="message" placeholder="Type a message..." required></textarea>
            <button type="submit">Send</button>
        </form>
    <?php endif; ?>

    <a href="profil.php" class="button">Back to Profile</a>
</div>

</body>
</html>
