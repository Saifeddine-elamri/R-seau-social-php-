<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user = getUserById($_SESSION['user_id']);

// Gestion de la publication d'un message
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $content]);
}

// Récupérer tous les posts
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="../css/home-style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome Home, <?php echo $user['username']; ?></h1>
            <a href="profil.php">My Profile</a>
            <a href="../logout.php">Logout</a>
        </header>

        <section class="post-form">
            <h2>Create a Post</h2>
            <form method="POST">
                <textarea name="content" placeholder="What's on your mind?" required></textarea>
                <button type="submit">Post</button>
            </form>
        </section>

        <section class="posts">
            <h2>Recent Posts</h2>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <strong><?php echo getUserById($post['user_id'])['username']; ?></strong>
                    <p><?php echo $post['content']; ?></p>
                    <small><?php echo $post['created_at']; ?></small>
                </div>
            <?php endforeach; ?>
        </section>
    </div>
</body>
</html>