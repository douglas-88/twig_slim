<?php

require __DIR__ . "/../bootstrap.php";

$app->get("/","App\Controller\UserController:index");
$app->get("/users/create","App\Controller\UserController:create");
$app->post("/users/store","App\Controller\UserController:store");
$app->get("/users/edit/{id}","App\Controller\UserController:edit");
$app->post("/users/update/{id}","App\Controller\UserController:update");
$app->get("/users/delete/{id}","App\Controller\UserController:delete");

$app->run();