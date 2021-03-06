<?php

use App\Controller\Admin\PasswordRecoveryController;
use Core\Flash;
use Core\Redirect;

function dd($data){

    var_dump($data);
    exit;

}

function json($data) {
    header('Content-Type: application/json');

    echo json_encode($data);
}


function path(){

     $vendorDir = dirname(dirname(__FILE__));
     return dirname($vendorDir);

}

function flash($field,$message){

    return Flash::add($field,$message);

}

function error($message){
    return "<div class=\"alert alert-danger mt-2\" alert-dismissible fade show\"  role=\"alert\">
              {$message}
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">
              </button>
            </div>";

}

function success($message){
    return "<div class=\"alert alert-success mt-2 alert-dismissible fade show\"  role=\"alert\">
              {$message}
               <button type=\"button\" class=\"close\" data-dismiss=\"alert\">
              </button>
            </div>";

}

function back(){
    Redirect::back();
    exit;
}

function busca(){
    return filter_input(INPUT_GET,"s",FILTER_SANITIZE_STRING);
}

function recoveryPasswordGenerate(){

    $hash = md5(rand());
    $code = base64_encode(openssl_encrypt($hash,"AES-128-ECB",PasswordRecoveryController::SECRET));
    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    $url = $root . "recovery-password/code={$code}";

    return $url;
}

function url(){
   
    return $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];

}