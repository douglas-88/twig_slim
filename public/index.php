<?php

require __DIR__ . "/../bootstrap.php";


$app->get("/","App\\Controller\\UserController:show");

$app->run();






