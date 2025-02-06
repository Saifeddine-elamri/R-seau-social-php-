<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

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
<html>
<head>
    <title>All Users</title>
    <link rel="stylesheet" type="text/css" href="../css/all-users-style.css">
</head>
<body>

<div class="container">
    <h1>All Users</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <p class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>

    <div class="users-list">
        <?php foreach ($users as $user): ?>
            <div class="user-card">
                <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

                <?php if (in_array($user['id'], $friend_ids)): ?>
                    <button class="button friend">Friend</button>
                <?php elseif (in_array($user['id'], $pendingRequests)): ?>
                    <form method="POST" action="sendFriendRequest.php">
                        <input type="hidden" name="friend_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" class="button pending">Invitation Sent (Cancel)</button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="sendFriendRequest.php">
                        <input type="hidden" name="friend_id" value="<?php echo $user['id']; ?>">
                        <button type="submit" class="button">Send Friend Request</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="profil.php" class="button back">Back to Profile</a>
</div>

</body>
</html>
