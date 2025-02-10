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

    // Ajouter un nouveau post
    // Cette méthode permet d'ajouter un nouveau post avec du texte, une image (optionnelle) et une vidéo (optionnelle).
    public static function add($user_id, $content, $image = null, $video = null) {
        // Traiter l'upload de fichier (image ou vidéo)
        $uploadedFileData = self::handleFileUpload('post_image');
        
        // Si un fichier image a été téléchargé, on utilise son nom, sinon on utilise l'image fournie en argument
        $fileName = $uploadedFileData['fileName'] ?? $image;
        
        // Créer le post avec ou sans fichier (image ou vidéo)
        return self::createPost($user_id, $content, $fileName, $video);
    }

    // Gérer l'upload d'un fichier (image ou vidéo)
    // Cette méthode est utilisée pour gérer l'upload d'une image via un formulaire.
    private static function handleFileUpload($inputName) {
        // Vérifier si un fichier a été téléchargé et s'il n'y a pas d'erreurs
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0) {
            $uploadedFile = $_FILES[$inputName];  // Récupérer les informations sur le fichier téléchargé
            $uploadDir = 'uploads/';  // Répertoire où les fichiers seront stockés
            $fileName = basename($uploadedFile['name']);  // Extraire le nom du fichier
            $filePath = $uploadDir . $fileName;  // Créer le chemin complet du fichier

            // Types MIME valides pour les images (jpg, png, gif)
            $validMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

            // Vérification que le type MIME du fichier téléchargé est valide
            if (in_array($uploadedFile['type'], $validMimeTypes)) {
                // Déplacer le fichier téléchargé vers le répertoire de destination
                if (move_uploaded_file($uploadedFile['tmp_name'], $filePath)) {
                    return ['fileName' => $fileName];  // Retourner le nom du fichier si l'upload est réussi
                } else {
                    // Si le déplacement du fichier échoue, une exception est lancée
                    throw new Exception("Erreur lors du téléchargement de l'image.");
                }
            } else {
                // Si le type MIME n'est pas valide, une exception est lancée
                throw new Exception("Type de fichier non valide.");
            }
        }
        
        // Si aucun fichier n'est téléchargé, retourner un tableau vide
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
