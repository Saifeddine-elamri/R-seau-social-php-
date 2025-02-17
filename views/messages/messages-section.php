<!-- Section des messages (si un contact est sélectionné) -->
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

    <!-- Section des messages -->
    <?php if (!empty($messages)): ?>
        <div class="messages">
            <?php foreach ($messages as $message): ?>
            <?php Message::markAsRead($selected_contact, $userId); ?>
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
<?php endif; ?>
