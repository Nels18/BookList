<?php

namespace App\Chore;

use App\Chore\Router;

class Main
{
    public function __construct(private Router $router)
    {}

    public function start()
    {
        $this->router->formatUri();
        echo "Main";

        // echo $this->router->resolve($this->request['uri'], $this->request['method']);
    }
}