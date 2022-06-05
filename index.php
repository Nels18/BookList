<?php
// On définit une constante contenant le dossier des vues
define('ROOT', __DIR__);

// On importe les namespaces nécessaires
use App\Autoloader;
use App\Chore\Main;
use App\Chore\Router;

// On importe l'Autoloader
require_once 'Autoloader.php';
Autoloader::register();

// On instancie App
$app = new Main(new Router());

// On démarre l'application
$app->start();
