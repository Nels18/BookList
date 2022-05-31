<?php
// On définit une constante contenant le dossier des vues
define('BASE_VIEW_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

// On importe les namespaces nécessaires
use App\Autoloader;
use App\Chore\Main;
use App\Chore\Router;
use App\Entity\BookEntity;
use App\Model\BookModel;

// On importe l'Autoloader
require_once '../Autoloader.php';
Autoloader::register();

$bookModel = new BookModel();
$books = $bookModel->findAll();
$data = [
    'author_id' => 1,
    'category_id' => 2,
    'title' => 'modifié Hpi',
    'published_at' => '2010-11-12',
];
$bookAdd = $bookModel->hydrate($data);
// $bookModel->create($bookAdd);
// $bookModel->update(6, $bookAdd);
$bookModel->delete(10);
// var_dump($books);
// var_dump($bookAdd);

// On instancie App
$app = new Main(new Router());

// On démarre l'application
$app->start();

// $router = new Router();

// $router->get('/', ['Controllers\HomeController', 'index']);
// $router->get('/orders', ['Controllers\OrderController', 'index']);

// (new App($router, [
//     'uri' => $_SERVER['REQUEST_URI'],
//     'method' => $_SERVER['REQUEST_METHOD']
//     ]
// ))->run();
