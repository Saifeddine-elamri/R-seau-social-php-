<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

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

    <div class="users-list">
        <?php foreach ($users as $user): ?>
            <div class="user-card">
                <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                <a href="sendFriendRequest.php?friend_id=<?php echo $user['id']; ?>" class="button">Send Friend Request</a>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="profil.php" class="button back">Back to Profile</a>
</div>

</body>
</html>
