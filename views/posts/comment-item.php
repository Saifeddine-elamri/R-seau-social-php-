<?php
$commentUser = User::getById($comment['user_id']);
$commentProfileImage = !empty($commentUser['profile_image']) 
    ? '../uploads/profil/' . htmlspecialchars($commentUser['profile_image']) 
    : '../uploads/default.png';
?>
<div class="comment" id="comment-<?php echo $comment['id']; ?>">
    <img src="<?php echo $commentProfileImage; ?>" alt="Image de Profil Commentaire" class="comment-profile-pic">
    <div class="comment-content">
        <strong><?php echo htmlspecialchars($commentUser['first_name'] . ' ' . $commentUser['last_name']); ?></strong>
        <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
    </div>
    <small class="comment-date"><?php echo timeAgo($comment['created_at']); ?></small>

    <!-- Bouton pour aimer le commentaire -->
    <div class="comment-actions">
        <form method="POST" action="like-comment" class="like-form">
            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
            <input type="hidden" name="comment-emoji" class="comment-selected-emoji" value="<?php echo isset($selectedCommentEmoji) ? $selectedCommentEmoji : '👍'; ?>">
            <button type="button" data-comment-id="<?php echo $comment['id']; ?>" 
                    class="<?php echo isset($selectedCommentEmoji) && $selectedCommentEmoji !== '👍' ? 'like-btn-custom' : 'like-btn'; ?>">
                <?php echo isset($selectedCommentEmoji) ? $selectedCommentEmoji : '👍'; ?> 
                <?php echo isset($selectedCommentText) ? $selectedCommentText : 'J\'aime'; ?>
            </button>

            <!-- Sélecteur d'emojis (caché par défaut) -->
            <div class="comment-emoji-picker" style="display: none;">
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
        <!-- Champ de réponse (caché par défaut) -->
            <div class="reply-box-container" id="reply-box-<?php echo $comment['id']; ?>" style="display: none;">
            <form method="POST" action="reply-comment" class="reply-form">
                <input type="hidden" name="parent_comment_id" value="<?php echo $comment['id']; ?>">
                <textarea name="reply_content" placeholder="Votre réponse..." required></textarea>
                <button type="submit">Envoyer</button>
            </form>
            </div>
    </div>
        <?php
    $replies = CommentReply::getRepliesByCommentId($comment['id']); // Récupère les réponses
    $replyCount = count($replies);

    if ($replyCount > 0): ?>
        <button class="toggle-replies" data-comment-id="<?php echo $comment['id']; ?>">
            Voir <?php echo $replyCount; ?> réponse(s)
        </button>
        <div class="replies" id="replies-<?php echo $comment['id']; ?>" style="display: none;">
            <?php foreach ($replies as $reply): 
                $replyUser = User::getById($reply['user_id']);
                $replyProfileImage = !empty($replyUser['profile_image']) 
                    ? '../uploads/profil/' . htmlspecialchars($replyUser['profile_image']) 
                    : '../uploads/default.png';
            ?>
            <div class="reply" id="reply-<?php echo $reply['id']; ?>">
                <img src="<?php echo $replyProfileImage; ?>" alt="Image de Profil Réponse" class="reply-profile-pic">
                <div class="reply-content">
                    <strong><?php echo htmlspecialchars($replyUser['first_name'] . ' ' . $replyUser['last_name']); ?></strong>
                    <p><?php echo nl2br(htmlspecialchars($reply['content'])); ?></p>
                </div>
                <small class="reply-date"><?php echo timeAgo($reply['created_at']); ?></small>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

