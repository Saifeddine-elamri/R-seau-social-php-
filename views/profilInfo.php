<?php
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialiser le contrôleur


// Vérifier si une photo de profil est déjà définie
$hasProfileImage = !empty($user['profile_image']);
$profileImage = $hasProfileImage ? '../uploads/profil/' . htmlspecialchars($user['profile_image']) : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Info</title>
    <link rel="stylesheet" href="views/static/css/profil-info-style.css">
</head>
<body>

<div class="container">
<?php include 'templates/header.php'; ?>

    <h1>Mon Profil</h1>
    
    <div class="profile-card">
        <!-- Affichage de la photo ou d'un cercle noir -->
        <div class="profile-pic-container">
            <?php if ($hasProfileImage): ?>
                <img src="<?php echo $profileImage; ?>" alt="Profile Picture" class="profile-pic">
            <?php else: ?>
                <div class="profile-pic default-pic"></div> <!-- Cercle noir -->
            <?php endif; ?>
        </div>

        <p><strong>Nom d'utilisateur:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Membre depuis:</strong> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
    </div>

    <!-- Boutons d'ajout, modification ou suppression -->
    <div class="profile-actions">
        <button onclick="toggleUploadForm()" class="button">
            <?php echo $hasProfileImage ? 'Modifier la photo' : 'Ajouter une photo de profil'; ?>
        </button>

        <?php if ($hasProfileImage): ?>
            <form action="delete-image" method="POST" style="display: inline;">
                <button type="submit" class="button delete">Supprimer la photo</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- Formulaire caché pour uploader une nouvelle photo -->
    <form id="uploadForm" action="update-image" method="POST" enctype="multipart/form-data" style="display: none;">
        <label for="fileInput" class="custom-file-upload">
            Choisir un fichier
        </label>
        <input type="file" name="profile_pic" id="fileInput" accept="image/*" required onchange="updateFileName()">
        <span id="fileName">Aucun fichier sélectionné</span>
        <button type="submit" class="button">Téléverser</button>
    </form>

    <?php include 'templates/footer.php'; ?>

</div>


<script src="views/static/js/profil-info.js"></script>

</body>
</html>
