<?php


namespace Core;

use Core\Model;
use Core\Password;

class Login
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function login($data,Model $model){

       $config = (object) Load::file("/config.php")["login"][$this->type];
       $user = $model->select()->where("email",$data["email"])->first();

       if(!$user){
           return false;
       }
       if(Password::verify($data["senha"],$user->senha)){
           $_SESSION[$config->loggedIn] = true;
           $_SESSION[$config->idLoggedIn] = $user->id;
           return true;
       }else{
           return false;
       }
    }

    public function logout(){
        session_destroy();

        Redirect::redirect("/admin");
        exit;
    }
}