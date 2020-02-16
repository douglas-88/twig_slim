<?php


namespace App\Model;

use Core\Model;


class Admin extends Model
{
    protected $table = "admin";

    public function user(){
        $id = $_SESSION["loginInfo"]["idUser"];
        $user = $this->select()->where("id",$id)->first();

        return $user;
    }
}