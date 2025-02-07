<?php
require_once __DIR__ . '/../includes/db.php';

class User {
    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}
?>
