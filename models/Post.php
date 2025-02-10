<?php
class Post {

    // Récupérer tous les posts
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Assurez-vous de toujours définir le mode de récupération
    }

    // Ajouter un nouveau post
    public static function add($user_id, $content, $image = null, $video = null) {
        // Traiter le téléchargement du fichier
        $uploadedFileData = self::handleFileUpload('post_image');
        
        // Si un fichier image est téléchargé, il sera utilisé, sinon utiliser l'argument image passé
        $fileName = $uploadedFileData['fileName'] ?? $image;
        
        // Créer le post avec ou sans fichier
        return self::createPost($user_id, $content, $fileName, $video);
    }

    // Gérer l'upload d'un fichier
    private static function handleFileUpload($inputName) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0) {
            $uploadedFile = $_FILES[$inputName];
            $uploadDir = 'uploads/';
            $fileName = basename($uploadedFile['name']);
            $filePath = $uploadDir . $fileName;

            $validMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

            // Vérification du type de fichier
            if (in_array($uploadedFile['type'], $validMimeTypes)) {
                // Déplacer le fichier téléchargé vers le répertoire de destination
                if (move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
                    return ['fileName' => $fileName]; // Retourner le nom du fichier
                } else {
                    throw new Exception("Erreur lors du téléchargement de l'image.");
                }
            } else {
                throw new Exception("Type de fichier non valide.");
            }
        }
        return [];
    }

    // Créer un nouveau post dans la base de données
    private static function createPost($userId, $content, $image = null, $video = null) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image, video, created_at) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$userId, $content, $image, $video]);
    }

    // Récupérer tous les posts d'un utilisateur
    public static function getPostsByUserId($userId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
