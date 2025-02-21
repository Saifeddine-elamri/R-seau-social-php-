<?php
class Session {

/**
 * Démarre la session si ce n'est pas déjà fait
 */
public static function start() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Récupère une valeur de la session
 */
public static function get($key) {
    return $_SESSION[$key] ?? null;
}

/**
 * Définit une valeur dans la session
 */
public static function set($key, $value) {
    $_SESSION[$key] = $value;
}

/**
 * Vérifie si une clé existe dans la session
 */
public static function exists($key) {
    return isset($_SESSION[$key]);
}

/**
 * Détruit la session
 */
public static function destroy() {
    session_unset();
    session_destroy();
}
}
