<?php

require __DIR__ . "/../bootstrap.php";

$app->get("/login", "LoginController:index")->add($middleware->checkLoggedIn());
$app->post("/login", "LoginController:store");
$app->get("/logout", "LoginController:destroy");

$app->get("/forgot-password", "PasswordRecoveryController:index")->add($middleware->checkLoggedIn());
$app->post("/forgot-password", "PasswordRecoveryController:checkMail");
$app->get("/reset-password/code/{code}", "PasswordRecoveryController:checkCode")->add($middleware->checkLoggedIn());
$app->get("/reset-password-link-send", "PasswordRecoveryController:linkConfirm");
$app->get("/recover-password/user/{code}", "PasswordRecoveryController:showFormUpdate")->add($middleware->checkLoggedIn());
$app->post("/reset-password/user/{code}", "PasswordRecoveryController:updatePassword");

$app->group("/painel/admin", function () use ($app) {
	$app->get("[/]", "AdminController:index");
	$app->get("/category[/]", "CategoryController:index");
	$app->get("/category/create", "CategoryController:create");
	$app->get("/category/{id}", "CategoryController:edit");
	$app->post("/category/create", "CategoryController:store");
	$app->post("/category/{id}", "CategoryController:update");
	$app->get("/category/delete/{id}", "CategoryController:destroy");

    $app->get("/posts[/]", "PostController:index");
    $app->get("/post/create", "PostController:create");
    $app->get("/post/{id}", "PostController:edit");
    $app->post("/post/create", "PostController:store");
    $app->post("/post/{id}", "PostController:update");
    $app->get("/post/delete/{id}", "PostController:destroy");
})->add($middleware->auth(1));

$app->group("/painel/professor", function () use ($app) {
	$app->get("[/]", "ProfessorController:index");
})->add($middleware->auth(2));

$app->run();