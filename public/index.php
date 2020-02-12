<?php

require __DIR__ . "/../bootstrap.php";

$app->get("/","UserController:index");
$app->get("/users/create","UserController:create");
$app->post("/users/store","UserController:store");
$app->get("/users/edit/{id}","UserController:edit");
$app->post("/users/update/{id}","UserController:update");
$app->get("/users/delete/{id}","UserController:delete");


$app->get("/admin","AdminController:index");
$app->post("/login","AdminController:store");
$app->get("/logout","AdminController:destroy");
$app->get("/painel","PainelController:index");


$app->run();