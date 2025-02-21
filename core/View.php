<?php 
class View {
    /**
     * Rendre une vue avec des variables optionnelles
     * 
     * @param string $view La vue à rendre
     * @param array $data Les données à passer à la vue
     */
    public static function render($view, $data = []) {
        // Si des données sont passées, les extraire dans le scope global
        if (!empty($data)) {
            extract($data);
        }
        
        // Inclure le fichier de la vue
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}
