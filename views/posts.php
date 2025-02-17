<?php
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}
$User = User::getById($_SESSION['user_id']);
$UserProfileImage = !empty($User['profile_image']) ? '../uploads/profil/' . htmlspecialchars($User['profile_image']) : '../uploads/default.png';
// Fonction pour calculer le temps relatif
function timeAgo($timestamp) {
    $currentTime = time();
    $timeDifference = $currentTime - strtotime($timestamp);
    $seconds = $timeDifference;
    $minutes      = round($seconds / 60);           // value 60 is seconds
    $hours        = round($seconds / 3600);         // value 3600 is 60 minutes * 60 sec
    $days         = round($seconds / 86400);        // value 86400 is 24 hours * 60 minutes * 60 sec
    $weeks        = round($seconds / 604800);       // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
    $months       = round($seconds / 2629440);      // value 2629440 is ((365+365+365+365)/4/12) days * 24 hours * 60 minutes * 60 sec
    $years        = round($seconds / 31553280);     // value 31553280 is 365.25 days * 24 hours * 60 minutes * 60 sec

    if ($seconds <= 60) {
        return "Il y a quelques secondes";
    } else if ($minutes <= 60) {
        return ($minutes == 1) ? "1 m" : "$minutes m";
    } else if ($hours <= 24) {
        return ($hours == 1) ? "1 h" : "$hours h";
    } else if ($days <= 7) {
        return ($days == 1) ? "Hier" : "$days j";
    } else if ($weeks <= 4.3) { // 4.3 == 30/7
        return ($weeks == 1) ? "1 semaine" : "$weeks sem";
    } else if ($months <= 12) {
        return ($months == 1) ? "1 mois" : "$months mois";
    } else {
        return ($years == 1) ? "1 an" : "$years ans";
    }
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
        <?php foreach ($posts as $post): ?>
            <?php
            // Récupérer les informations de l'utilisateur qui a fait le post
            $postUser = User::getById($post['user_id']);
            $postUserProfileImage = !empty($postUser['profile_image']) ? '../uploads/profil/' . htmlspecialchars($postUser['profile_image']) : '../uploads/default.png';
            $commentCount = Comment::countCommentsByPostId($post['id']);

            ?>

            <div class="post">
                <!-- Affichage de l'image de profil de l'utilisateur qui a posté -->
                <div class="post-user-info">
                    <img src="<?php echo $postUserProfileImage; ?>" alt="Image de Profil de l'auteur" class="post-user-profile-pic">
                    <div class="post-user-name">
                    <?php if (!empty($postUser['first_name']) && !empty($postUser['last_name'])): ?>
                        <strong><?php echo htmlspecialchars($postUser['first_name'] . ' ' . $postUser['last_name']); ?></strong>
                    <?php else: ?>
                        <strong><?php echo htmlspecialchars($postUser['username']); ?></strong>
                    <?php endif; ?>

                    <span class="post-create"><?php echo timeAgo($post['created_at']); ?></span>
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
            <?php 
                // Supposons que $post['id'] et $user_id sont définis
                $selectedEmoji = Like::getEmojiTypeByPostId($post['id'], $_SESSION['user_id']);
                $selectedEmoji = $selectedEmoji ?: '👍'; // Utiliser '👍' comme emoji par défaut si aucun n'est trouvé
                // Définir le texte associé à l'emoji directement dans la vue
                switch ($selectedEmoji) {
                    case '👍':
                        $selectedText = "J'aime";
                        break;
                    case '❤️':
                        $selectedText = "J'adore";
                        break;
                    case '😂':
                        $selectedText = "Haha";
                        break;
                    case '😮':
                        $selectedText = "Waouh";
                        break;
                    case '😢':
                        $selectedText = "Solidaire";
                        break;
                    case '😡':
                        $selectedText = "Grrr";
                        break;
                    default:
                        $selectedText = "J'aime";
                        break;
                }

                $topEmojis = Like::getTopEmojisByPostId($post['id']);
                ?>
            <div class="count-container">
            <div class="like-count">

                <?php if ($topEmojis): ?>
                    <br>
                    <?php foreach ($topEmojis as $emoji): ?>
                       <span><?php echo $emoji['emoji_type']; ?>  </span>
                    <?php endforeach; ?>
                    <?php echo Like::countLikes($post['id']); ?>
                <?php endif; ?>
            </div>
            <div class="commentaire-count">

            <?php if ($commentCount>0): ?>
                <span><?php echo $commentCount; ?> commentaires</span>
            <?php endif; ?>
            </div>
            </div>
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

                <!-- Conteneur des emojis -->
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


            <!-- Formulaire de commentaire -->
            <form method="POST" action="comment" class="comment-form" id="comment-form-<?php echo $post['id']; ?>" style="display:none;">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <textarea name="comment_content" placeholder="Écrivez un commentaire..." required></textarea>
                <button type="submit" name="comment_post">➤</button>
            </form>

            <div class="comments hidden" id="comments-<?php echo $post['id']; ?>">
            <?php
                $comments = Comment::getCommentsByPostId($post['id']);
            ?>
            <?php foreach ($comments as $comment): 
                $commentUser = User::getById($comment['user_id']);
                $commentProfileImage = !empty($commentUser['profile_image']) ? '../uploads/profil/' . htmlspecialchars($commentUser['profile_image']) : '../uploads/default.png';
            ?>
                <div class="comment">
                    <img src="<?php echo $commentProfileImage; ?>" alt="Image de Profil Commentaire" class="comment-profile-pic">
                    <div class="comment-content">
                        <?php if (!empty($commentUser['first_name']) && !empty($commentUser['last_name'])): ?>
                            <strong><?php echo htmlspecialchars($commentUser['first_name'] . ' ' . $commentUser['last_name']); ?></strong>
                        <?php else: ?>
                            <strong><?php echo htmlspecialchars($commentUser['username']); ?></strong>
                        <?php endif; ?>                        
                        <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                    </div>
                    <small class="comment-date"><?php echo timeAgo($comment['created_at']); ?></small>

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
