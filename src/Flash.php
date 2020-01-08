<?php


namespace Core;


class Flash
{

     public static function add($index,$message){

         if(!isset($_SESSION[$index])){
             $_SESSION[$index] = $message;
             return $_SESSION[$index];
         }

     }

     public static function get($index){
         if(isset($_SESSION[$index])){
             $message = $_SESSION[$index];
             unset($_SESSION[$index]);
         }

         return $message ?? "";
     }

}