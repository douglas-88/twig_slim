<?php
session_start();
require __DIR__ . "/vendor/autoload.php";

use Slim\App;
use Dotenv\Dotenv;
use Core\Whoops;
use Core\Middleware;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new App(['settings' => $config]);
$container = $app->getContainer();


$container['AdminController'] = function ($container) {
    $service = new \App\Controller\Admin\AdminController;
    return $service;
};

$container['ProfessorController'] = function ($container) {
    $service = new \App\Controller\Admin\ProfessorController();
    return $service;
};

$container['LoginController'] = function ($container) {
    $service = new \App\Controller\Admin\LoginController();
    return $service;
};

$whoops = new Whoops();
$whoops->run($container);

$middleware = new Middleware();