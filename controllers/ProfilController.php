<?php
require_once __DIR__ . '/../models/User.php';

class ProfilController
{

    /**
     * Affiche les informations du profil de l'utilisateur
     */
    public function showProfileInfo()
    {
        // Vérifier si l'utilisateur est connecté
        $user_id = $_SESSION['user_id'];

        // Récupérer les informations de l'utilisateur à partir du modèle
        $user = User::getById($user_id);

        // Afficher la vue avec les informations du profil
        require_once __DIR__ . '/../views/profilInfo.php';
    }

    /**
     * Supprime l'image de profil de l'utilisateur
     */
    public function deleteProfileImage()
    {
        // Vérifier si l'utilisateur est connecté
        $user_id = $_SESSION['user_id'];

        // Tenter de supprimer l'image de profil via le modèle
        if (User::deleteProfileImage($user_id)) {
            // Message de succès
            $_SESSION['message'] = "Profile picture deleted successfully.";
        } else {
            // Message d'erreur si aucune image n'est trouvée
            $_SESSION['message'] = "No profile picture found to delete.";
        }

        // Rediriger vers la page des informations de profil
        header("Location: profil-info");
        exit();
    }

    /**
     * Met à jour l'image de profil de l'utilisateur
     */
    public function updateProfileImage()
    {
        // Vérifier si l'utilisateur est connecté
        $user_id = $_SESSION['user_id'];

        // Vérifier si un fichier d'image a été téléchargé sans erreur
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            // Récupérer le nom du fichier téléchargé et le chemin d'enregistrement
            $fileName = basename($_FILES['profile_pic']['name']);
            $filePath = "../uploads/" . $fileName;

            // Vérifier la validité du fichier (taille, extension, etc.)
            if ($this->isValidProfileImage($fileName)) {
                // Déplacer le fichier téléchargé vers le répertoire de destination
                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filePath)) {
                    // Mettre à jour l'image dans la base de données via le modèle
                    if (User::updateProfileImage($user_id, $fileName)) {
                        $_SESSION['message'] = "Profile picture updated successfully.";
                    } else {
                        $_SESSION['message'] = "Failed to update profile picture in the database.";
                    }
                } else {
                    $_SESSION['message'] = "Failed to upload the profile picture.";
                }
            } else {
                $_SESSION['message'] = "Invalid file type or size.";
            }
        } else {
            // Message d'erreur si aucun fichier n'a été téléchargé ou si une erreur est survenue
            $_SESSION['message'] = "No file selected or there was an error with the file.";
        }

        // Rediriger vers la page du profil
        header("Location: profil-info");
        exit();
    }

    /**
     * Valide le fichier d'image pour s'assurer qu'il est de type et taille corrects
     * @param string $fileName Le nom du fichier téléchargé
     * @return bool Retourne true si le fichier est valide, sinon false
     */
    private function isValidProfileImage($fileName)
    {
        // Extensions autorisées (à adapter en fonction de vos besoins)
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Extraire l'extension du fichier
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Vérifier si l'extension est valide
        if (!in_array($fileExtension, $validExtensions)) {
            return false;
        }

        // Vérifier la taille du fichier (par exemple, ne pas dépasser 5 Mo)
        if ($_FILES['profile_pic']['size'] > 5 * 1024 * 1024) { // 5 Mo
            return false;
        }

        return true;
    }
}
?>
