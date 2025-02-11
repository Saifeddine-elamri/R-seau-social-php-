<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définition du charset pour garantir le bon affichage des caractères spéciaux -->
    <meta charset="UTF-8">
    <!-- Définition de la viewport pour garantir une bonne mise en page sur les appareils mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre de la page affiché dans l'onglet du navigateur -->
    <title>Friends</title>
    <!-- Lien vers la feuille de style spécifique à cette page -->
    <link rel="stylesheet" href="views/static/css/friends-style.css">
</head>
<body>

<div class="container">
    <!-- Inclusion de l'en-tête de la page (header.php) -->
    <?php include 'templates/header.php'; ?>

    <!-- Titre principal de la page -->
    <h1>👥 Amis</h1>

    <!-- Vérifie si la liste des amis est vide -->
    <?php if (empty($friends)): ?>
        <!-- Affiche un message si l'utilisateur n'a pas d'amis -->
        <p class="message warning">Vous n'avez pas encore d'amis.</p>
    <?php else: ?>
        <!-- Si des amis existent, affiche-les dans une liste -->
        <div class="friends-list">
            <!-- Parcourt chaque ami dans la liste et affiche ses informations -->
            <?php foreach ($friends as $friend): ?>
                <div class="friend-card">
                    <!-- Affiche l'image de profil de l'ami, avec une image par défaut si aucune image n'est fournie -->
                    <img src="<?php echo !empty($friend['profile_image']) ? '../uploads/profil/' . htmlspecialchars($friend['profile_image']) : '../uploads/default.png'; ?>" 
                         alt="Profile Picture" class="profile-pic">
                    <!-- Affiche le nom d'utilisateur de l'ami -->
                    <h3><?php echo htmlspecialchars($friend['username']); ?></h3>
                    <!-- Affiche l'email de l'ami -->
                    <p>Email: <?php echo htmlspecialchars($friend['email']); ?></p>
                    
                    <!-- Formulaire pour supprimer l'ami de la liste d'amis -->
                    <form action="/delete-friend" method="POST">
                        <!-- Envoie l'ID de l'ami à supprimer via un champ caché -->
                        <input type="hidden" name="friend_id" value="<?php echo $friend['id']; ?>">
                        <!-- Bouton pour supprimer l'ami -->
                        <button type="submit" class="remove-button">❌ Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Inclusion du pied de page (footer.php) -->
<?php include 'templates/footer.php'; ?>
    

</div>

</body>
</html>
