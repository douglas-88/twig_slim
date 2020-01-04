<?php

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

    Flash::add($field,$message);

}

function error($message){
    return "<div class=\"alert alert-danger mt-2\" role=\"alert\">
              {$message}
            </div>";

}

function success($message){
    return "<div class=\"alert alert-success mt-2\" role=\"alert\">
              {$message}
            </div>";

}

function back(){
    Redirect::back();
}