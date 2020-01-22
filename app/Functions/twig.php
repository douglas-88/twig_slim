<?php

use Twig\TwigFunction;
use Core\Flash;
use Core\Validate;

$erros = new TwigFunction("erros",function($index){
    echo Flash::get($index);
});


return [
    $erros
];