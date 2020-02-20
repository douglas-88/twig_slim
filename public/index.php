<?php

require __DIR__ . "/../bootstrap.php";
//var_dump($_SESSION);

$app->get("/login","LoginController:index")->add($middleware->checkLoggedIn());
$app->post("/login","LoginController:store");
$app->get("/logout","LoginController:destroy");
$app->get("/forgot-password","PasswordRecoveryController:forgot")->add($middleware->checkLoggedIn());
$app->post("/forgot-password","PasswordRecoveryController:enviarLinkRecuperarSenha");

$app->group("/painel/admin",function() use ($app){
    $app->get("[/]","AdminController:index");
})->add($middleware->auth(1));

$app->group("/painel/professor",function() use ($app){
    $app->get("[/]","ProfessorController:index");
})->add($middleware->auth(2));

$app->run();