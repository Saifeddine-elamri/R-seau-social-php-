<?php
// Définition de la classe Post qui gère les opérations liées aux posts
class Post {

    // Récupérer tous les posts
    // Cette méthode récupère tous les posts depuis la base de données, triés par date de création, du plus récent au plus ancien.
    public static function getAll() {
        global $pdo;  // Accède à la variable globale $pdo pour interagir avec la base de données
        
        // Exécuter une requête pour récupérer tous les posts
        $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
        
        // Retourner tous les posts sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($user_id, $content, $image = null, $video = null) {
        // Traiter l'upload de l'image
        $uploadedImageData = self::handleFileUpload('post_image');
        $uploadedVideoData = self::handleFileUpload('post_video');
    
        // Vérifier si l'upload de l'image a réussi
        $imageData = isset($uploadedImageData['uniqueName']) ? $uploadedImageData['uniqueName'] : $image;
    
        // Vérifier si l'upload de la vidéo a réussi
        $videoData = isset($uploadedVideoData['uniqueName']) ? $uploadedVideoData['uniqueName'] : $video;
    
        // Créer le post avec les fichiers uploadés (ou existants)
        return self::createPost($user_id, $content, $imageData, $videoData);
    }
    

    private static function handleFileUpload($inputName) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0) {
            $uploadedFile = $_FILES[$inputName];  
            $fileTmpName = $uploadedFile['tmp_name'];
            $fileType = mime_content_type($fileTmpName);
            $fileExtension = strtolower(pathinfo($uploadedFile['name'], PATHINFO_EXTENSION));
    
            // Définir les types MIME autorisés
            $validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $validVideoTypes = ['video/mp4', 'video/webm', 'video/ogg'];
    
            // Déterminer si c'est une image ou une vidéo
            if (in_array($fileType, $validImageTypes)) {
                $uploadDir = 'uploads/images/';
            } elseif (in_array($fileType, $validVideoTypes)) {
                $uploadDir = 'uploads/videos/';
            } else {
                throw new Exception("Type de fichier non valide.");
            }
    
            // Créer le dossier s'il n'existe pas
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            // Générer un nom unique pour éviter les conflits
            $uniqueFileName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $fileExtension;
            $filePath = $uploadDir . $uniqueFileName;
    
            // Déplacer le fichier téléchargé vers le répertoire approprié
            if (move_uploaded_file($fileTmpName, $filePath)) {
                return [
                    'originalName' => $uploadedFile['name'],  // Nom d'origine
                    'uniqueName' => $uniqueFileName,  // Nom unique généré
                    'filePath' => $filePath  // Chemin complet
                ];
            } else {
                throw new Exception("Erreur lors du téléchargement du fichier.");
            }
        }
        return [];
    }
    

    // Créer un nouveau post dans la base de données
    // Cette méthode insère un nouveau post dans la table `posts` de la base de données.
    private static function createPost($userId, $content, $image = null, $video = null) {
        global $pdo;  // Accède à la variable globale $pdo pour interagir avec la base de données
        
        // Préparer la requête SQL pour insérer un nouveau post
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image, video, created_at) VALUES (?, ?, ?, ?, NOW())");
        
        // Exécuter la requête avec les paramètres fournis (user_id, contenu, image, vidéo et date actuelle)
        return $stmt->execute([$userId, $content, $image, $video]);
    }

    // Récupérer tous les posts d'un utilisateur
    // Cette méthode récupère tous les posts d'un utilisateur en particulier, triés par date de création, du plus récent au plus ancien.
    public static function getPostsByUserId($userId) {
        global $pdo;  // Accède à la variable globale $pdo pour interagir avec la base de données
        
        // Préparer et exécuter la requête SQL pour récupérer les posts de l'utilisateur spécifié
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        
        // Retourner tous les posts de l'utilisateur sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
