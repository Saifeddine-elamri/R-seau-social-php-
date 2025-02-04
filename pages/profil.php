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

// Récupérer les posts de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/profil-style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>My Profile</h1>
            <a href="home.php">Home</a>
            <a href="../logout.php">Logout</a>
        </header>

        <section class="profile-info">
            <h2><?php echo $user['username']; ?></h2>
            <p>Email: <?php echo $user['email']; ?></p>
            <p>Member since: <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
        </section>

        <section class="posts">
    <h2>My Posts</h2>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <p><?php echo htmlspecialchars($post['content']); ?></p>
            <small><?php echo $post['created_at']; ?></small>
            
            <!-- Formulaire pour modifier un post -->
            <a href="editPost.php?id=<?php echo $post['id']; ?>">Edit</a>

            <!-- Formulaire pour supprimer un post -->
            <form method="POST" action="deletePost.php" style="display:inline;">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
            </form>
        </div>
    <?php endforeach; ?>
</section>

        <h2>Your Friends</h2>
        <?php
        // Afficher la liste des amis (fonctionnalité à implémenter dans le contrôleur)
         $friends = getFriends($_SESSION['user_id']);
         foreach ($friends as $friend) {
         echo "<p>" . htmlspecialchars($friend['username']) . "</p>";
         }
    ?>
    </div>
</body>
</html>