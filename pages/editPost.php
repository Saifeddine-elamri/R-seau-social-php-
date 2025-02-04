<?php
session_start();
include 'includes/header.php';
include 'includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Vérification de l'ID du post et récupération du post
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: home.php");
    exit();
}

$postId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->execute([$postId, $_SESSION['user_id']]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header("Location: home.php");
    exit();
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newContent = $_POST['content'];
    
    // Mettre à jour le post
    $stmt = $pdo->prepare("UPDATE posts SET content = ? WHERE id = ?");
    $stmt->execute([$newContent, $postId]);
    
    header("Location: home.php");
    exit();
}
?>

<div class="container">
    <h1>Edit Post</h1>
    <form method="POST">
        <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        <button type="submit">Update Post</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
