<?php


namespace Core;
use \PDO;

abstract class Connection
{
   private   $erros;
   private   $host;
   private   $dbname;
   private   $userdb;
   private   $passworddb;
   public    $connection;

    public function __construct()
    {
        $this->host       = $_ENV["DB_HOST"];
        $this->dbname     = $_ENV["DB_DATABASE"];
        $this->userdb     = $_ENV["DB_USERNAME"];
        $this->passworddb = $_ENV["DB_PASSWORD"];

        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try{

            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", "{$this->userdb}", "$this->passworddb",$options);
        }catch(\PDOException $e){
            $this->erros = $e->getMessage();
        }

    }

    public function getErros(){
       return $this->erros;
    }

    public function setErros(string $erro){
        $this->erros = $erro;
    }


}