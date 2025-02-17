<?php 
// Récupération des informations de l'utilisateur qui a créé le post
$postUser = User::getById($post['user_id']);

// Détermination de l'image de profil de l'utilisateur
// Si l'utilisateur a une image de profil, on l'affiche, sinon on utilise une image par défaut
$postUserProfileImage = !empty($postUser['profile_image']) 
    ? '../uploads/profil/' . htmlspecialchars($postUser['profile_image']) 
    : '../uploads/default.png';
?>

<div class="post">
    <!-- Informations de l'utilisateur qui a posté -->
    <div class="post-user-info">
        <!-- Affichage de l'image de profil de l'utilisateur -->
        <img src="<?php echo $postUserProfileImage; ?>" alt="Image de Profil de l'auteur" class="post-user-profile-pic">
        
        <!-- Affichage du nom complet de l'utilisateur et du temps écoulé depuis la publication -->
        <div class="post-user-name">
            <!-- On utilise htmlspecialchars pour sécuriser l'affichage du nom complet -->
            <strong><?php echo htmlspecialchars($postUser['first_name'] . ' ' . $postUser['last_name']); ?></strong>
            <!-- On utilise la fonction timeAgo pour afficher le temps relatif -->
            <span class="post-create"><?php echo timeAgo($post['created_at']); ?></span>
        </div>
    </div>

    <!-- Contenu du post -->
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

    <!-- Si le post contient une image, on l'affiche -->
    <?php if (!empty($post['image'])): ?>
        <img src="../uploads/images/<?php echo htmlspecialchars($post['image']); ?>" alt="Image du post" class="post-image">
    <?php endif; ?>

    <!-- Si le post contient une vidéo, on l'affiche avec un lecteur vidéo intégré -->
    <?php if (!empty($post['video'])): ?>
        <video class="video-gauche" controls>
            <source src="../uploads/videos/<?php echo htmlspecialchars($post['video']); ?>" type="video/mp4">
            <!-- Message affiché si le navigateur ne supporte pas la lecture de vidéos -->
            Votre navigateur ne supporte pas la lecture de vidéos.
        </video>
    <?php endif; ?>

    <!-- Comptage et actions (Likes & Commentaires) -->
    <?php include 'views/posts/post-interactions.php'; ?>

    <!-- Liste des commentaires -->
    <div class="comments hidden" id="comments-<?php echo $post['id']; ?>">
        <?php include 'views/posts/comment-list.php'; ?>
    </div>

</div>
