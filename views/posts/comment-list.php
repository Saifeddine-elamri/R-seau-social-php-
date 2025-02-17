<?php
$comments = Comment::getCommentsByPostId($post['id']);
foreach ($comments as $comment): 
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
        <small class="comment-date"><?php echo timeAgo($comment['created_at']); ?></small>
    </div>
<?php endforeach; ?>
