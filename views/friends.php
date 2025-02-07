<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends</title>
    <link rel="stylesheet" href="views/static/css/friends-style.css">
</head>
<body>

<div class="container">
<?php include 'templates/header.php'; ?>

    <h1>👥 Your Friends</h1>

    <?php if (empty($friends)): ?>
        <p class="message warning">You have no friends yet.</p>
    <?php else: ?>
        <div class="friends-list">
            <?php foreach ($friends as $friend): ?>
                <div class="friend-card">
                    <img src="<?php echo !empty($friend['profile_image']) ? '../uploads/' . htmlspecialchars($friend['profile_image']) : '../uploads/default.png'; ?>" 
                         alt="Profile Picture" class="profile-pic">
                    <h3><?php echo htmlspecialchars($friend['username']); ?></h3>
                    <p>Email: <?php echo htmlspecialchars($friend['email']); ?></p>
                    
                    <!-- Formulaire pour supprimer un ami -->
                    <form action="/delete-friend" method="POST">
                        <input type="hidden" name="friend_id" value="<?php echo $friend['id']; ?>">
                        <button type="submit" class="remove-button">❌ Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php include 'templates/footer.php'; ?>

</div>

</body>
</html>
