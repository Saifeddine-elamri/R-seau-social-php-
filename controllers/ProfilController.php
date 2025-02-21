<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/View.php'; 
require_once __DIR__ . '/../core/Session.php'; // Inclusion de la classe Session

class ProfilController
{
    public function __construct()
    {
        // Démarrer la session automatiquement au début de chaque action
        Session::start();
    }

    /**
     * Affiche les informations du profil de l'utilisateur
     */
    public function showProfileInfo()
    {
        // Vérifier si l'utilisateur est connecté
        $user_id = Session::get('user_id');

        // Récupérer les informations de l'utilisateur à partir du modèle
        $user = User::getById($user_id);

        // Afficher la vue avec les informations du profil
        View::render('profilInfo', ['user' => $user]);
    }

    /**
     * Supprime l'image de profil de l'utilisateur
     */
    public function deleteProfileImage()
    {
        // Vérifier si l'utilisateur est connecté
        $user_id = Session::get('user_id');

        // Tenter de supprimer l'image de profil via le modèle
        if (User::deleteProfileImage($user_id)) {
            // Message de succès
            Session::set('message', "Profile picture deleted successfully.");
        } else {
            // Message d'erreur si aucune image n'est trouvée
            Session::set('message', "No profile picture found to delete.");
        }

        // Rediriger vers la page des informations de profil
        header("Location: profil-info");
        exit();
    }

    /**
     * Met à jour les informations personnelles de l'utilisateur
     */
    public function updateProfileInfo()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérifier si l'utilisateur est connecté
            $user_id = Session::get('user_id');

            // Récupérer et sécuriser les données du formulaire
            $first_name = trim(htmlspecialchars($_POST['first_name'] ?? ''));
            $last_name = trim(htmlspecialchars($_POST['last_name'] ?? ''));
            $birth_date = trim($_POST['birth_date'] ?? '');
            $phone = trim(htmlspecialchars($_POST['phone'] ?? ''));

            // Vérification des champs obligatoires
            if (empty($first_name) || empty($last_name)) {
                Session::set('message', "Le prénom et le nom ne peuvent pas être vides.");
                header("Location: profil-info");
                exit();
            }

            // Mettre à jour les informations dans la base de données via le modèle
            if (User::updateProfileInfo($user_id, $first_name, $last_name, $birth_date, $phone)) {
                Session::set('message', "Informations mises à jour avec succès.");
            } else {
                Session::set('message', "Erreur lors de la mise à jour.");
            }

            // Rediriger vers la page du profil
            header("Location: profil-info");
            exit();
        }
    }

    /**
     * Met à jour l'image de profil de l'utilisateur
     */
    public function updateProfileImage()
    {
        // Vérifier si l'utilisateur est connecté
        $user_id = Session::get('user_id');

        // Vérifier si un fichier d'image a été téléchargé sans erreur
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            // Récupérer le nom du fichier téléchargé et le chemin d'enregistrement
            $fileName = basename($_FILES['profile_pic']['name']);
            $filePath = "uploads/profil/" . $fileName;

            // Vérifier la validité du fichier (taille, extension, etc.)
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filePath)) {
                // Mettre à jour l'image dans la base de données via le modèle
                if (User::updateProfileImage($user_id, $fileName)) {
                    Session::set('message', "Profile picture updated successfully.");
                } else {
                    Session::set('message', "Failed to update profile picture in the database.");
                }
            } else {
                Session::set('message', "Failed to upload the profile picture.");
            }
        } else {
            // Message d'erreur si aucun fichier n'a été téléchargé ou si une erreur est survenue
            Session::set('message', "No file selected or there was an error with the file.");
        }

        // Rediriger vers la page du profil
        header("Location: profil-info");
        exit();
    }
}
