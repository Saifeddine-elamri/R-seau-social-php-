<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupération des informations de l'utilisateur
$userId = $_SESSION['user_id'];
$user = User::getById($userId);

// Définition de l'image de profil avec fallback
$profileImage = !empty($user['profile_image']) ? 'uploads/' . htmlspecialchars($user['profile_image']) : 'uploads/default.png';
?>

<style>
/* 🎨 Styles de base */
header {
    background: #007bff;
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 12px 12px 0 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 10;
}

/* Conteneur du header pour bien aligner les éléments */
.header-container {
    display: flex;
    align-items: center;
    width: 100%;
    justify-content: space-between;
}

/* 🌍 Navigation principale */
.nav-header {
    display: flex;
    align-items: center;
    gap: 15px;
}

.nav-header a {
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 8px;

    transition: background 0.3s ease, transform 0.3s ease;
}

.nav-header a:hover {
    background: rgba(255, 255, 255, 0.4);
    transform: scale(1.05);
}

/* 🚪 Bouton de déconnexion */
.logout {
    background: #dc3545 !important;
}

.logout:hover {
    background: #c82333 !important;
}

/* 📱 Menu Hamburger */
.menu-toggle {
    display: none;
    font-size: 24px;
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.menu-toggle:hover {
    transform: scale(1.1);
}

/* 📷 Conteneur de la photo de profil */
.header-profile {
    display: flex;
    align-items: center;
    margin-right: 15px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.header-profile:hover {
    transform: scale(1.05);
}

/* 🖼️ Image de profil */
.header-profile-pic {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.header-profile-pic:hover {
    transform: scale(1.1);
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
}

/* 📱 Responsive - Affichage Mobile */
@media screen and (max-width: 768px) {
    .menu-toggle {
        display: block;
    }

    .nav-header {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 70px;
        right: 0;
        width: 100%;
        background: #007bff;
        text-align: center;
        padding: 15px 0;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .nav-header a {
        display: block;
        padding: 12px;
        font-size: 18px;
        background: none;
    }

    .nav-header.show {
        display: flex;
    }

    .header-container {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
}
</style>

<header>
    <div class="header-container">
        <!-- 📷 Image de profil cliquable -->
        <div class="header-profile">
            <a href="profil-info">
                <img src="<?php echo $profileImage; ?>" alt="Image de Profil" class="header-profile-pic">
            </a>
        </div>

        <!-- 🍔 Menu Hamburger -->
        <button class="menu-toggle" aria-label="Ouvrir le menu">☰</button>

        <!-- 📍 Navigation -->
        <nav class="nav-header">
            <a href="posts">🏠 Accueil</a>
            <a href="friends">👫 Amis</a>
            <a href="contact">💬 Messages</a>
            <a href="users">🌎 Tous les utilisateurs</a>
            <a href="requests">🔔 Demandes d'amis</a>
            <a href="logout" class="logout">🚪 Déconnexion</a>
        </nav>
    </div>
</header>

<script src="views/static/js/header.js"></script>

