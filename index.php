<?php
session_start();
require 'includes/db.php';
require 'includes/functions.php';

// Charger les routes
$routes = require __DIR__ . '/routes.php';

// Récupérer l'URL demandée sans paramètres GET
$requestUri = strtok($_SERVER['REQUEST_URI'], '?');

// Vérifier si la route existe dans le fichier de routes
if (!isset($routes[$requestUri])) {
    sendError(404, "Page non trouvée");
}

// Extraire le contrôleur et la méthode de la route
$route = $routes[$requestUri];
$controllerName = $route['controller'];
$method = $route['method'];

// Déterminer le chemin du fichier du contrôleur
$controllerFile = __DIR__ . "/controllers/$controllerName.php";

// Vérifier si le fichier du contrôleur existe
if (!file_exists($controllerFile)) {
    sendError(500, "Le contrôleur <strong>$controllerName.php</strong> est introuvable.");
}

// Charger le fichier du contrôleur
require_once $controllerFile;

// Vérifier si la classe existe dans le contrôleur
if (!class_exists($controllerName)) {
    sendError(500, "La classe <strong>$controllerName</strong> est introuvable.");
}

// Instancier le contrôleur
$controller = new $controllerName();

// Vérifier si la méthode existe dans la classe du contrôleur
if (!method_exists($controller, $method)) {
    sendError(500, "La méthode <strong>$method</strong> n'existe pas dans la classe <strong>$controllerName</strong>.");
}

// Exécuter la méthode du contrôleur
$controller->$method();
exit();

/**
 * Fonction pour envoyer une erreur avec un code et un message.
 *
 * @param int $statusCode Code de statut HTTP.
 * @param string $message Message d'erreur à afficher.
 */
function sendError($statusCode, $message) {
    http_response_code($statusCode);
    echo "<h1>Erreur $statusCode</h1><p>$message</p>";
    exit();
}
?>
