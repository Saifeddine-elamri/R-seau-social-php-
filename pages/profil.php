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
<h2>Send a Message</h2>

<form method="POST" action="sendMessage.php">
    <label for="friend_id">Select a Friend:</label>
    <select name="friend_id" required>
        <?php
        // Afficher la liste des amis (les amis sont déjà récupérés dans $friends)
        foreach ($friends as $friend) {
            echo "<option value='" . $friend['id'] . "'>" . htmlspecialchars($friend['username']) . "</option>";
        }
        ?>
    </select>

    <label for="message">Your Message:</label>
    <textarea name="message" rows="4" required></textarea>

    <button type="submit">Send Message</button>
</form>

<h2>Messages</h2>
<?php
// Récupérer les messages de l'utilisateur

// Récupérer tous les messages envoyés et reçus par l'utilisateur
$stmt = $pdo->prepare("SELECT m.*, 
                              u.username AS sender_username,
                              r.username AS receiver_username
                       FROM messages m
                       LEFT JOIN users u ON m.sender_id = u.id
                       LEFT JOIN users r ON m.receiver_id = r.id
                       WHERE m.sender_id = ? OR m.receiver_id = ?
                       ORDER BY m.created_at DESC");
$stmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($messages as $message) {
    if ($message['sender_id'] == $_SESSION['user_id']) {
        // Afficher un message envoyé
        echo "<div class='message sent'>";
        echo "<p><strong>To: </strong>" . htmlspecialchars($message['receiver_username']) . "</p>";
        echo "<p>" . htmlspecialchars($message['message']) . "</p>";
        echo "<small>Sent on: " . $message['created_at'] . "</small>";
        echo "</div>";
    } else {
        // Afficher un message reçu
        echo "<div class='message received'>";
        echo "<p><strong>From: </strong>" . htmlspecialchars($message['sender_username']) . "</p>";
        echo "<p>" . htmlspecialchars($message['message']) . "</p>";
        echo "<small>Received on: " . $message['created_at'] . "</small>";
        echo "</div>";
    }
}
?>




</div>



</body>
</html>