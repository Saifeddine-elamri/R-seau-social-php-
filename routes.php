<?php

return [
    // Routes principales
    '/' => ['controller' => 'UserController', 'method' => 'showAllUsers'], // Page d'accueil
    '/profil' => ['controller' => 'UserController', 'method' => 'profile'], // Profil utilisateur
    '/posts' => ['controller' => 'PostController', 'method' => 'index'], // Liste des posts
    '/add-post' => ['controller' => 'PostController', 'method' => 'addPost'], // Ajouter un nouveau post
    '/friends' => ['controller' => 'FriendController', 'method' => 'index'], // Liste des amis
    '/contact' => ['controller' => 'MessageController', 'method' => 'index'], // Messages (contact)
    

    // Routes relatives aux utilisateurs
    '/users' => ['controller' => 'UserController', 'method' => 'showAllUsers'], // Liste des utilisateurs
    '/add-friend' => ['controller' => 'UserController', 'method' => 'addFriend'], // Ajouter un ami
    '/cancel-request' => ['controller' => 'UserController', 'method' => 'cancelFriendRequest'], // Annuler une demande d'ami

    // Routes relatives aux demandes d'amis
    '/requests' => ['controller' => 'FriendController', 'method' => 'showRequests'], // Afficher les demandes d'amis
    '/delete-friend' => ['controller' => 'FriendController', 'method' => 'removeFriend'], // Supprimer un ami
    '/accept-request' => ['controller' => 'FriendController', 'method' => 'acceptRequest'], // Accepter une demande d'ami
    '/delete-request' => ['controller' => 'FriendController', 'method' => 'rejectRequest'], // Rejeter une demande d'ami

    // Routes de connexion et d'inscription
    '/logout' => ['controller' => 'AuthController', 'method' => 'logout'], // Se déconnecter
    '/login' => ['controller' => 'AuthController', 'method' => 'showLoginForm'], // Afficher le formulaire de connexion
    '/login_check' => ['controller' => 'AuthController', 'method' => 'login'], // Vérifier les identifiants et connecter l'utilisateur
    '/register' => ['controller' => 'AuthController', 'method' => 'register'], // Inscription d'un utilisateur

    // Routes relatives aux messages
    '/send' => ['controller' => 'MessageController', 'method' => 'sendMessage'], // Envoyer un message
    '/messages' => ['controller' => 'MessageController', 'method' => 'index'], // Afficher les messages

    // Routes de posts et interactions
    '/like' => ['controller' => 'LikeController', 'method' => 'likePost'], // Aimer un post
    '/like-comment' => ['controller' => 'LikeController', 'method' => 'likeComment'], // Aimer un commentaire
    '/comment' => ['controller' => 'CommentController', 'method' => 'addComment'], // Ajouter un commentaire
    '/reply-comment' => ['controller' => 'CommentController', 'method' => 'addReply'], // Ajouter un commentaire



    // Routes relatives au profil
    '/profil-info' => ['controller' => 'ProfilController', 'method' => 'showProfileInfo'], // Afficher les informations du profil
    '/delete-image' => ['controller' => 'ProfilController', 'method' => 'deleteProfileImage'], // Supprimer l'image de profil
    '/update-image' => ['controller' => 'ProfilController', 'method' => 'updateProfileImage'], // Mettre à jour l'image de profil
    '/update-profile' => ['controller' => 'ProfilController', 'method' => 'updateProfileInfo'], // Mettre à jour l'image de profil

];
