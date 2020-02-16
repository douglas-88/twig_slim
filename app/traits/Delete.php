<?php


namespace App\traits;


trait Delete
{
    public function delete(){
        $this->sql = "DELETE FROM {$this->table} WHERE {$this->field} =:{$this->field}";
        $this->binds = [
            $this->field => $this->value
        ];

        $delete = $this->connection->prepare($this->sql);
        $delete->execute($this->binds);

        return $delete->rowCount();
    }
}