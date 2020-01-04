<?php
session_start();
require __DIR__ . "/vendor/autoload.php";

use Slim\App;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new App(['settings' => $config]);