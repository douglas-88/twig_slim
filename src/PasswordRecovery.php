<?php


namespace Core;

use Core\Email;

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
       $this->link = $root . "recovery-password/code={$this->code}";
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
        $email = new Email($this->link);
        $email = $email->send();

        return $email;
    }

}