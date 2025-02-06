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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_post'])) {
    $post_id = $_POST['post_id'];
    $comment_content = trim($_POST['comment_content']);

    if (!empty($comment_content)) {
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, content, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$post_id, $comment_content]);
    }
}
// Gestion de la publication d'un message
if ($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['content']) ) {
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
    <?php foreach ($posts as $post): 
        $postUser = getUserById($post['user_id']);
        $profileImage = !empty($postUser['profile_image']) ? '../uploads/' . htmlspecialchars($postUser['profile_image']) : '../uploads/default.png';
    ?>
        <div class="post">
            <div class="post-header">
                <img src="<?php echo $profileImage; ?>" alt="Profile Picture" class="post-profile-pic">
                <strong><?php echo $postUser['username']; ?></strong>
            </div>
            <p><?php echo $post['content']; ?></p>
            <small><?php echo $post['created_at']; ?></small>

            <!-- Bouton Like -->
            <form method="POST" style="display:inline;">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <button type="submit" name="like_post">Like</button>
            </form>

            <!-- Affichage des likes -->
            <?php
            $stmt = $pdo->prepare("SELECT COUNT(*) as like_count FROM likes WHERE post_id = ?");
            $stmt->execute([$post['id']]);
            $like_count = $stmt->fetch(PDO::FETCH_ASSOC)['like_count'];
            ?>
            <span><?php echo $like_count; ?> Likes</span>

            <!-- Formulaire de commentaire -->
            <form method="POST" style="display:block;">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <textarea name="comment_content" placeholder="Write a comment..." required></textarea>
                <button type="submit" name="comment_post">Comment</button>
            </form>

            <!-- Affichage des commentaires -->
            <?php
            $stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at ASC");
            $stmt->execute([$post['id']]);
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="comments">
                <?php foreach ($comments as $comment): 
                    $commentUser = getUserById($comment['user_id']);
                    $commentProfileImage = !empty($commentUser['profile_image']) ? '../uploads/' . htmlspecialchars($commentUser['profile_image']) : '../uploads/default.png';
                ?>
                    <div class="comment">
                        <img src="<?php echo $commentProfileImage; ?>" alt="Profile Picture" class="comment-profile-pic">
                        <strong><?php echo $commentUser['username']; ?></strong>
                        <p><?php echo $comment['content']; ?></p>
                        <small><?php echo $comment['created_at']; ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>

    </div>
</body>
</html>