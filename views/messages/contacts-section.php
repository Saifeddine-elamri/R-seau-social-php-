<!-- Section de sélection du contact -->
<h2>👥 Sélectionner un contact</h2>
<div class="contacts">
    <?php if (empty($contacts)): ?>
        <p class="no-contacts">Vous n'avez pas encore d'amis.</p>
    <?php else: ?>
        <?php foreach ($contacts as $contact): ?>
            <a href="?contact_id=<?php echo $contact['id']; ?>" class="contact-card">
                <img src="<?php echo !empty($contact['profile_image']) ? 'uploads/profil/' . $contact['profile_image'] : 'uploads/default.png'; ?>" class="contact-pic">
                <span>
                    <?php echo htmlspecialchars($contact['username']); ?>
                    <?php if (Message::countUnreadMessages($contact['id'], $user_id) > 0): ?>
                        <span class="unread-badge">(<?php echo Message::countUnreadMessages($contact['id'], $user_id); ?>)</span>
                    <?php endif; ?>
                </span>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
