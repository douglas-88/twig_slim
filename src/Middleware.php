<?php


namespace Core;

use App\Model\User;
use Slim\Http\Request;
use Slim\Http\Response;
use Core\Login;

class Middleware
{

    /*
    * Checa se o usuário tem permissão para acessar a página
    * caso não redireciona-o para a página a qual tem permissão.
    * @return \Closure
    */
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


    /*
     * Checa se o usuário está logado, caso sim, redireciona-o para
     * a página a qual tem permissão.
     * @return \Closure
     */
   public function checkLoggedIn()
   {

       $config = Load::file("/config.php");

       $checkLogin = function (Request $request, Response $response, $next) use($config){
           if(isset($_SESSION["loginInfo"])) {
               foreach ($config["permission"] as $key => $value) {
                   if ($_SESSION["loginInfo"]["roleUser"] == $key) {
                       return $response->withRedirect($value);
                   }
               }
           }else{
               return $response = $next($request, $response);
           }
       };

       return $checkLogin;
   }

}