<?php

use Twig\TwigFunction;
use Core\Flash;
use Core\Validate;

$message = new TwigFunction("message",function($index){
    echo Flash::get($index);
});



return [
    $message
];