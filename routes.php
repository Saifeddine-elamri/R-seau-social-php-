<?php

return [
    '/' => ['controller' => 'UserController', 'method' => 'showAllUsers'],
    '/profil' => ['controller' => 'UserController', 'method' => 'profile'],
    '/posts' => ['controller' => 'PostController', 'method' => 'index'],
    '/add-post' => ['controller' => 'PostController', 'method' => 'addPost'],
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
    '/accept-request' => ['controller' => 'FriendController', 'method' => 'acceptRequest'],
    '/delete-request' => ['controller' => 'FriendController', 'method' => 'rejectRequest'],
    '/send' => ['controller' => 'MessageController', 'method' => 'sendMessage'],
    '/messages' => ['controller' => 'MessageController', 'method' => 'index'],
    '/like' => ['controller' => 'LikeController', 'method' => 'likePost'],
    '/comment' => ['controller' => 'CommentController', 'method' => 'addComment'],
    '/profil-info' => ['controller' => 'ProfilController', 'method' => 'showProfileInfo'],
    '/delete-image' => ['controller' => 'ProfilController', 'method' => 'deleteProfileImage'],
    '/update-image' => ['controller' => 'ProfilController', 'method' => 'updateProfileImage'],
    '/test' => ['controller' => 'testController', 'method' => 'testProfileImage']

];
