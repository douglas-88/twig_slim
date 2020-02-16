<?php


namespace Core;


class Redirect
{
    public static function redirect($target){
        header("Location:{$target}");
        exit;
    }

    public static function back(){
        $previous = "javascript:history.go(-1)";

        if(isset($_SERVER["HTTP_REFERER"])){
            $previous = $_SERVER["HTTP_REFERER"];
        }

        return self::redirect($previous);
    }
}