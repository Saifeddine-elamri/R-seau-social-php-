<?php

// Vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Récupérer un utilisateur par son ID
function getUserById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Envoyer une demande d'ami
function sendFriendRequest($userId, $friendId) {
    global $pdo;

    // Vérifier que la demande n'existe pas déjà
    $stmt = $pdo->prepare(
        "SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)"
    );
    $stmt->execute([$userId, $friendId, $friendId, $userId]);
    $existingRequest = $stmt->fetch();

    if ($existingRequest) {
        return "A request already exists."; // Demande déjà existante
    }

    // Envoyer la demande d'amitié (status = 'pending')
    $stmt = $pdo->prepare("INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'pending')");
    $stmt->execute([$userId, $friendId]);

    return "Friend request sent!"; // Demande envoyée avec succès
}

// Accepter une demande d'ami
function acceptFriendRequest($userId, $friendId) {
    global $pdo;

    // Vérifier si la demande existe et est en statut "pending"
    $stmt = $pdo->prepare(
        "SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)"
    );
    $stmt->execute([$userId, $friendId, $friendId, $userId]);
    $request = $stmt->fetch();

    if (!$request || $request['status'] !== 'pending') {
        return "No pending friend request found."; // Pas de demande en attente
    }

    // Accepter la demande (changer le statut en 'accepted')
    $stmt = $pdo->prepare(
        "UPDATE friends SET status = 'accepted' WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)"
    );
    $stmt->execute([$userId, $friendId, $friendId, $userId]);

    return "Friend request accepted!"; // Demande acceptée avec succès
}

// Rejeter une demande d'ami
function rejectFriendRequest($userId, $friendId) {
    global $pdo;

    // Vérifier si la demande existe et est en statut "pending"
    $stmt = $pdo->prepare(
        "SELECT * FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)"
    );
    $stmt->execute([$userId, $friendId, $friendId, $userId]);
    $request = $stmt->fetch();

    if (!$request || $request['status'] !== 'pending') {
        return "No pending friend request found."; // Pas de demande en attente
    }

    // Rejeter la demande (supprimer l'enregistrement)
    $stmt = $pdo->prepare(
        "DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)"
    );
    $stmt->execute([$userId, $friendId, $friendId, $userId]);

    return "Friend request rejected."; // Demande rejetée avec succès
}

// Récupérer la liste des amis d'un utilisateur
function getFriends($userId) {
    global $pdo;

    // Obtenir les amis de l'utilisateur avec statut 'accepted'
    $stmt = $pdo->prepare(
        "SELECT * FROM friends WHERE (user_id = ? OR friend_id = ?) AND status = 'accepted'"
    );
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

    // Obtenir les informations des amis à partir de leurs IDs
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id IN (" . implode(',', $friendIds) . ")");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourner les amis trouvés
}

// Supprimer un ami de la liste d'amis
function removeFriend($user_id, $friend_id) {
    global $pdo;

    // Requête pour supprimer l'ami de la base de données
    $query = "DELETE FROM friends WHERE (user_id = :user_id AND friend_id = :friend_id) 
              OR (user_id = :friend_id AND friend_id = :user_id)";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':user_id'   => $user_id,
        ':friend_id' => $friend_id
    ]);

    // Retourne vrai si au moins une ligne a été supprimée, sinon false
    return $stmt->rowCount() > 0;
}

?>
