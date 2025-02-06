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
    $user_id = $_SESSION['user_id']; // Récupération de l'ID de l'utilisateur connecté

    if (!empty($comment_content)) {
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$post_id, $user_id, $comment_content]);
    }
}

// Gestion de la publication d'un message avec image
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['content'])) {
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];
    $image_path = null;
    $video_path = null;

    // Dossier d'upload
    $upload_dir = '../uploads/';

    // Gestion de l'upload d'image
    if (!empty($_FILES['post_image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['post_image']['name']);
        $target_path = $upload_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_path, PATHINFO_EXTENSION));

        // Vérifier le type d'image
        $allowed_image_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_image_types)) {
            if (move_uploaded_file($_FILES['post_image']['tmp_name'], $target_path)) {
                $image_path = $image_name;
            }
        }
    }

    // Gestion de l'upload de vidéo
    if (!empty($_FILES['post_video']['name'])) {
        $video_name = time() . '_' . basename($_FILES['post_video']['name']);
        $target_video_path = $upload_dir . $video_name;
        $videoFileType = strtolower(pathinfo($target_video_path, PATHINFO_EXTENSION));

        // Vérifier le type de vidéo
        $allowed_video_types = ['mp4', 'avi', 'mov'];
        if (in_array($videoFileType, $allowed_video_types)) {
            if (move_uploaded_file($_FILES['post_video']['tmp_name'], $target_video_path)) {
                $video_path = $video_name;
            }
        }
    }

    // Insérer le post avec texte, image et vidéo dans la base de données
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image, video) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $content, $image_path, $video_path]);
}



// Gestion du like d'un post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like_post'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    // Vérifier si l'utilisateur a déjà liké ce post
    $stmt = $pdo->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->execute([$post_id, $user_id]);
    $like = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($like) {
        // Si l'utilisateur a déjà liké, supprimer le like (toggle like)
        $stmt = $pdo->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$post_id, $user_id]);
    } else {
        // Sinon, ajouter un like
        $stmt = $pdo->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
        $stmt->execute([$post_id, $user_id]);
    }

    // Rafraîchir la page pour mettre à jour l'affichage des likes
    header("Location: home.php");
    exit();
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
    <form method="POST" enctype="multipart/form-data">
        <textarea name="content" placeholder="What's on your mind?" required></textarea>

        <?php 
        $fileTypes = [
            "image" => ["📷 Choisir une image", "image/*"],
            "video" => ["🎥 Choisir une vidéo", "video/*"]
        ];
        foreach ($fileTypes as $type => $details): 
        ?>
            <div class="file-upload">
                <label for="file-<?php echo $type; ?>" class="file-upload-label">
                    <?php echo $details[0]; ?>
                </label>
                <input type="file" id="file-<?php echo $type; ?>" name="post_<?php echo $type; ?>" accept="<?php echo $details[1]; ?>">
            </div>
        <?php endforeach; ?>

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
 
            <?php if (!empty($post['image'])): ?>
                <img src="../uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" class="post-image">
            <?php endif; ?>

            <?php if (!empty($post['video'])): ?>
                <video controls class="post-video">
                    <source src="../uploads/<?php echo htmlspecialchars($post['video']); ?>" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture de vidéos.
                </video>
            <?php endif; ?>


            <!-- Section des likes avec styles améliorés -->
            <div class="like-section">
                <!-- Bouton Like -->
                <form method="POST" class="like-form">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <button type="submit" name="like_post" class="like-btn">
                        ❤️ Like
                    </button>
                </form>

                <!-- Affichage des likes -->
                <?php
                $stmt = $pdo->prepare("SELECT COUNT(*) as like_count FROM likes WHERE post_id = ?");
                $stmt->execute([$post['id']]);
                $like_count = $stmt->fetch(PDO::FETCH_ASSOC)['like_count'];
                ?>
                <span class="like-count"><?php echo $like_count; ?> Likes</span>

                <!-- Bouton pour voir qui a liké -->
                <?php if ($like_count > 0): ?>
                    <button onclick="toggleLikers(<?php echo $post['id']; ?>)" class="view-likers-btn">
                        👀 Voir qui a liké
                    </button>

                    <!-- Liste cachée des utilisateurs (Popup) -->
                    <div id="likers-<?php echo $post['id']; ?>" class="likers-popup">
                        <div class="likers-popup-content">
                            <span class="close-btn" onclick="toggleLikers(<?php echo $post['id']; ?>)">✖</span>
                            <strong>Liked by:</strong>
                            <ul>
                                <?php
                                $stmt = $pdo->prepare("SELECT users.username FROM likes JOIN users ON likes.user_id = users.id WHERE likes.post_id = ?");
                                $stmt->execute([$post['id']]);
                                $likers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($likers as $liker):
                                    echo "<li>❤️ " . htmlspecialchars($liker['username']) . "</li>";
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>




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


    <script>
function toggleLikers(postId) {
    var popup = document.getElementById('likers-' + postId);
    if (popup.style.display === 'none' || popup.style.display === '') {
        popup.style.display = 'block';
    } else {
        popup.style.display = 'none';
    }
}

document.getElementById('file-input').addEventListener('change', function() {
    var fileName = this.files[0] ? this.files[0].name : "Aucun fichier choisi";
    document.getElementById('file-name').textContent = fileName;
});
</script>

</body>
</html>