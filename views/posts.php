<?php

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

// Récupérer les informations de l'utilisateur connecté
$userId = $_SESSION['user_id'];
$user = User::getById($userId); 

// Vérifier si l'utilisateur a une photo de profil
$profileImage = !empty($user['profile_image']) ? '../uploads/' . htmlspecialchars($user['profile_image']) : '../uploads/default.png';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" type="text/css" href="../css/profil-style.css">
</head>
<body>

  
<div class="container">
<?php include 'templates/header.php'; ?>
    <h2>Publications récentes</h2>
    <?php foreach ($posts as $post): ?>
        <?php
        // Récupérer les informations de l'utilisateur qui a fait le post
        $postUser = User::getById($post['user_id']);
        $postUserProfileImage = !empty($postUser['profile_image']) ? '../uploads/' . htmlspecialchars($postUser['profile_image']) : '../uploads/default.png';
        ?>

        <div class="post">
            <!-- Affichage de l'image de profil de l'utilisateur qui a posté -->
            <div class="post-user-info">
                <img src="<?php echo $postUserProfileImage; ?>" alt="Image de Profil de l'auteur" class="post-user-profile-pic">
                <strong><?php echo htmlspecialchars($postUser['username']); ?></strong>
            </div>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <small><?php echo $post['created_at']; ?></small>

            <?php if (!empty($post['image'])): ?>
                <img src="../uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Image du post" class="post-image">
            <?php endif; ?>

            <!-- Like et commentaire -->
            <div class="post-actions">
            <!-- Affichage du nombre de likes au-dessus du bouton Like -->
            <div class="like-container">
            <div class="like-count">
                  (<?php echo Like::countLikes($post['id']); ?>)
            </div>
            
            <form method="POST" action="like">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <button type="submit" class="like-btn">👍</button>
            </form>
            </div>
            
            <button class="comment-toggle" data-post-id="<?php echo $post['id']; ?>">💬 </button>
        </div>


            <!-- Formulaire de commentaire -->
            <form method="POST" action="comment" class="comment-form" id="comment-form-<?php echo $post['id']; ?>" style="display:none;">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <textarea name="comment_content" placeholder="Écrire un commentaire..." required></textarea>
                <button type="submit" name="comment_post">Comment</button>
            </form>

            <div class="comments">
                <?php
                    $comments = Comment::getCommentsByPostId($post['id']);
                ?>
                <?php foreach ($comments as $comment): 
                    $commentUser = User::getById($comment['user_id']);
                    $commentProfileImage = !empty($commentUser['profile_image']) ? '../uploads/' . htmlspecialchars($commentUser['profile_image']) : '../uploads/default.png';
                ?>
                    <div class="comment">
                        <img src="<?php echo $commentProfileImage; ?>" alt="Image de Profil Commentaire" class="comment-profile-pic">
                        <strong><?php echo htmlspecialchars($commentUser['username']); ?></strong>
                        <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                        <small><?php echo date("d M Y, H:i", strtotime($comment['created_at'])); ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>


<?php include 'templates/footer.php'; ?>
</div>




<script src="../js/profil.js"></script>
</body>
</html>
