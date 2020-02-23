<?php


namespace App\Model;


use Core\Model;

class User extends Model
{
    protected $table = "users";
    protected $fillable = ['name','password','email','phone','avatar','role_id','created'];

    public function user(){
        $id = $_SESSION["loginInfo"]["idUser"];
        $user = $this->select()->where("id",$id)->first();
        return $user;

    }
}