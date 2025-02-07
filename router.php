<?php
require_once __DIR__ . '/controllers/PostController.php';
require_once __DIR__ . '/controllers/LoginController.php';
require_once __DIR__ . '/controllers/UserController.php';

// Récupérer l'URL demandée sans paramètres GET
$request = strtok($_SERVER['REQUEST_URI'], '?');

// Définir les routes et les contrôleurs associés
$routes = [
    '/' => ['controller' => 'UserController', 'method' => 'profile'],
    '/profil' => ['controller' => 'UserController', 'method' => 'profile'],
    '/posts' => ['controller' => 'PostController', 'method' => 'index'],
    '/friends' => ['controller' => 'FriendController', 'method' => 'index'],
    '/contact' => ['controller' => 'MessageController', 'method' => 'index'],
    '/users' => ['controller' => 'UserController', 'method' => 'showAllUsers'],
    '/add-friend' => ['controller' => 'UserController', 'method' => 'addFriend'],
    '/requests' => ['controller' => 'FriendController', 'method' => 'showRequests'],
    '/logout' => ['controller' => 'AuthController', 'method' => 'logout'],
    '/login' => ['controller' => 'LoginController', 'method' => 'showLoginForm'],
    '/login_check' => ['controller' => 'LoginController', 'method' => 'login'],
    '/register' => ['controller' => 'AuthController', 'method' => 'register'],
    '/delete-friend' => ['controller' => 'FriendController', 'method' => 'removeFriend'],
    '/cancel-request' => ['controller' => 'UserController', 'method' => 'cancelFriendRequest'],
    '/accept-request' => ['controller' => 'FriendController', 'method' => 'acceptFriendRequest'],
    '/delete-request' => ['controller' => 'FriendController', 'method' => 'deleteFriendRequest'],
    '/send' => ['controller' => 'MessageController', 'method' => 'sendMessage'],
    '/messages' => ['controller' => 'MessageController', 'method' => 'index'],
    '/like' => ['controller' => 'LikeController', 'method' => 'likePost'],
    '/comment' => ['controller' => 'CommentController', 'method' => 'addComment'],
];

// Vérifier si la route existe
if (array_key_exists($request, $routes)) {
    $controllerName = $routes[$request]['controller'];
    $method = $routes[$request]['method'];

    $controllerPath = __DIR__ . "/controllers/$controllerName.php";

    if (!file_exists($controllerPath)) {
        http_response_code(500);
        echo "Erreur 500 - Le fichier du contrôleur <strong>$controllerName.php</strong> est introuvable.";
        exit();
    }

    require_once $controllerPath;

    if (!class_exists($controllerName)) {
        http_response_code(500);
        echo "Erreur 500 - La classe <strong>$controllerName</strong> est introuvable dans le fichier.";
        exit();
    }

    $controller = new $controllerName();

    if (!method_exists($controller, $method)) {
        http_response_code(500);
        echo "Erreur 500 - La méthode <strong>$method</strong> n'existe pas dans le contrôleur <strong>$controllerName</strong>.";
        exit();
    }

    $controller->$method();
    exit();
}

// Si la route est inconnue, afficher une erreur 404
http_response_code(404);
echo "404 - Page non trouvée. Vérifiez l'URL.";
?>
