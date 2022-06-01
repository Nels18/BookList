<?php

namespace App\Render;

class Renderer
{
    public function render(string $view, array $parameters = [])
    {
        // On extrait le contenu de $donnees
        extract($parameters);
                
        // On démarre le buffer de sortie

        // A partir de ce point toute sortie est conservée en mémoire
        ob_start();

        
        // On crée le chemin vers la vue
        require_once ROOT . DIRECTORY_SEPARATOR . 'src/View' . DIRECTORY_SEPARATOR . $view . '.php';
        
        // Transfère le buffer dans $contenu
        $content = ob_get_clean();
        
        // Template de page
        require_once ROOT . DIRECTORY_SEPARATOR . 'src/View/base.php';
    }
}