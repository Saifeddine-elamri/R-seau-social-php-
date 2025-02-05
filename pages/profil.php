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
        <nav class="tabs-nav">
        <button class="tab-button" onclick="showSection('profile-info')">Profile Info</button>
        <button class="tab-button" onclick="showSection('posts')">My Posts</button>
        <button class="tab-button" onclick="showSection('amis')">Friends</button>
        <button class="tab-button" onclick="showSection('send-message')">Send Message</button>
        <button class="tab-button" onclick="showSection('messages')">Messages</button>
        <button class="tab-button" onclick="showSection('all-users')">All Users</button>
        <button class="tab-button" onclick="showSection('friend-requests')">Friend Requests</button>
        </nav>

        <section class="section-content" id="profile-info">
            <h2><?php echo $user['username']; ?></h2>
            <p>Email: <?php echo $user['email']; ?></p>
            <p>Member since: <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
        </section>

        <section class="section-content" id="posts">
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
<section class="section-content" id="amis">
    <h2>Your Friends</h2>
    <div class="amis-liste">
        <?php
        // Récupérer la liste des amis
        $friends = getFriends($_SESSION['user_id']);
        
        // Vérifiez si l'utilisateur a des amis
        if (empty($friends)) {
            echo '<p>You have no friends yet. Start adding friends!</p>';
        } else {
            // Afficher les amis si la liste n'est pas vide
            foreach ($friends as $friend) {
                echo '<div class="ami">';
                
                // Affichage de l'image de profil de l'ami
                echo '<div class="ami-image">';
                echo '</div>';
                
                // Affichage du nom de l'ami
                echo '<h3>' . htmlspecialchars($friend['username']) . '</h3>';
                
                // Description de l'ami (ici on suppose que l'email est une donnée à afficher)
                echo '<p class="ami-email">' . htmlspecialchars($friend['email']) . '</p>';
                
                echo '</div>';
            }
        }
        ?>
    </div>
</section>

<section class="section-content" id="send-message">
    <h2>Send a Message</h2>

    <form method="POST" action="sendMessage.php" class="message-form">
        <label for="friend_id">Select a Friend:</label>
        <select name="friend_id" id="friend_id" required>
            <?php
            // Afficher la liste des amis (les amis sont déjà récupérés dans $friends)
            foreach ($friends as $friend) {
                echo "<option value='" . $friend['id'] . "'>" . htmlspecialchars($friend['username']) . "</option>";
            }
            ?>
        </select>

        <label for="message">Your Message:</label>
        <textarea name="message" id="message" rows="4" placeholder="Type your message here..." required></textarea>

        <button type="submit" class="btn-submit">Send Message</button>
    </form>
</section>

<section class="section-content" id="messages">
    <h2>Messages</h2>

    <?php
    // Récupérer les messages de l'utilisateur
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
            // Message envoyé
            echo "<div class='message sent'>";
            echo "<div class='message-header'>";
            echo "<strong>To:</strong> " . htmlspecialchars($message['receiver_username']);
            echo "<span class='message-time'>" . date('F j, Y, g:i a', strtotime($message['created_at'])) . "</span>";
            echo "</div>";
            echo "<p>" . htmlspecialchars($message['message']) . "</p>";
            echo "</div>";
        } else {
            // Message reçu
            echo "<div class='message received'>";
            echo "<div class='message-header'>";
            echo "<strong>From:</strong> " . htmlspecialchars($message['sender_username']);
            echo "<span class='message-time'>" . date('F j, Y, g:i a', strtotime($message['created_at'])) . "</span>";
            echo "</div>";
            echo "<p>" . htmlspecialchars($message['message']) . "</p>";
            echo "</div>";
        }
    }
    ?>
</section>

<section class="section-content" id="all-users">
    <h2>All Users</h2>
    <div class="user-list">
        <?php
        // Récupérer tous les utilisateurs sauf l'utilisateur connecté
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id != ?");
        $stmt->execute([$_SESSION['user_id']]);
        $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($allUsers as $user) {
            // Vérifier si l'utilisateur a déjà une demande en attente ou s'il est déjà ami
            $stmt = $pdo->prepare("SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
            $stmt->execute([$_SESSION['user_id'], $user['id'], $user['id'], $_SESSION['user_id']]);
            $existingFriend = $stmt->fetch(PDO::FETCH_ASSOC);

            echo '<div class="user">';
            echo '<h3>' . htmlspecialchars($user['username']) . '</h3>';
            echo '<p>Email: ' . htmlspecialchars($user['email']) . '</p>';

            if ($existingFriend) {
                // Si la relation est "accepted"
                if ($existingFriend['status'] == 'accepted') {
                    echo '<p>Already friends!</p>';
                } 
                // Si la relation est "pending"
                else {
                    echo '<p>Friend request pending</p>';
                }
            } else {
                // Si aucun lien n'existe, afficher un bouton pour envoyer la demande
                echo '<form method="POST" action="sendFriendRequest.php" style="display:inline;">
                        <input type="hidden" name="friend_id" value="' . $user['id'] . '">
                        <button type="submit" class="btn-send-request">Send Friend Request</button>
                    </form>';
            }
            echo '</div>';
        }
        ?>
    </div>
</section>
<section class="section-content" id="friend-requests">
    <h2>Friend Requests</h2>
    <div class="friend-requests-list">
        <?php
        // Récupérer les demandes d'amis en attente (status = 'pending' et où l'ami est l'utilisateur connecté)
        $stmt = $pdo->prepare("SELECT * FROM friends WHERE (friend_id = ? AND status = 'pending')");
        $stmt->execute([$_SESSION['user_id']]);
        $pendingRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($pendingRequests)) {
            echo '<p class="no-requests">You have no pending friend requests.</p>';
        } else {
            // Afficher chaque demande d'ami en attente
            foreach ($pendingRequests as $request) {
                $userId = $request['user_id'];
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$userId]);
                $friend = $stmt->fetch(PDO::FETCH_ASSOC);

                echo '<div class="friend-request-card">';
                echo '<div class="friend-info">';
                echo '<h3 class="friend-name">' . htmlspecialchars($friend['username']) . '</h3>';
                echo '<p class="friend-email">' . htmlspecialchars($friend['email']) . '</p>';
                echo '</div>';
                
                // Formulaire pour accepter la demande
                echo '<div class="friend-request-actions">
                        <form method="POST" action="acceptFriendRequest.php" class="action-form">
                            <input type="hidden" name="friend_id" value="' . $friend['id'] . '">
                            <button type="submit" class="btn-accept">Accept</button>
                        </form>';

                // Formulaire pour supprimer la demande
                echo '<form method="POST" action="deleteFriendRequest.php" class="action-form">
                        <input type="hidden" name="friend_id" value="' . $friend['id'] . '">
                        <button type="submit" class="btn-delete" onclick="return confirm(\'Are you sure you want to delete this friend request?\')">Delete</button>
                    </form>';
                echo '</div>';
                
                echo '</div>';
            }
        }
        ?>
    </div>
</section>


<script src="../js/profil.js"></script> <!-- Mettez à jour le chemin selon votre structure de fichiers -->

</body>
</html>