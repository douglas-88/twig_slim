<?php


namespace App\Controller\Admin;

use App\Model\User;
use Core\Controller;
use Core\Load;
use Core\Password;
use Core\Redirect;
use Core\Validate;
use Core\PasswordRecovery;
use Slim\Http\Request;
use Slim\Http\Response;

class PasswordRecoveryController extends Controller
{


    /**
     * Exibe formulário de informar o e-mail para enviar link:
     */
    public function index(){

        $this->view("admin/esqueceu_senha",["template_admin" => $this->templateAdmin]);

    }

    /*
     * Checa se o e-mail existe para poder enviar o link por e-mail.
     * Se a mensagem foi enviada com sucesso, o usuário é redirecionado para uma tela de confirmação.
     */
    public function checkMail(){

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
        $user = (new User())->select()->where2(["email","=",$data["email"]])->first();

        if(!$user){
            flash("warning",error("Email: {$data["email"]} não cadastrado."));
            back();
        }else{

            $recovery = new PasswordRecovery();
            $MessageStatus = $recovery->sendMessageLink($user);
            if($MessageStatus){
                flash("email",$data["email"]);
                Redirect::redirect("/reset-password-link-send");
            }

        }

    }

    /*
     * Verifica se o CÓDIGO existe no BD e se já não passou de 1h desde a solicitação.
     * Se estiver tudo certo, o usuário é redirecionado a Tela de criar uma nova senha.
     */
    public function checkCode(Request $request,Response $response,$args){

          $code     =  $request->getAttribute("code");
          $recovery = new PasswordRecovery();
          if($recovery->checkValidateCode($code)){
              Redirect::redirect("/recover-password/user/{$code}");
          }else{
              Redirect::redirect("/forgot-password");
          }

    }

    public function showFormUpdate(Request $request,Response $response,$args){
        $code     =  $request->getAttribute("code");
            
        $this->view("admin/reset_senha",["template_admin" => $this->templateAdmin,"code" => $code]);
    }

    public function linkConfirm(){
        $this->view("admin/link_enviado",["template_admin" => $this->templateAdmin]);
    }

    public function updatePassword(Request $request,Response $response,$args){
        $code         =  $request->getAttribute("code");
        $newPassword     =  $request->getParsedBodyParam("password");

        $password = new PasswordRecovery();
        $password->updatePassword($code,$newPassword);
    }
}