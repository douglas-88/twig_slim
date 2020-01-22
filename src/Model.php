<?php


namespace Core;
use App\traits\Create;

/**
 * Class Model
 * @package Core
 */
 class Model extends Connection
{

    use Create;

    public $connect;


    public function all(){

        $sql  = "SELECT * FROM {$this->table}";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function find($field,$value){
        $find = "SELECT * FROM {$this->table} WHERE {$field} =:{$field}";
        $stmt = $this->connection->prepare($find);
        $stmt->bindValue(":{$field}",$value);
        $stmt->execute();
        $find = $stmt->fetch();

        return $find;
    }


}