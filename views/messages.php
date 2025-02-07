<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="views/static/css/messages-style.css">
</head>
<body>

<div class="container">
<?php include 'templates/header.php'; ?>

    <h1>📨 Messages</h1>

    <h2>👥 Sélectionner un contact</h2>
    <div class="contacts">
        <?php if (empty($contacts)): ?>
            <p class="no-contacts">Vous n'avez pas encore d'amis.</p>
        <?php else: ?>
            <?php foreach ($contacts as $contact): ?>
                <a href="?contact_id=<?php echo $contact['id']; ?>" class="contact-card">
                    <img src="<?php echo !empty($contact['profile_image']) ? 'uploads/' . $contact['profile_image'] : 'uploads/default.png'; ?>" class="contact-pic">
                    <span><?php echo htmlspecialchars($contact['username']); ?></span>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if ($selected_contact): ?>
        <h2>💬 Discussion avec 
            <?php 
            if (!empty($messages)) {
                echo htmlspecialchars($messages[0]['sender_id'] == $user_id ? $messages[0]['receiver_username'] : $messages[0]['sender_username']);
            } else {
                foreach ($contacts as $contact) {
                    if ($contact['id'] == $selected_contact) {
                        echo htmlspecialchars($contact['username']);
                        break;
                    }
                }
            }
            ?>
        </h2>
        
        <div class="messages">
            <?php foreach ($messages as $message): ?>
                <div class="message <?php echo $message['sender_id'] == $user_id ? 'sent' : 'received'; ?>">
                    <img src="<?php echo !empty($message['sender_image']) ? 'uploads/' . $message['sender_image'] : '../uploads/default.png'; ?>" class="message-pic">
                    <div class="message-content">
                        <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                        <small><?php echo date('F j, Y, g:i a', strtotime($message['created_at'])); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <form method="POST" action="send" enctype="multipart/form-data">
            <input type="hidden" name="receiver_id" value="<?php echo $selected_contact; ?>">
            <textarea name="message" placeholder="Type a message..."></textarea>
            <button type="submit"><span class="send-icon">➤</span></button>
        </form>
    <?php endif; ?>

    <?php include 'templates/footer.php'; ?>

</div>

</body>
</html>
