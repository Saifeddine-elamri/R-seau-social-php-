<?php
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" type="text/css" href="views/static/css/profil-style.css">
</head>
<body>

<div class="container">
    <?php include 'templates/header.php'; ?>

        <!-- Formulaire pour créer un post -->
        <div class="new-post-form">
        <h3>Poster quelque chose</h3>
        <form method="POST" enctype="multipart/form-data" action="add-post">
            <textarea name="content" placeholder="Écrivez quelque chose..." required></textarea>
            <div class="file-upload-container">
            <label for="post_image" class="upload-label">📷</label>
            <input type="file" id="post_image" name="post_image" accept="image/*" class="file-input">

            <label for="post_video" class="upload-label">📹</label>
            <input type="file" id="post_video" name="post_video" accept="video/*" class="file-input">
            </div>

            <div id="file-name-display"></div>
            <button type="submit">Publier</button>
        </form>
        </div>

    <h2>Publications récentes</h2>



    <!-- Affichage des publications -->
<!-- Affichage des publications -->
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

                <!-- Affichage de l'image du post -->
                <?php if (!empty($post['image'])): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Image du post" class="post-image">
                <?php endif; ?>

                <!-- Affichage de la vidéo du post -->
                <!-- Affichage de la vidéo du post -->
                <?php if (!empty($post['video'])): ?>
                    <video width="320" height="240" controls>
                        <source src="../uploads/videos/<?php echo htmlspecialchars($post['video']); ?>" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                <?php endif; ?>


            <!-- Like et commentaire -->
            <div class="post-actions">
            <div class="like-container">
                <div class="like-count">(<?php echo Like::countLikes($post['id']); ?>)</div>
                <form method="POST" action="like">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <input type="hidden" name="emoji" class="selected-emoji" value="👍">
                    <button type="button" class="like-btn">👍</button>
                    <div class="emoji-picker">
                        <button type="submit" class="emoji-option" data-emoji="👍">👍</button>
                        <button type="submit" class="emoji-option" data-emoji="❤️">❤️</button>
                        <button type="submit" class="emoji-option" data-emoji="😂">😂</button>
                        <button type="submit" class="emoji-option" data-emoji="😮">😮</button>
                        <button type="submit" class="emoji-option" data-emoji="😢">😢</button>
                        <button type="submit" class="emoji-option" data-emoji="😡">😡</button>
                    </div>
                </form>
            </div>
            <button class="comment-toggle" data-post-id="<?php echo $post['id']; ?>">💬</button>
        </div>


            <!-- Formulaire de commentaire -->
            <form method="POST" action="comment" class="comment-form" id="comment-form-<?php echo $post['id']; ?>" style="display:none;">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <textarea name="comment_content" placeholder="Écrire un commentaire..." required></textarea>
                <button type="submit" name="comment_post">Commenter</button>
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

<script src="views/static/js/profil.js"></script>
</body>
</html>
