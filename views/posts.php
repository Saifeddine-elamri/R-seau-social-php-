<?php
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}
$User = User::getById($_SESSION['user_id']);
$UserProfileImage = !empty($User['profile_image']) ? '../uploads/profil/' . htmlspecialchars($User['profile_image']) : '../uploads/default.png';

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
    <form method="POST" enctype="multipart/form-data" action="add-post" class="post-form">
        <!-- Zone de texte pour le contenu du post -->
        <div class="post-header">
            <!-- Image de profil à côté du formulaire -->
            <a href="profil-info">

            <img src="<?php echo $UserProfileImage; ?>" alt="Image de Profil" class="user-profile-picture">

            </a>

            <!-- Zone de texte pour le contenu du post -->
            <textarea name="content" placeholder="Quoi de neuf..." required class="post-content"></textarea>
        </div> <!-- Conteneur pour les boutons de téléchargement de fichiers -->

        <div class="file-upload-container">
            <!-- Icône pour l'image -->
            <label for="post_image" class="upload-label" title="Ajouter une image">
                📷
            </label>
            <input type="file" id="post_image" name="post_image" accept="image/*" class="file-input">

            <!-- Icône pour la vidéo -->
            <label for="post_video" class="upload-label" title="Ajouter une vidéo">
                📹 
            </label>
            <input type="file" id="post_video" name="post_video" accept="video/*" class="file-input">

            <!-- Affichage du nom du fichier sélectionné -->
            <div id="file-name-display" class="file-name-display"></div>

            <!-- Bouton de soumission avec une icône d'envoi -->
            <button type="submit"><span class="send-icon">➤</span></button>

        </div>
    </form>
</div>





        <!-- Affichage des publications -->
        <h2></h2>
        <?php foreach ($posts as $post): ?>
            <?php
            // Récupérer les informations de l'utilisateur qui a fait le post
            $postUser = User::getById($post['user_id']);
            $postUserProfileImage = !empty($postUser['profile_image']) ? '../uploads/profil/' . htmlspecialchars($postUser['profile_image']) : '../uploads/default.png';
            ?>

            <div class="post">
                <!-- Affichage de l'image de profil de l'utilisateur qui a posté -->
                <div class="post-user-info">
                    <img src="<?php echo $postUserProfileImage; ?>" alt="Image de Profil de l'auteur" class="post-user-profile-pic">
                    <div class="post-user-name">
                    <strong><?php echo htmlspecialchars($postUser['username']); ?></strong>
                    <small><?php echo $post['created_at']; ?></small>
                    </div>
                </div>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

                <!-- Affichage de l'image du post -->
                <?php if (!empty($post['image'])): ?>
                    <img src="../uploads/images/<?php echo htmlspecialchars($post['image']); ?>" alt="Image du post" class="post-image">
                <?php endif; ?>

                <?php if (!empty($post['video'])): ?>
                <div class="video-container">
                    <!-- Overlay avant la lecture -->
                    <div class="video-overlay">
                        <div class="video-play-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>

                    <!-- Vidéo -->
                    <video class="video-gauche" controls>
                        <source src="../uploads/videos/<?php echo htmlspecialchars($post['video']); ?>" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                </div>
            <?php endif; ?>



            <!-- Like et commentaire -->
            <div class="post-actions">
            <div class="like-container">
                <div class="like-count">(<?php echo Like::countLikes($post['id']); ?>)</div>
                <form method="POST" action="like">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <input type="hidden" name="emoji" class="selected-emoji" value="👍">
                    <button type="button" class="like-btn">👍 J'aime</button>
                </form>
            </div>
            <button class="comment-toggle" data-post-id="<?php echo $post['id']; ?>">💬 Commenter</button>
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
                    $commentProfileImage = !empty($commentUser['profile_image']) ? '../uploads/profil/' . htmlspecialchars($commentUser['profile_image']) : '../uploads/default.png';
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
