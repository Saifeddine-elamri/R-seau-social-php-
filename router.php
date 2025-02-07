<?php
require_once __DIR__ . '/controllers/PostController.php';


// Récupérer l'URL demandée sans paramètres GET
$request = strtok($_SERVER['REQUEST_URI'], '?');

// Définir les routes et les contrôleurs associés
$routes = [
    '/' => ['controller' => 'UserController', 'method' => 'profile'],
    '/profil' => ['controller' => 'UserController', 'method' => 'profile'],
    '/posts' => ['controller' => 'PostController', 'method' => 'index'],
    '/friends' => ['controller' => 'FriendController', 'method' => 'index'],
    '/contact' => ['controller' => 'MessageController', 'method' => 'index'],
    '/users' => ['controller' => 'UserController', 'method' => 'listUsers'],
    '/requests' => ['controller' => 'FriendController', 'method' => 'friendRequests'],
    '/logout' => ['controller' => 'UserController', 'method' => 'logout'],
    '/login' => ['controller' => 'UserController', 'method' => 'login'],
    '/register' => ['controller' => 'UserController', 'method' => 'register'],
    '/delete-friend' => ['controller' => 'FriendController', 'method' => 'removeFriend'],
    '/add-friend' => ['controller' => 'FriendController', 'method' => 'sendFriendRequest'],
    '/cancel-request' => ['controller' => 'FriendController', 'method' => 'cancelFriendRequest'],
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
    
    if (file_exists($controllerPath)) {
        require_once $controllerPath;
        $controller = new $controllerName();
        
        if (method_exists($controller, $method)) {
            $controller->$method();
            exit();
        }
    }
}

// Si la route est inconnue, afficher une erreur 404
http_response_code(404);
echo "404 - Page Not Found";
?>
