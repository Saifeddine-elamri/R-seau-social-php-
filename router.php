<?php

// Récupérer l'URL demandée
$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?'); // Supprime les paramètres GET

// Définir les routes
$routes = [
    '/' => 'pages/profil.php',
    '/profil' => 'pages/profil.php',
    '/posts' => 'pages/posts.php',
    '/friends' => 'pages/friends.php',
    '/contact' => 'pages/messages.php',
    '/users' => 'pages/all-users.php',
    '/requests' => 'pages/friend-requests.php',
    '/logout' => 'logout.php',
    '/login' => 'login.php',
    '/register' => 'register.php',


];

// Vérifier si la route existe
if (array_key_exists($request, $routes)) {
    require $routes[$request];
} else {
    http_response_code(404);
    echo "Page not found";
}
?>
