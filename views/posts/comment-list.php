<!-- Formulaire de commentaire -->
<form method="POST" action="comment" class="comment-form" id="comment-form-<?php echo $post['id']; ?>" style="display:none;">
    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
    <textarea name="comment_content" placeholder="Écrivez un commentaire..." required></textarea>
    <button type="submit" name="comment_post">➤</button>
</form>

<?php
// Récupérer tous les commentaires pour le post
$comments = Comment::getCommentsByPostId($post['id']);
foreach ($comments as $comment):
    // Inclure le fichier comment-item.php pour chaque commentaire
    include 'comment-item.php';
endforeach;
?>
