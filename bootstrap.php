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
$config['db'] = [
    'driver'    => 'mysql',
    'host'      => $_ENV["DB_HOST"],
    'database'  => $_ENV["DB_DATABASE"],
    'username'  => $_ENV["DB_USERNAME"],
    'password'  => $_ENV["DB_PASSWORD"],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => ''
];

$app = new App(['settings' => $config]);
$container = $app->getContainer();


$container['AdminController'] = function ($container) {
    $service = new \App\Controller\Admin\AdminController($container);
    return $service;
};

$container['ProfessorController'] = function ($container) {
    $service = new \App\Controller\Admin\ProfessorController($container);
    return $service;
};

$container['LoginController'] = function ($container) {
    $service = new \App\Controller\Admin\LoginController($container);
    return $service;
};

$container['PasswordRecoveryController'] = function ($container) {
    $service = new \App\Controller\Admin\PasswordRecoveryController($container);
    return $service;
};

$container['db'] = function ($container) {

    $config = $container->get('settings');
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($config["db"]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();


    return $capsule;
};

$whoops = new Whoops();
$whoops->run($container);

$middleware = new Middleware();