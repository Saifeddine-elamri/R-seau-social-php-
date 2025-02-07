<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friend Requests</title>
    <link rel="stylesheet" href="views/static/css/friend-requests-style.css">
</head>
<body>

<div class="container">
<?php include 'templates/header.php'; ?>

    <h1>Friend Requests</h1>

    <?php if (empty($requests)): ?>
        <p class="message warning">No pending friend requests.</p>
    <?php else: ?>
        <div class="requests-list">
            <?php foreach ($requests as $request): 
                $user = getUserById($request['user_id']); // Récupérer les infos de l'utilisateur
                
                // Vérifier si l'utilisateur a une photo, sinon utiliser une image par défaut
                $profile_picture = !empty($user['profile_image']) ? '../uploads/' . $user['profile_image'] : 'uploads/default_profile.png';
            ?>
                <div class="friend-request">
                    <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-pic">
                    <div class="request-info">
                        <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    
                    <div class="request-actions">
                        <!-- Accepter la demande -->
                        <form method="POST" action="/accept-request">
                            <input type="hidden" name="friend_id" value="<?php echo $request['user_id']; ?>">
                            <button type="submit" class="button accept">✔ Accept</button>
                        </form>

                        <!-- Rejeter la demande -->
                        <form method="POST" action="/delete-request">
                            <input type="hidden" name="friend_id" value="<?php echo $request['user_id']; ?>">
                            <button type="submit" class="button reject">✖ Reject</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php include 'templates/footer.php'; ?>

</div>

</body>
</html>
