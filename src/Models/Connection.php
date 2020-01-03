<?php


namespace Core\Models;
use \PDO;

abstract class Connection
{
   private   $erros = null;
   private   $host;
   private   $dbname;
   private   $userdb;
   private   $passworddb;
   private   $pdo;

    public function __construct()
    {
        $this->host       = "localhost";
        $this->dbname     = "twig_slim";
        $this->userdb     = "root";
        $this->passworddb = "1475";

        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try{

            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", "{$this->userdb}", "$this->passworddb",$options);

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

    public function getConnection(){
        return $this->pdo;
    }
}