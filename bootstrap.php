<?php
session_start();
require __DIR__ . "/vendor/autoload.php";

use Slim\App;
use Dotenv\Dotenv;
use Core\Whoops;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new App(['settings' => $config]);
$container = $app->getContainer();

$container['UserController'] = function ($container) {
    $service = new \App\Controller\UserController;
    return $service;
};
$container['AdminController'] = function ($container) {
    $service = new \App\Controller\Admin\AdminController;
    return $service;
};

$container["PainelController"] = function ($container) {
    $service = new \App\Controller\Admin\PainelController;
    return $service;
};

$whoops = new Whoops();
$whoops->run($container);
