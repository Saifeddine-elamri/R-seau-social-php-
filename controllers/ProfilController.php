<?php
require_once __DIR__ . '/../models/User.php';


class ProfilController
{

    // Fonction pour afficher les informations du profil
    public function showProfileInfo()
    {
        $user_id = $_SESSION['user_id'];

        $user = User::getById($user_id);
        require_once __DIR__ . '/../views/profilInfo.php';
    }

    // Fonction pour supprimer l'image de profil
    public function deleteProfileImage()
    {
        $user_id = $_SESSION['user_id'];

        if (User::deleteProfileImage($user_id)) {
            $_SESSION['message'] = "Profile picture deleted successfully.";
        } else {
            $_SESSION['message'] = "No profile picture found to delete.";
        }
        header("Location: profil-info");
        exit();
    }

    public function updateProfileImage()
    {
        $user_id = $_SESSION['user_id'];

        // Vérifier si un fichier a été téléchargé et est valide
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            // Obtenir le nom du fichier et son chemin
            $fileName = basename($_FILES['profile_pic']['name']);
            $filePath = "../uploads/" . $fileName;

            // Déplacer le fichier téléchargé vers le répertoire de destination
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filePath)) {
                // Mettre à jour l'image de profil dans la base de données
                if (User::updateProfileImage($user_id, $fileName)) {
                    $_SESSION['message'] = "Profile picture updated successfully.";
                } else {
                    $_SESSION['message'] = "Failed to update profile picture in the database.";
                }
            } else {
                $_SESSION['message'] = "Failed to upload the profile picture.";
            }
        } else {
            $_SESSION['message'] = "No file selected or there was an error with the file.";
        }

        // Rediriger vers la page du profil
        header("Location: profil-info");
        exit();
    }
}
