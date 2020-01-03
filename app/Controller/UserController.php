<?php


namespace App\Controller;

use App\Model\User;
use Core\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller
{
   protected $users;

   public function __construct()
   {
       $this->users = new User();
   }

    public function show(Request $request,Response $response){

         $this->view("site.home",
             [
                 "users" => $this->users->all(),
                 "title" => "Listando Usuários"
             ]
         );

   }
}