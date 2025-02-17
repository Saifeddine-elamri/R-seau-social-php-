<?php
// utils.php
function isAuthenticated() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login");
        exit();
    }
}

function getUserProfileImage($user) {
    return !empty($user['profile_image']) 
        ? '../uploads/profil/' . htmlspecialchars($user['profile_image']) 
        : '../uploads/default.png';
}

function timeAgo($timestamp) {
    $timeDifference = time() - strtotime($timestamp);

    $units = [
        31553280 => ['an', 'ans'],
        2629440  => ['mois', 'mois'],
        604800   => ['semaine', 'semaines'],
        86400    => ['jour', 'jours'],
        3600     => ['heure', 'heures'],
        60       => ['minute', 'minutes'],
        1        => ['seconde', 'secondes'],
    ];

    foreach ($units as $unit => $texts) {
        $quotient = floor($timeDifference / $unit);
        if ($quotient > 0) {
            return "Il y a $quotient " . ($quotient > 1 ? $texts[1] : $texts[0]);
        }
    }

    return "Il y a quelques secondes";
}



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
