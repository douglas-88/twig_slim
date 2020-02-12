<?php


namespace App\Controller\Admin;
use App\Model\User;
use App\Model\Admin;
use Core\Controller;
use Core\Redirect;
use Core\Validate;
use Core\Login;

class AdminController extends Controller
{
   public function index(){
       session_destroy();
       var_dump($_SESSION);
       $this->view("admin/login");
   }

   public function store(){
       $validate = new Validate();
       $data = $validate->validate([
           "email"    => "required:email",
           "senha"    => "required"
       ]);

       if($validate->hasErros()){
           foreach($data as $field => $value){
               flash("post_".$field,$data[$field]);
           }
           back();
           exit;
       }

       $login = new Login("admin");
       $loginIn = $login->login($data,new Admin);

       if($loginIn){
           Redirect::redirect("/painel");
           exit;
       }else{
           Redirect::redirect("/admin");
           exit;
       }

   }

   public function destroy(){

       $login = new Login("admin");
       $login->logout();

   }
}