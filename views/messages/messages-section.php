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
                <div class="message <?php echo $message['sender_id'] == $user_id ? 'sent' : 'received'; ?>" data-message-id="<?php echo $message['id']; ?>">
                    <img src="<?php echo !empty($message['sender_image']) ? 'uploads/profil/' . $message['sender_image'] : '../uploads/default.png'; ?>" class="message-pic">
                    <div class="message-content">
                        <?php if (!empty($message['message'])): ?>
                            <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($message['image'])): ?>
                            <div class="message-image">
                                <img src="uploads/<?php echo htmlspecialchars($message['image']); ?>" alt="Image" class="uploaded-image">
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($message['audio'])): ?>
                            <div class="message-audio">
                                <audio controls>
                                    <source src="uploads/<?php echo htmlspecialchars($message['audio']); ?>" type="audio/mp3">
                                    Votre navigateur ne supporte pas l'élément audio.
                                </audio>
                            </div>
                        <?php endif; ?>

                        <small><?php echo date('F j, Y, g:i a', strtotime($message['created_at'])); ?></small>
                    </div>

                    <!-- Bouton pour afficher ou cacher les réactions -->

                    <!-- Sélecteur d'emoji caché -->


                    <!-- Affichage de la réaction sélectionnée -->
                    <div id="reaction-display-<?php echo $message['id']; ?>">
                        <?php if (!empty($message['reaction'])): ?>
                            <?php echo htmlspecialchars($message['reaction']); ?>
                        <?php endif; ?>
                    </div>

                    <!-- Formulaire de réaction -->

                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucun message à afficher pour cette conversation.</p>
    <?php endif; ?>
<?php else: ?>
    <p>Aucun contact sélectionné. Veuillez choisir un contact pour commencer une discussion.</p>
<?php endif; ?>
