<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <link rel="stylesheet" type="text/css" href="views/static/css/all-users-style.css">
</head>
<body>

<div class="container">
    <?php include 'templates/header.php'; ?>

    <h1>👥 Utilisateurs ( <?php echo count($users); ?> )</h1>


    <div class="users-list">
        <?php foreach ($users as $user): ?>
            <div class="user-card">
                <!-- Image du profil avec sécurité sur le chemin -->
                <img src="<?php echo !empty($user['profile_image']) ? '../uploads/profil/' . htmlspecialchars($user['profile_image']) : '../uploads/default.png'; ?>" 
                     alt="Profile Picture" class="profile-pic">

                <div class="user-info">
                    <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                </div>

                <div class="user-actions">
                    <!-- Vérification de l'état de l'ami -->
                    <?php if (in_array($user['id'], $friend_ids)): ?>
                        <!-- Si déjà ami -->
                        <button class="button friend">✅ Friend</button>
                    <?php elseif (in_array($user['id'], $pendingRequests)): ?>
                        <!-- Si demande en attente -->
                        <form method="POST" action="cancel-request">
                            <input type="hidden" name="friend_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <button type="submit" class="button pending">⏳ Pending (Cancel)</button>
                        </form>
                    <?php else: ?>
                        <!-- Si aucun statut (donc possibilité d'ajouter en ami) -->
                        <form method="POST" action="add-friend">
                            <input type="hidden" name="friend_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <button type="submit" class="button add-friend">➕ Add Friend</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php include 'templates/footer.php'; ?>
</div>

</body>
</html>
