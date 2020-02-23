<?php


namespace Core;

use Core\Email;
use \DateTime;
use App\Model\User;

class PasswordRecovery extends Model
{
   protected $user;
   protected $link;
   protected $code;
   protected $key = "DEUSNOCONTROLE!!";
   protected $message;
   protected $table = "password_recovery";

    private function codeCreate():void{

       $hash = md5(rand());
       $this->code = base64_encode(openssl_encrypt($hash,"AES-128-ECB",$this->key));

   }

   private function linkCreate():void{
       $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
       $this->link = $root . "reset-password/code/{$this->code}";
   }

   private function messageCreate(){

   }

   private function recordAttempt(){
     $data = [
         "email"   => $this->user->email,
         "hash"    => $this->code,
         "status"  => 0,
         "user_id" => $this->user->id
     ];

       $this->create($data);
   }

    public function sendMessageLink(object $user){
        $this->user = $user;
        $this->codeCreate();
        $this->linkCreate();
        $this->recordAttempt();
        $email = new Email();
        $email = $email->enviar($this->user->email,"Projeto Resgate - Recuperação de Senha","Recupere sua senha clicando no link: ".$this->link."<br><br>Obs:Este link tem validade de 1h.");

        return $email;
    }

    public function checkValidateCode($code){

        $codeUser = $this->select()->where2(["hash","=",$code])->first();

        if(is_object($codeUser)){
            $dateatual         = new DateTime();
            $dateresetrecovery = new DateTime($codeUser->created);
            $intervalDiff      = $dateatual->diff($dateresetrecovery);
            if($intervalDiff->h > 0){
                $this->delete2()->where2(["hash","=",$code])->exec();
                flash("warning",error("Link de recuperação de senha EXPIRADO.<br>Favor solicitar recuperação de senha novamente."));
                return false;
            }
            return true;
        }

    }

    public function updatePassword(string $code,string $newPassword){


        $user = $this->select()->where2(["hash","=",$code])->first();
        $recoveryId = $user->id;
        $userId = $user->user_id;
        if(is_object($user)){
            $userId = $user->user_id;
            $user = new User();
            $status = $user->update2(["password" => Password::make($newPassword)])->where2(["id","=",$userId])->exec();
            if(empty($status->getErros())){
                $statusRecover = $this->delete2()->where2(["user_id","=",$userId])->exec();
                if(empty($statusRecover->getErros())){
                    Redirect::redirect("/login");
                }
            }
        }
    }

}