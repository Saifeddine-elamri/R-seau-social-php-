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
    padding: 25px 35px;
    border-radius: 12px 12px 0 0;
    color: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    transition: background 0.4s ease-in-out, box-shadow 0.3s ease;
}

header:hover {
    background: #0056b3;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

header h1 {
    margin: 0;
    font-size: 26px;
    font-weight: bold;
    letter-spacing: 1px;
}

/* Conteneur de la photo de profil dans le header */
.header-profile {
    display: flex;
    align-items: center;
    transition: transform 0.3s ease;
}

.header-profile:hover {
    transform: scale(1.05);
}

/* Style de l'image de profil dans le header */
.header-profile-pic {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    border: 3px solid white;
    object-fit: cover;
    background-color: #000;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.header-profile-pic:hover {
    transform: scale(1.1);
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.7);
}

/* Navigation Header */
.nav-header {
    display: flex;
    gap: 18px;
    font-size: 17px;
    font-weight: 500;
}

.nav-header a {
    color: white;
    text-decoration: none;
    padding: 12px 18px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.2);
    transition: background 0.3s ease, color 0.3s ease, transform 0.3s ease;
}

.nav-header a:hover {
    background: rgba(255, 255, 255, 0.4);
    color: #007bff;
    transform: scale(1.05);
}

/* Logout Button */
.logout {
    background: #dc3545 !important;
}

.logout:hover {
    background: #c82333 !important;
    transform: scale(1.05);
}

/* Tabs Navigation */
.tabs-nav {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 30px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.tabs-nav a {
    text-decoration: none;
    color: #333;
    font-size: 16px;
    padding: 15px 20px;
    margin: 10px;
    background: #e9ecef;
    border-radius: 8px;
    transition: 0.3s ease, transform 0.3s ease;
    font-weight: 500;
}

.tabs-nav a:hover {
    background: #007bff;
    color: white;
    transform: translateY(-5px);
}

/* Conteneur de la photo de profil */
.profile-container {
    text-align: center;
    margin-top: 35px;
}

/* Style de l'image de profil */
.profile-pic {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 4px solid #007bff;
    object-fit: cover;
    background-color: #000;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.profile-pic:hover {
    transform: scale(1.15);
    box-shadow: 0 10px 25px rgba(0, 123, 255, 0.4);
}

/* Bouton d'édition du profil */
.profile-actions {
    margin-top: 20px;
}

.profile-actions .button {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 12px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s ease, transform 0.3s ease;
}

.profile-actions .button:hover {
    background-color: #0056b3;
    transform: translateY(-5px);
}

/* 📱 Responsive Design */
@media screen and (max-width: 768px) {
    header {
        flex-direction: column;
        text-align: center;
        padding: 15px 25px;
    }

    .nav-header {
        flex-direction: column;
        gap: 12px;
        margin-top: 20px;
    }

    .tabs-nav {
        flex-direction: column;
        align-items: center;
    }

    .tabs-nav a {
        width: 85%;
        text-align: center;
    }

    .profile-pic {
        width: 130px;
        height: 130px;
    }
}
</style>
<header>
    <div class="header-profile">
        <!-- 🔗 Rendre l'image de profil cliquable -->
        <a href="profil-info">
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
