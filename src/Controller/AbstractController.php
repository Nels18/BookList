<?php

namespace App\Controller;

class AbstractController
{

    public function noResults(): string
    {
        return '<p>Aucun résultat trouvé</p>';
    }

    public function render(string $view, array $parameters): string | false
    {
        $template = $_SERVER['DOCUMENT_ROOT'] . "index.php";

        ob_start();
        require_once $view;
        $content = ob_get_clean();
        require_once $template;

        return $content;
    }
}
