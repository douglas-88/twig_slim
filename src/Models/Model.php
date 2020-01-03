<?php


namespace Core\Models;


abstract class Model extends Connection
{

    public function all(){

        $sql  = "SELECT * FROM {$this->table}";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}