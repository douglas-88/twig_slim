<?php

use Twig\TwigFunction;
use Core\Flash;
use Core\Validate;

$erros = new TwigFunction("erros",function($index){
    echo Flash::get($index);
});

$sent = new TwigFunction("sent",function($index){
    echo Flash::get("post_".$index);
});

return [$erros,$sent];