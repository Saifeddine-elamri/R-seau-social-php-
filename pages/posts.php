<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Posts</title>
    <link rel="stylesheet" href="../css/posts-style.css">
</head>
<body>

<div class="container">
    <h1>My Posts</h1>

    <?php if (empty($posts)): ?>
        <p class="message">You haven't posted anything yet.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div class="post-card">
                <p><?php echo htmlspecialchars($post['content']); ?></p>
                <small><?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?></small>
                
                <div class="actions">
                    <a href="editPost.php?id=<?php echo $post['id']; ?>" class="button">Edit</a>
                    <form method="POST" action="deletePost.php" class="inline-form">
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                        <button type="submit" class="button-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="profil.php" class="button">Back to Profile</a>
</div>

</body>
</html>
