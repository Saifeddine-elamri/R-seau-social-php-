<?php
$commentUser = User::getById($comment['user_id']);
$commentProfileImage = !empty($commentUser['profile_image']) 
        ? '../uploads/profil/' . htmlspecialchars($commentUser['profile_image']) 
        : '../uploads/default.png';
?>
<div class="comment">
    <img src="<?php echo $commentProfileImage; ?>" alt="Image de Profil Commentaire" class="comment-profile-pic">
    <div class="comment-content">
        <strong><?php echo htmlspecialchars($commentUser['first_name'] . ' ' . $commentUser['last_name']); ?></strong>
        <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
    </div>
</div>
<small class="comment-date"><?php echo timeAgo($comment['created_at']); ?></small>
<!-- Bouton pour aimer le commentaire -->
<div class="comment-actions">
<form method="POST" action="like-comment" class="like-form">
            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
            <input type="hidden" name="comment-emoji" class="comment-selected-emoji" value="<?php echo isset($selectedEmoji) ? $selectedEmoji : '👍'; ?>">
            <button type="submit"  data-comment-id="<?php echo $comment['id']; ?> class="<?php echo $selectedEmoji !== '👍' ? 'like-btn-custom' : 'like-btn'; ?>">
                 <?php echo isset($selectedEmoji) ? $selectedEmoji : '👍'; ?> 
                 <?php echo isset($selectedText) ? $selectedText : 'J\'aime'; ?>
            </button>

            <!-- Sélecteur d'emojis -->
            <div class="comment-emoji-picker">
                <span class="comment-emoji" data-emoji="👍" data-text="J'aime">👍</span>
                <span class="comment-emoji" data-emoji="❤️" data-text="J'adore">❤️</span>
                <span class="comment-emoji" data-emoji="😂" data-text="Haha">😂</span>
                <span class="comment-emoji" data-emoji="😮" data-text="Waouh">😮</span>
                <span class="comment-emoji" data-emoji="😢" data-text="Solidaire">😢</span>
                <span class="comment-emoji" data-emoji="😡" data-text="Grrr">😡</span>
            </div>
</form>    
<!-- Bouton pour répondre -->
<button class="reply-comment" data-comment-id="<?php echo $comment['id']; ?>">Répondre</button>
</div>