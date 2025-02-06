<?php


if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupérer la liste des amis de l'utilisateur connecté
$stmt = $pdo->prepare("
    SELECT u.id, u.username, u.profile_image
    FROM users u
    JOIN friends f ON (u.id = f.user_id OR u.id = f.friend_id)
    WHERE (f.friend_id = ? OR f.user_id = ?) 
    AND u.id != ? 
    AND f.status = 'accepted'
    ORDER BY u.username ASC
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="../css/messages-style.css">
</head>
<body>

<div class="container">
    <h1>📨 Messages</h1>

    <!-- Liste des contacts -->
    <h2>👥 Sélectionner un contact</h2>
    <div class="contacts">
        <?php if (empty($contacts)): ?>
            <p class="no-contacts">Vous n'avez pas encore d'amis. Ajoutez-en pour discuter !</p>
        <?php else: ?>
            <?php foreach ($contacts as $contact): ?>
                <a href="?contact_id=<?php echo $contact['id']; ?>" class="contact-card">
                    <img src="<?php echo !empty($contact['profile_image']) ? '../uploads/' . $contact['profile_image'] : '../uploads/default.png'; ?>" class="contact-pic">
                    <span><?php echo htmlspecialchars($contact['username']); ?></span>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Affichage des messages avec le contact sélectionné -->
    <?php if ($selected_contact): ?>
        <h2>💬 Chat with 
                <?php 
                if (!empty($messages)) {
                    echo htmlspecialchars($messages[0]['sender_id'] == $user_id ? $messages[0]['receiver_username'] : $messages[0]['sender_username']);
                } else {
                    // Récupérer le nom du contact depuis la liste des contacts
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
            <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $message): ?>
                <div class="message <?php echo $message['sender_id'] == $user_id ? 'sent' : 'received'; ?>">
                    <img src="<?php echo !empty($message['sender_image']) ? '../uploads/' . $message['sender_image'] : '../uploads/default.png'; ?>" class="message-pic">
                    <div class="message-content">
                        <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                        <?php if (!empty($message['image'])): ?>
                            <img src="../uploads/<?php echo htmlspecialchars($message['image']); ?>" class="message-image">
                        <?php endif; ?>
                        <small><?php echo date('F j, Y, g:i a', strtotime($message['created_at'])); ?></small>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php else: ?>
                <p class="no-messages">Aucun message pour le moment. Démarrez la conversation !</p>
            <?php endif; ?>
        </div>


        <!-- Formulaire d'envoi de message -->
        <form method="POST" action="sendMessage.php" enctype="multipart/form-data">
       <input type="hidden" name="receiver_id" value="<?php echo $selected_contact; ?>">
      <textarea name="message" placeholder="Type a message..."></textarea>

    <!-- Bouton d'upload avec icône -->
    <div class="file-upload">
        <label for="file-input" class="custom-file-upload">
            <div class="file-icon">
                📎 <!-- Icône d'attachement -->
            </div>
        </label>
        <input id="file-input" type="file" name="image" accept="image/*" style="display: none;">
        <span id="file-name"></span> <!-- Nom du fichier affiché ici -->
    </div>



<script>
    document.getElementById("file-input").addEventListener("change", function() {
        var fileName = this.files[0] ? this.files[0].name : "Aucun fichier sélectionné";
        document.getElementById("file-name").textContent = fileName;
    });
</script>


       <button type="submit"><span class="send-icon">➤</span></button>
       </form>

    <?php endif; ?>

    <a href="/" class="button">Back to Profile</a>
</div>

</body>
</html>
