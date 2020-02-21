<?php


namespace Core;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


class Email extends PHPMailer
{

    public function __construct($html,$exceptions = null)
    {

        $this->SMTPDebug = SMTP::DEBUG_OFF;
        $this->isSMTP();
        $this->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $this->SMTPAuth   = true;                                   // Enable SMTP authentication
        $this->Username   = 'dcdouglas64@gmail.com';                     // SMTP username
        $this->Password   = 'nokia5233';                               // SMTP password
        $this->SMTPSecure = "tls";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $this->Port       = 587;
        $this->isHTML(true);
        $this->CharSet = 'UTF-8';
        $this->setLanguage("pt_br");
        $this->setFrom("dcdouglas64@gmail.com");
        $this->addAddress("conveswebtecnologia@gmail.com");
        $this->addAddress("douglasflamengo_07@hotmail.com");
        $this->addAddress("dcdouglas64@gmail.com");
        $this->Subject = "Recuperação de senha";
        $this->Body = $html;

        parent::__construct($exceptions);
    }

}