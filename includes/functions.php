<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function sendFriendRequest($userId, $friendId) {
    global $pdo;

    // Vérifier que la demande n'existe pas déjà
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
    $stmt->execute([$userId, $friendId, $friendId, $userId]);
    $existingRequest = $stmt->fetch();

    if ($existingRequest) {
        return "A request already exists.";
    }

    // Envoyer la demande d'amitié (status = 'pending')
    $stmt = $pdo->prepare("INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'pending')");
    $stmt->execute([$userId, $friendId]);

    return "Friend request sent!";
}
function acceptFriendRequest($userId, $friendId) {
    global $pdo;

    // Vérifier si la demande existe et est en statut "pending"
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
    $stmt->execute([$userId, $friendId, $friendId, $userId]);
    $request = $stmt->fetch();

    if (!$request || $request['status'] !== 'pending') {
        return "No pending friend request found.";
    }

    // Accepter la demande (changer le statut en 'accepted')
    $stmt = $pdo->prepare("UPDATE friends SET status = 'accepted' WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
    $stmt->execute([$userId, $friendId, $friendId, $userId]);

    return "Friend request accepted!";
}
function rejectFriendRequest($userId, $friendId) {
    global $pdo;

    // Vérifier si la demande existe et est en statut "pending"
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
    $stmt->execute([$userId, $friendId, $friendId, $userId]);
    $request = $stmt->fetch();

    if (!$request || $request['status'] !== 'pending') {
        return "No pending friend request found.";
    }

    // Rejeter la demande (supprimer l'enregistrement)
    $stmt = $pdo->prepare("DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)");
    $stmt->execute([$userId, $friendId, $friendId, $userId]);

    return "Friend request rejected.";
}
function getFriends($userId) {
    global $pdo;

    // Obtenir les amis de l'utilisateur (status = 'accepted')
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE (user_id = ? OR friend_id = ?) AND status = 'accepted'");
    $stmt->execute([$userId, $userId]);

    $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $friendIds = [];

    // Récupérer les ID des amis
    foreach ($friends as $friend) {
        if ($friend['user_id'] != $userId) {
            $friendIds[] = $friend['user_id'];
        } else {
            $friendIds[] = $friend['friend_id'];
        }
    }

    // Si aucun ami n'est trouvé, on retourne un tableau vide
    if (empty($friendIds)) {
        return [];
    }

    // Obtenir les informations des amis
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id IN (" . implode(',', $friendIds) . ")");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function removeFriend($user_id, $friend_id) {
    global $conn;
    
    $query = "DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiii", $user_id, $friend_id, $friend_id, $user_id);
    
    return $stmt->execute();
}

?>