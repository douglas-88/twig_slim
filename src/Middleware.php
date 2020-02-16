<?php


namespace Core;

use App\Model\Admin;
use Slim\Http\Request;
use Slim\Http\Response;
use Core\Login;

class Middleware
{



   public function auth($role){

       $config = Load::file("/config.php");

       $admin = function(Request $request,Response $response,$next) use($config,$role){

           if(!isset($_SESSION["loginInfo"])){
               return $response->withRedirect("/login");
           }elseif($_SESSION["loginInfo"]["roleUser"] == $role){
               $response = $next($request, $response);
           }else {
               foreach ($config["permission"] as $key => $value) {
                   if ($_SESSION["loginInfo"]["roleUser"] == $key) {
                       return $response->withRedirect($value);
                   }
               }
           }

           return $response;
       };

       return $admin;

   }
}