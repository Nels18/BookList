<?php

namespace App\Chore;

use App\Chore\Router;

class Main
{
    public function __construct(private Router $router)
    {}

    public function start()
    {
        // On démarre la session
        session_start();

        $this->router->formatUri();
    }
}