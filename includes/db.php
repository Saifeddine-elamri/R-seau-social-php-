<?php

// Paramètres de connexion à la base de données
$host = 'localhost';
$dbname = 'facebook_clone';
$username = 'root';
$password = 'saif';

try {
    // Création de la connexion PDO avec gestion des erreurs et encodage UTF-8
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password ,[
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
    ]);

    // Définition du mode d'erreur de PDO à exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optionnel : Activation du mode de gestion des requêtes à l'intérieur d'une transaction pour un débogage amélioré
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 

} catch (PDOException $e) {
    // En cas d'erreur de connexion, afficher un message personnalisé et arrêter l'exécution du script
    die("Could not connect to the database. Error: " . $e->getMessage());
}

?>
