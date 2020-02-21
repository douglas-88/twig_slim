<?php


namespace App\Controller\Admin;


use App\Model\User;
use Core\Controller;
use Core\Load;
use Core\Validate;
use Core\PasswordRecovery;

class PasswordRecoveryController extends Controller
{

    CONST SECRET = "DEUSNOCONTROLE!!";

    public function forgot(){

        $this->view("admin/esqueceu_senha",["template_admin" => $this->templateAdmin]);

    }

    public function enviarLinkRecuperarSenha(){

        $validate = new Validate();
        $data = $validate->validate([
            "email" => "required:email"
        ]);

        if($validate->hasErros()){
            foreach($data as $field => $value){
                flash("post_".$field,$data[$field]);
            }
            back();
        }

        $config = (object) Load::file("/config.php");
        $user = (new User())->select()->where("email",$data["email"])->first();

        if(!$user){
            echo("Não achou o e-mail: {$data["email"]}");
            return false;
        }else{

            $recovery = new PasswordRecovery();
            dd($recovery->sendMessageLink($user));

        }

    }
}