<div class="new-post-form">
    <form method="POST" enctype="multipart/form-data" action="add-post" class="post-form">
        <div class="post-header">
            <a href="profil-info">
                <img src="<?php echo $UserProfileImage; ?>" alt="Image de Profil" class="user-profile-picture">
            </a>
            <textarea name="content" placeholder="Quoi de neuf..." required class="post-content"></textarea>
        </div>
        <hr class="post-separator">
        <div class="file-upload-container">
            <label for="post_video" class="upload-label" title="Ajouter une vidéo">📹 Vidéo</label>
            <label for="post_image" class="upload-label" title="Ajouter une image">📷 Photo</label>
            <input type="file" id="post_image" name="post_image" accept="image/*" class="file-input">
            <input type="file" id="post_video" name="post_video" accept="video/*" class="file-input">
            <button type="submit"><span class="send-icon">➤</span></button>
        </div>
    </form>
</div>
