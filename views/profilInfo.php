<?php

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Inclure la connexion à la base de données

// Vérifier si une photo de profil est définie
$hasProfileImage = !empty($user['profile_image']);
$profileImage = $hasProfileImage ? '../uploads/profil/' . htmlspecialchars($user['profile_image']) : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Informations personnelles</title>
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
                <img src="<?php echo $profileImage; ?>" alt="Photo de profil" class="profile-pic">
            <?php else: ?>
                <div class="profile-pic default-pic"></div> <!-- Cercle noir -->
            <?php endif; ?>
        </div>

        <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($user['username'] ?? ''); ?></p>
        <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user['first_name'] ?? ''); ?></p>
        <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['last_name'] ?? ''); ?></p>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
        <p><strong>Date de naissance :</strong> <?php echo !empty($user['birth_date']) ? htmlspecialchars($user['birth_date']) : ''; ?></p>
        <p><strong>Téléphone :</strong> <?php echo !empty($user['phone_number']) ? htmlspecialchars($user['phone_number']) : ''; ?></p>
        <p><strong>Membre depuis :</strong> <?php echo !empty($user['created_at']) ? date('d F Y', strtotime($user['created_at'])) : ''; ?></p>
    </div>

    <!-- Boutons d'ajout, modification ou suppression -->
    <div class="profile-actions">
        <button onclick="toggleUploadForm()" class="button">
            <?php echo $hasProfileImage ? 'Modifier la photo' : 'Ajouter une photo de profil'; ?>
        </button>

        <?php if ($hasProfileImage): ?>
            <form action="delete-image" method="POST" style="display: inline;">
                <button type="submit" class="btn delete">Supprimer la photo</button>
            </form>
        <?php endif; ?>

        <button onclick="toggleEditForm()" class="button">Modifier mes informations</button>
    </div>

    <!-- Formulaire pour mettre à jour la photo de profil -->
    <form id="uploadForm" action="update-image" method="POST" enctype="multipart/form-data" style="display: none;">
        <label for="fileInput" class="custom-file-upload">
            Choisir un fichier
        </label>
        <input type="file" name="profile_pic" id="fileInput" accept="image/*" required onchange="updateFileName()">
        <span id="fileName">Aucun fichier sélectionné</span>
        <button type="submit" class="button">Téléverser</button>
    </form>

    <!-- Formulaire pour modifier les informations personnelles -->
    <form id="editForm" action="update-profile" method="POST" style="display: none;">
        <label>Prénom :</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>">

        <label>Nom :</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>">

        <label>Date de naissance :</label>
        <input type="date" name="birth_date" value="<?php echo !empty($user['birth_date']) ? htmlspecialchars($user['birth_date']) : ''; ?>">

        <label>Téléphone :</label>
        <input type="text" name="phone" value="<?php echo !empty($user['phone']) ? htmlspecialchars($user['phone']) : ''; ?>">

        <button type="submit" class="button">Enregistrer les modifications</button>
    </form>

    <?php include 'templates/footer.php'; ?>
</div>

<script src="views/static/js/profil-info.js"></script>

</body>
</html>
