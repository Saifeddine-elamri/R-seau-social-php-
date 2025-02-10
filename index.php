<?php
session_start();
require 'includes/db.php';
require 'includes/functions.php';
$routes = require __DIR__ . '/routes.php';



// Récupérer l'URL demandée sans paramètres GET
$requestUri = strtok($_SERVER['REQUEST_URI'], '?');

// Vérifier si la route existe
if (!isset($routes[$requestUri])) {
    http_response_code(404);
    echo "404 - Page non trouvée.";
    exit();
}

$route = $routes[$requestUri];
$controllerName = $route['controller'];
$method = $route['method'];

// Chemin du fichier du contrôleur
$controllerFile = __DIR__ . "/controllers/$controllerName.php";

// Vérifier si le fichier du contrôleur existe
if (!file_exists($controllerFile)) {
    http_response_code(500);
    echo "Erreur 500 - Le contrôleur <strong>$controllerName.php</strong> est introuvable.";
    exit();
}

// Charger le contrôleur
require_once $controllerFile;

// Vérifier si la classe existe
if (!class_exists($controllerName)) {
    http_response_code(500);
    echo "Erreur 500 - La classe <strong>$controllerName</strong> est introuvable.";
    exit();
}

// Instancier le contrôleur
$controller = new $controllerName();

// Vérifier si la méthode existe
if (!method_exists($controller, $method)) {
    http_response_code(500);
    echo "Erreur 500 - La méthode <strong>$method</strong> n'existe pas dans <strong>$controllerName</strong>.";
    exit();
}

// Exécuter la méthode demandée
$controller->$method();
exit();

?>
