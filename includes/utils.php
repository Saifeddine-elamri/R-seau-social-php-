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
?>
