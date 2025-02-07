<?php
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les informations de l'utilisateur connecté
$userId = $_SESSION['user_id'];
$user = User::getById($userId); // Récupère les infos de l'utilisateur à partir de la base de données

// Vérifier si l'utilisateur a une photo de profil
$profileImage = !empty($user['profile_image']) ? '../uploads/' . htmlspecialchars($user['profile_image']) : '../uploads/default.png';
?>

<header>
    <div class="header-profile">
        <!-- 🔗 Rendre l'image de profil cliquable -->
        <a href="profil-info.php">
            <img src="<?php echo $profileImage; ?>" alt="Image de Profil" class="header-profile-pic">
        </a>
    </div>

    <nav class="nav-header">
        <a href="profil">🏠 Accueil</a>
        <a href="posts">📝 Mes Posts</a>
        <a href="friends">👫 Amis</a>
        <a href="contact">💬 Messages</a>
        <a href="users">🌎 Tous les utilisateurs</a>
        <a href="requests">🔔 Demandes d'amis</a>
        <a href="logout" class="logout">🚪 Déconnexion</a>
    </nav>
</header>
