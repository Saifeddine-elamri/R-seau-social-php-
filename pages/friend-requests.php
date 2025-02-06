<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM friends WHERE friend_id = ? AND status = 'pending'");
$stmt->execute([$_SESSION['user_id']]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Friend Requests</title>
    <link rel="stylesheet" href="../css/friend-requests-style.css">
</head>
<body>

<div class="container">
    <h1>Friend Requests</h1>

    <?php if (empty($requests)): ?>
        <p class="message warning">No pending friend requests.</p>
    <?php else: ?>
        <?php foreach ($requests as $request): 
            $user = getUserById($request['user_id']);
        ?>
            <div class="friend-request">
                <h3>From: <?php echo htmlspecialchars($user['username']); ?></h3>
                
                <form method="POST" action="acceptFriendRequest.php" class="inline-form">
                    <input type="hidden" name="friend_id" value="<?php echo $request['user_id']; ?>">
                    <button type="submit" class="button accept">Accept</button>
                </form>

                <form method="POST" action="deleteFriendRequest.php" class="inline-form">
                    <input type="hidden" name="friend_id" value="<?php echo $request['user_id']; ?>">
                    <button type="submit" class="button reject">Reject</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="profil.php" class="button back">Back to Profile</a>
</div>

</body>
</html>
