<?php

class Redirect
{
    // Méthode pour rediriger vers une URL spécifique
    public static function to($url)
    {
        header("Location: $url");
        exit();
    }
}
?>
