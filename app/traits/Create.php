<?php

namespace App\traits;


trait Create
{
    public $lastCreated;

    public function create(array $attributes):object {

        $sql  = "INSERT INTO {$this->table}";
        $sql .= "(".implode(",",array_keys($attributes)).")";
        $sql .= " VALUES(".":".implode(", :",array_keys($attributes)).")";

        $create = $this->connection->prepare($sql);

        try{
            $create->execute($attributes);
            $this->lastCreated = $this->connection->lastInsertId();
        }catch(\PDOException $e){
            $this->setErros($e->getMessage());
        } finally {
            return $this;
        }



    }
}