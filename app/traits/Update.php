<?php


namespace App\traits;


trait Update
{
    public function update(array $attributes):object{
        $this->sql = "UPDATE {$this->table} SET ";

        foreach ($attributes as $field => $value){
            $this->sql .= "{$field} =:{$field},";
        }

        $this->sql = rtrim($this->sql,",");
        $this->sql.= " WHERE {$this->field} =:{$this->field}";

        $attributes["id"] = $this->value;
        $this->binds = $attributes;

        $update = $this->connection->prepare($this->sql);
        try {
            $update->execute($this->binds);
            $this->lastCreated = $this->connection->lastInsertId();
        }catch(\PDOException $e){
            $this->setErros($e->getMessage());
        } finally {
            return $this;
        }

    }

    public function update2(array $attributes){
        $this->sql = "UPDATE {$this->table} SET ";

        foreach ($attributes as $field => $value){
            $this->sql .= "{$field} =:{$field},";
        }

        $this->sql = rtrim($this->sql,",");
        $this->binds = $attributes;

        return $this;

    }
}