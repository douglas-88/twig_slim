<?php


namespace App\Model;

use Core\Model;


class User extends Model
{
    protected $table = "users";

    public function user(){
        $id = $_SESSION["loginInfo"]["idUser"];
        $user = $this->select()->where("id",$id)->first();
        return $user;
    }
}