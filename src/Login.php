<?php


namespace Core;

use App\Model\Admin;
use Core\Model;
use Core\Password;

class Login
{
    private $type;

    public function __construct($type = null)
    {
        $this->type = $type;
    }

    public function login($data){

       $config = (object) Load::file("/config.php");
       $user = (new Admin())->select()->where("email",$data["email"])->first();

       if(!$user){
           return false;
       }
       if(Password::verify($data["password"],$user->password)){
           $_SESSION["loginInfo"]["loggedIn"] = true;
           $_SESSION["loginInfo"]["idUser"]   = $user->id;
           $_SESSION["loginInfo"]["roleUser"] = $user->role;
           return true;
       }else{
           return false;
       }
    }

    public static function getUserLoggedIn(Model $model){

        return $model->user();

    }

    public function logout(){



        Redirect::redirect("/admin");
        exit;
    }
}