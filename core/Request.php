<?php
    class Request {
    /**
     * Récupérer une valeur depuis $_POST avec une validation optionnelle
     */
    public static function post(string $key, $filter = FILTER_SANITIZE_STRING) {
        return filter_input(INPUT_POST, $key, $filter);
    }

    /**
     * Récupérer une valeur depuis $_GET avec une validation optionnelle
     */
    public static function get(string $key, $filter = FILTER_SANITIZE_STRING) {
        return filter_input(INPUT_GET, $key, $filter);
    }
}
