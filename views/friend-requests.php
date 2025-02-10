<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Définition du charset pour gérer les caractères spéciaux -->
    <meta charset="UTF-8">
    <!-- Définition de la viewport pour un affichage responsive sur les appareils mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre de la page -->
    <title>Friend Requests</title>
    <!-- Lien vers le fichier CSS spécifique pour cette page -->
    <link rel="stylesheet" href="views/static/css/friend-requests-style.css">
</head>
<body>

<div class="container">
    <!-- Inclusion du fichier header.php pour afficher le header de la page -->
    <?php include 'templates/header.php'; ?>

    <!-- Titre principal de la page -->
    <h1>Friend Requests</h1>

    <!-- Vérifie si la liste des demandes d'amis est vide -->
    <?php if (empty($requests)): ?>
        <!-- Affiche un message si aucune demande d'ami n'est présente -->
        <p class="message warning">No pending friend requests.</p>
    <?php else: ?>
        <!-- Si des demandes sont présentes, affiche-les dans une liste -->
        <div class="requests-list">
            <!-- Parcours chaque demande d'ami dans la liste -->
            <?php foreach ($requests as $request): 
                // Récupère les informations de l'utilisateur associé à la demande d'ami
                $user = getUserById($request['user_id']); 
                
                // Vérifie si l'utilisateur a une photo de profil, sinon on utilise une image par défaut
                $profile_picture = !empty($user['profile_image']) ? '../uploads/' . $user['profile_image'] : 'uploads/default_profile.png';
            ?>
                <!-- Affichage de la demande d'ami -->
                <div class="friend-request">
                    <!-- Affichage de l'image de profil de l'utilisateur -->
                    <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-pic">
                    <div class="request-info">
                        <!-- Affichage du nom d'utilisateur -->
                        <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                        <!-- Affichage de l'email de l'utilisateur -->
                        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    
                    <div class="request-actions">
                        <!-- Formulaire pour accepter la demande d'ami -->
                        <form method="POST" action="/accept-request">
                            <!-- Envoi de l'ID de l'utilisateur qui a envoyé la demande -->
                            <input type="hidden" name="friend_id" value="<?php echo $request['user_id']; ?>">
                            <!-- Bouton pour accepter la demande -->
                            <button type="submit" class="button accept">✔ Accept</button>
                        </form>

                        <!-- Formulaire pour rejeter la demande d'ami -->
                        <form method="POST" action="/delete-request">
                            <!-- Envoi de l'ID de l'utilisateur qui a envoyé la demande -->
                            <input type="hidden" name="friend_id" value="<?php echo $request['user_id']; ?>">
                            <!-- Bouton pour rejeter la demande -->
                            <button type="submit" class="button reject">✖ Reject</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Inclusion du fichier footer.php pour afficher le footer de la page -->
    <?php include 'templates/footer.php'; ?>

</div>

</body>
</html>
