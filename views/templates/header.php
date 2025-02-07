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
<style>
    /* Header */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #007bff;
    padding: 15px;
    border-radius: 10px 10px 0 0;
    color: white;
}

header h1 {
    margin: 0;
    font-size: 22px;
}

/* Conteneur de la photo de profil dans le header */
.header-profile {
    display: flex;
    align-items: center;
}

/* Style de l'image de profil dans le header */
.header-profile-pic {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
    background-color: #000;
}

/* Navigation Header */
.nav-header {
    display: flex;
    gap: 10px;
}

.nav-header a {
    color: white;
    text-decoration: none;
    font-size: 14px;
    padding: 8px 12px;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.2);
    transition: 0.3s ease-in-out;
}

.nav-header a:hover {
    background: rgba(255, 255, 255, 0.4);
}

/* Logout Button */
.logout {
    background: #dc3545 !important;
}

.logout:hover {
    background: #c82333 !important;
}

/* Tabs Navigation */
.tabs-nav {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 20px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
}

.tabs-nav a {
    text-decoration: none;
    color: #333;
    font-size: 15px;
    padding: 10px 15px;
    margin: 5px;
    background: #e9ecef;
    border-radius: 5px;
    transition: 0.3s ease-in-out;
}

.tabs-nav a:hover {
    background: #007bff;
    color: white;
}

/* Conteneur de la photo de profil */
.profile-container {
    text-align: center;
    margin-top: 20px;
}

/* Style de l'image de profil */
.profile-pic {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 3px solid #007bff;
    object-fit: cover;
    background-color: #000;
}

/* Bouton d'édition du profil */
.profile-actions {
    margin-top: 10px;
}

.profile-actions .button {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s ease;
}

.profile-actions .button:hover {
    background-color: #0056b3;
}

/* 📱 Responsive Design */
@media screen and (max-width: 768px) {
    header {
        flex-direction: column;
        text-align: center;
        padding: 10px;
    }

    .nav-header {
        flex-direction: column;
        gap: 5px;
    }

    .tabs-nav {
        flex-direction: column;
        align-items: center;
    }

    .tabs-nav a {
        width: 90%;
        text-align: center;
    }
}

</style>
<header>
    <div class="header-profile">
        <!-- 🔗 Rendre l'image de profil cliquable -->
        <a href="profil-info.php">
            <img src="<?php echo $profileImage; ?>" alt="Image de Profil" class="header-profile-pic">
        </a>
    </div>

    <nav class="nav-header">
        <a href="posts">🏠 Accueil</a>
        <a href="posts">📝 Mes Posts</a>
        <a href="friends">👫 Amis</a>
        <a href="contact">💬 Messages</a>
        <a href="users">🌎 Tous les utilisateurs</a>
        <a href="requests">🔔 Demandes d'amis</a>
        <a href="logout" class="logout">🚪 Déconnexion</a>
    </nav>
</header>
