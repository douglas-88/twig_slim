<?php

namespace App\traits;


trait Create
{
    public function create(array $attributes){

        $sql  = "INSERT INTO {$this->table}";
        $sql .= "(".implode(",",array_keys($attributes)).")";
        $sql .= " VALUES(".":".implode(", :",array_keys($attributes)).")";

        $create = $this->connection->prepare($sql);
        $create->execute($attributes);

        return $this->connection->lastInsertId();
    }
}