<?php

namespace App\Chore;

use App\Controller\BookController;

class Router
{
    public function formatUri()
    {
        $uri = $_SERVER['REQUEST_URI'];

        // On vérifie si elle n'est pas vide et si elle se termine par un '/'
        if (!empty($uri) && $uri != '/' && $uri[-1] === '/') {
            // Dans ce cas on enlève le '/'
            $uri = substr($uri, 0, -1);
            $this->redirect($uri);
        }
        $this->resolve();
    }

    public function redirect(mixed $uri)
    {
        // On envoie une redirection permanente
        http_response_code(301);

        // On redirige vers l'URL dans '/'
        header('Location: ' . $uri);
        exit;
    }

    public function resolve()
    {
        // On gère les paramètres d'URL
        // p=controleur/methode/paramètres
        // On sépare les paramètres dans un tableau
        $params = [];
        if (isset($_GET['p'])) {
            $params = explode('/', $_GET['p']);
        }

        if (isset($params[0]) && $params[0] != '') {
            // On a au moins 1 paramètre
            // On récupère le nom du contrôleur à instancier
            // On met une majuscule en 1ère lettre, on ajoute le namespace complet avant et on ajoute "Controller" après
            $controller = 'App\\Controller\\' . ucfirst(array_shift($params)) . 'Controller';
            
            // On instancie le contrôleur
            $controller = new $controller();

            // On récupère le 2ème paramètre d'URL
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)) {
                // Si il reste des paramètres on les passe à la méthode
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                http_response_code(404);
                echo "La page recherchée n'existe pas";
            }

        } else {
            // On n'a pas de paramètres
            // On instancie le contrôleur par défaut
            $controller = new BookController;

            // On appelle la méthode index
            // $controller->index();
            echo $controller->index();
        }
    }

    // private array $routes = [];

    // public function register(string $path, callable|array $action, string $verb): void
    // {
    //     $this->routes[$verb][$path] = $action;
    // }

    // public function get(string $path, callable|array $action): void
    // {
    //     $this->register($path, $action, 'GET');
    // }

    // public function post(string $path, callable|array $action): void
    // {
    //     $this->register($path, $action, 'POST');
    // }

    // public function routes(): array
    // {
    //     return $this->routes;
    // }

    // public function resolve(string $requestUri, string $requestMethod): mixed
    // {
    //     $path = explode('?', $requestUri)[0];
    //     $action = $this->routes[$requestMethod][$path] ?? null;

    //     if (is_callable($action)) {
    //         return $action();
    //     }

    //     if (is_array($action)) {
    //         [$className, $method] = $action;

    //         if (class_exists($className) && method_exists($className, $method)) {
    //             $class = new $className();
    //             return call_user_func_array([$class, $method], []);
    //         }
    //     }
    // }
}
