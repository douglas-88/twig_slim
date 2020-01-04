<?php

use Twig\TwigFunction;
use Core\Flash;

$message = new TwigFunction("message",function($index){
    echo Flash::get($index);
});



return [
    $message
];