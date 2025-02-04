<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user = getUserById($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $content]);
}

$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/index-style.css">

  
</head>
<body>
    <header>
    <nav>
    <div class="nav-container">
        <a href="pages/home.php" class="nav-link">Home</a>
        <a href="pages/profil.php" class="nav-link">Profile</a>

        <?php if (isLoggedIn()): ?>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
            <a href="register.php" class="nav-link">Register</a>
        <?php endif; ?>
    </div>
</nav>

        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
    </header>

    <div class="container">
        <div class="post-form">
            <form method="POST">
                <textarea name="content" placeholder="What's on your mind?" required></textarea>
                <button type="submit">Post</button>
            </form>
        </div>

        <h2>Posts</h2>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <strong><?php echo htmlspecialchars(getUserById($post['user_id'])['username']); ?></strong>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <small><?php echo $post['created_at']; ?></small>
            </div>
        <?php endforeach; ?>
    </div>

    <footer>
        <a href="logout.php">Logout</a>
    </footer>
</body>
</html>
