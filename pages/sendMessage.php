<?php


if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$receiver_id = $_POST['receiver_id'];
$message = !empty($_POST['message']) ? trim($_POST['message']) : null;
$image_name = null;

// Gérer l'upload de l'image
if (!empty($_FILES['image']['name'])) {
    $target_dir = "uploads/";
    $image_name = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageFileType, $allowed_types)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Image uploadée avec succès
        } else {
            $image_name = null;
        }
    } else {
        $image_name = null;
    }
}

// Insérer dans la base de données
$stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message, image, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->execute([$user_id, $receiver_id, $message, $image_name]);

header("Location: messages?contact_id=" . $receiver_id);
exit();
?>
