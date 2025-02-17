<?php
// Récupération des informations sur les likes et commentaires du post
$likeCount=Like::countLikes($post['id']);
$commentCount = Comment::countCommentsByPostId($post['id']);
$topEmojis = Like::getTopEmojisByPostId($post['id']);
$selectedEmoji = Like::getUserEmojiForPost($post['id'], $_SESSION['user_id']) ?: '👍';

// Définir le texte associé à l'emoji sélectionné
switch ($selectedEmoji) {
    case '👍': $selectedText = "J'aime"; break;
    case '❤️': $selectedText = "J'adore"; break;
    case '😂': $selectedText = "Haha"; break;
    case '😮': $selectedText = "Waouh"; break;
    case '😢': $selectedText = "Solidaire"; break;
    case '😡': $selectedText = "Grrr"; break;
    default: $selectedText = "J'aime"; break;
}
?>

<div class="count-container">
    <!-- Comptage des likes et affichage des emojis -->
    <div class="like-count">
        <?php if ($topEmojis): ?>
            <br>
            <?php foreach ($topEmojis as $emoji): ?>
                <span><?php echo $emoji['emoji_type']; ?></span>
            <?php endforeach; ?>
            <?php echo $likeCount; ?>
        <?php endif; ?>
    </div>
    <!-- Comptage des commentaires -->
    <div class="commentaire-count">
        <?php if ($commentCount > 0): ?>
            <span><?php echo $commentCount; ?> commentaires</span>
        <?php endif; ?>
    </div>
</div>

<!-- Boutons d'action (Like et Commenter) -->
<!-- Ajout d'un trait avant les actions -->
<hr class="post-separator">
<div class="post-actions">
    <div class="like-container">
        <form method="POST" action="like" class="like-form">
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
            <input type="hidden" name="emoji" class="selected-emoji" value="<?php echo isset($selectedEmoji) ? $selectedEmoji : '👍'; ?>">
            <button type="submit" class="<?php echo $selectedEmoji !== '👍' ? 'like-btn-custom' : 'like-btn'; ?>">
                 <?php echo isset($selectedEmoji) ? $selectedEmoji : '👍'; ?> 
                 <?php echo isset($selectedText) ? $selectedText : 'J\'aime'; ?>
            </button>

            <!-- Sélecteur d'emojis -->
            <div class="emoji-picker">
                <span class="emoji" data-emoji="👍" data-text="J'aime">👍</span>
                <span class="emoji" data-emoji="❤️" data-text="J'adore">❤️</span>
                <span class="emoji" data-emoji="😂" data-text="Haha">😂</span>
                <span class="emoji" data-emoji="😮" data-text="Waouh">😮</span>
                <span class="emoji" data-emoji="😢" data-text="Solidaire">😢</span>
                <span class="emoji" data-emoji="😡" data-text="Grrr">😡</span>
            </div>
        </form>
        <button class="comment-toggle" data-post-id="<?php echo $post['id']; ?>">💬 Commenter</button>
    </div>
</div>
