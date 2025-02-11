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
    <!-- ----------------------------- -->
    <!-- Inclusion de l'en-tête -->
    <!-- ----------------------------- -->
    <?php include 'templates/header.php'; ?>
    <!-- ----------------------------- -->
    <!-- Fin de l'en-tête -->
    <!-- ----------------------------- -->

    <!-- ----------------------------- -->
    <!-- Titre principal de la page -->
    <!-- ----------------------------- -->
    <h1>📨 Messages</h1>
    <!-- ----------------------------- -->
    <!-- Fin du titre principal -->
    <!-- ----------------------------- -->

    <!-- ----------------------------- -->
    <!-- Section de sélection du contact -->
    <!-- ----------------------------- -->
    <h2>👥 Sélectionner un contact</h2>
    <div class="contacts">
        <?php if (empty($contacts)): ?>
            <p class="no-contacts">Vous n'avez pas encore d'amis.</p>
        <?php else: ?>
            <?php foreach ($contacts as $contact): ?>
                <a href="?contact_id=<?php echo $contact['id']; ?>" class="contact-card">
                    <img src="<?php echo !empty($contact['profile_image']) ? 'uploads/profil/' . $contact['profile_image'] : 'uploads/default.png'; ?>" class="contact-pic">
                    <span><?php echo htmlspecialchars($contact['username']); ?></span>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <!-- ----------------------------- -->
    <!-- Fin de la section contacts -->
    <!-- ----------------------------- -->

    <!-- ----------------------------- -->
    <!-- Section des messages (si un contact est sélectionné) -->
    <!-- ----------------------------- -->
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

        <!-- ----------------------------- -->
        <!-- Section des messages -->
        <!-- ----------------------------- -->
        <?php if (!empty($messages)): ?>
            <div class="messages">
                <?php foreach ($messages as $message): ?>
                    <div class="message <?php echo $message['sender_id'] == $user_id ? 'sent' : 'received'; ?>">
                        <img src="<?php echo !empty($message['sender_image']) ? 'uploads/profil/' . $message['sender_image'] : '../uploads/default.png'; ?>" class="message-pic">
                        <div class="message-content">
                            <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                            <small><?php echo date('F j, Y, g:i a', strtotime($message['created_at'])); ?></small>
                            <?php if (!empty($message['image'])): ?>
                                <div class="message-image">
                                    <img src="uploads/<?php echo htmlspecialchars($message['image']); ?>" alt="Image" class="uploaded-image">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <!-- ----------------------------- -->
        <!-- Fin de la section des messages -->
        <!-- ----------------------------- -->

        <!-- ----------------------------- -->
        <!-- Formulaire d'envoi de message -->
        <!-- ----------------------------- -->
        <!-- ----------------------------- -->
<!-- ----------------------------- -->
<!-- ----------------------------- -->
<form method="POST" action="send" enctype="multipart/form-data" class="form-container">
    <input type="hidden" name="receiver_id" value="<?php echo $selected_contact; ?>">
    <textarea name="message" placeholder="Type a message..."></textarea>

    <!-- Bouton pour afficher/cacher la liste des emojis -->
    <button type="button" class="emoji-toggle-btn" onclick="toggleEmojis(this)">😊</button>

    <!-- Section pour les emojis qui sera affichée uniquement quand le bouton est cliqué -->
    <div class="emoji-container" id="emoji-container" style="display: none;">
        <button type="button" class="emoji-btn" onclick="addEmoji('😊')">😊</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('❤️')">❤️</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('👍')">👍</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('😂')">😂</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('🎉')">🎉</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('😍')">😍</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('😎')">😎</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('🥺')">🥺</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('💯')">💯</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('💪')">💪</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('😄')">😄</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('🥳')">🥳</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('🤩')">🤩</button>
        <button type="button" class="emoji-btn" onclick="addEmoji('🎶')">🎶</button>
 

    </div>

    <div class="file-upload-container">
        <label for="image" class="upload-label" title="Ajouter une image">
            📷
        </label>
        <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif" class="file-input">
        <!-- Affichage du nom du fichier sélectionné -->
    </div>

    <button type="submit"><span class="send-icon">➤</span></button>
    <div id="file-name-display" class="file-name-display"></div>
</form>



        <!-- ----------------------------- -->
        <!-- Fin du formulaire d'envoi -->
        <!-- ----------------------------- -->

    <?php endif; ?>
    <!-- ----------------------------- -->
    <!-- Fin de la section des messages -->
    <!-- ----------------------------- -->

    <!-- ----------------------------- -->
    <!-- Inclusion du pied de page -->
    <!-- ----------------------------- -->
    <?php include 'templates/footer.php'; ?>
    <!-- ----------------------------- -->
    <!-- Fin du pied de page -->
    <!-- ----------------------------- -->
</div>
<script src="views/static/js/message.js"></script>

</body>
</html>
