<?php

require __DIR__ . "/../bootstrap.php";

$app->get("/","App\Controller\UserController:index");
$app->get("/users/create","App\Controller\UserController:create");
$app->post("/users/store","App\Controller\UserController:store");

$app->run();

/**
 * Meu comentário de teste
 */






