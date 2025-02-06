<?php


if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Récupérer les amis et les demandes en attente
$friends = getFriends($_SESSION['user_id']);
$friend_ids = array_column($friends, 'id'); // Liste des ID des amis

// Récupérer les demandes en attente
$stmt = $pdo->prepare("SELECT friend_id FROM friends WHERE user_id = ? AND status = 'pending'");
$stmt->execute([$_SESSION['user_id']]);
$pendingRequests = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'friend_id');

// Récupérer tous les utilisateurs sauf l'utilisateur connecté
$stmt = $pdo->prepare("SELECT * FROM users WHERE id != ?");
$stmt->execute([$_SESSION['user_id']]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <link rel="stylesheet" type="text/css" href="../css/all-users-style.css">
</head>
<body>

<div class="container">
    <h1>👥 All Users</h1>

    <div class="users-list">
        <?php foreach ($users as $user): ?>
            <div class="user-card">
                <img src="<?php echo !empty($user['profile_image']) ? '../uploads/' . htmlspecialchars($user['profile_image']) : '../uploads/default.png'; ?>" 
                     alt="Profile Picture" class="profile-pic">
                <div class="user-info">
                    <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                </div>

                <div class="user-actions">
                    <?php if (in_array($user['id'], $friend_ids)): ?>
                        <button class="button friend">✅ Friend</button>
                        <?php elseif (in_array($user['id'], $pendingRequests)): ?>
                            <form method="POST" action="cancel-request">
                                <input type="hidden" name="friend_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="button pending">⏳ Pending (Cancel)</button>
                            </form>
                    <?php else: ?>
                        <form method="POST" action="add-friend">
                            <input type="hidden" name="friend_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="button add-friend">➕ Add Friend</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="/" class="button back">🔙 Back to Profile</a>
</div>

</body>
</html>
