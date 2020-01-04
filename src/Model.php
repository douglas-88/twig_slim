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

}