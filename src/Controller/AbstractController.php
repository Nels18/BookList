<?php

namespace App\Controller;

use  App\Render\Renderer;

class AbstractController
{
    public $renderer;

    public function __construct() {
        $this->renderer = new Renderer();
    }
    
    public function noResults(): string
    {
        return $this->renderer->noResults();
    }

    public function render(string $view, array $parameters = null): string | false
    {
        return $this->renderer->render($view, $parameters);
    }
}
