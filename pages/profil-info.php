<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user = getUserById($_SESSION['user_id']);

// Vérifier si une photo de profil est déjà définie
$hasProfileImage = !empty($user['profile_image']);
$profileImage = $hasProfileImage ? '../uploads/' . htmlspecialchars($user['profile_image']) : null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile Info</title>
    <link rel="stylesheet" href="../css/profil-info-style.css">
</head>
<body>

<div class="container">
    <h1>Profile Info</h1>
    
    <div class="profile-card">
        <!-- Affichage de la photo ou d'un cercle noir -->
        <div class="profile-pic-container">
            <?php if ($hasProfileImage): ?>
                <img src="<?php echo $profileImage; ?>" alt="Profile Picture" class="profile-pic">
            <?php else: ?>
                <div class="profile-pic default-pic"></div> <!-- Cercle noir -->
            <?php endif; ?>
        </div>

        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Member since:</strong> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
    </div>

    <!-- Boutons d'ajout, modification ou suppression -->
    <div class="profile-actions">
        <button onclick="toggleUploadForm()" class="button">
            <?php echo $hasProfileImage ? 'Edit Profile Picture' : 'Add Profile Picture'; ?>
        </button>

        <?php if ($hasProfileImage): ?>
            <form action="deleteProfilePic.php" method="POST" style="display: inline;">
                <button type="submit" class="button delete">Delete Profile Picture</button>
            </form>
        <?php endif; ?>
    </div>

<!-- Formulaire caché pour uploader une nouvelle photo -->
<form id="uploadForm" action="uploadProfilePic.php" method="POST" enctype="multipart/form-data" style="display: none;">
    <label for="fileInput" class="custom-file-upload">
        Choose File
    </label>
    <input type="file" name="profile_pic" id="fileInput" accept="image/*" required onchange="updateFileName()">
    <span id="fileName">No file selected</span>
    <button type="submit" class="button">Upload</button>
</form>

    <a href="profil.php" class="button back">Back to Profile</a>
</div>

<script>
function toggleUploadForm() {
    var form = document.getElementById("uploadForm");
    form.style.display = (form.style.display === "none") ? "block" : "none";
}


function updateFileName() {
    var input = document.getElementById('fileInput');
    var fileName = document.getElementById('fileName');

    if (input.files.length > 0) {
        fileName.textContent = input.files[0].name;
        fileName.style.color = "#28a745"; // Changer la couleur en vert
    } else {
        fileName.textContent = "No file selected";
        fileName.style.color = "#555"; // Retour à la couleur d'origine
    }
}

</script>

</body>
</html>
