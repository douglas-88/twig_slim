<?php

require __DIR__ . "/../bootstrap.php";
//var_dump($_SESSION);

$app->get("/login","LoginController:index")->add($middleware->checkLoggedIn());
$app->post("/login","LoginController:store");
$app->get("/logout","LoginController:destroy");

$app->get("/forgot-password","PasswordRecoveryController:index")->add($middleware->checkLoggedIn());
$app->post("/forgot-password","PasswordRecoveryController:checkMail");
$app->get("/reset-password/code/{code}","PasswordRecoveryController:checkCode")->add($middleware->checkLoggedIn());
$app->get("/reset-password-link-send","PasswordRecoveryController:linkConfirm");
$app->get("/recover-password/user/{code}","PasswordRecoveryController:showFormUpdate")->add($middleware->checkLoggedIn());
$app->post("/reset-password/user/{code}","PasswordRecoveryController:updatePassword");

$app->group("/painel/admin",function() use ($app){
    $app->get("[/]","AdminController:index");
})->add($middleware->auth(1));

$app->group("/painel/professor",function() use ($app){
    $app->get("[/]","ProfessorController:index");
})->add($middleware->auth(2));

$app->run();