<?php

namespace App\Render;

class Renderer
{
    public function render(string $view, array $parameters = null): string | false
    {
        ob_start();
        require_once $view;
        $content = ob_get_clean();
        
        if (!$content) {
            return $this->noResults();
        }

        return ($content);
    }

    public function noResults(): string
    {
        return '<p>Aucun résultat trouvé</p>';
    }
}