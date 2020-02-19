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

$message =  new TwigFunction("message",function($index) {
    echo Flash::get($index);

});

$admin =  new TwigFunction("admin",function() {

    return (new \App\Model\User())->user();

});

return [$erros,$sent,$message,$admin];