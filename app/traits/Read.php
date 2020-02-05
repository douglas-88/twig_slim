<?php


namespace App\traits;



trait Read
{

    public function select($fields = "*"):object{
       $this->sql = "SELECT {$fields} FROM {$this->table}";

       return $this;
    }

    public function bindAndExecute(){
        $select = $this->connection->prepare($this->sql);
        $select->execute($this->binds);

        return $select;
    }

    public function first(){
        $select  = $this->bindAndExecute();
        return $select->fetch();
    }

    public function get(){
        $select  = $this->bindAndExecute();
        return $select->fetchAll();
    }

    public function where(){
        $num_args = func_num_args();
        $args     = func_get_args();

        if($num_args == 2){
            $field = $args[0];
            $sinal = "=";
            $value = $args[1];
        }

        if($num_args == 3){
            $field = $args[0];
            $sinal = $args[1];
            $value = $args[2];
        }

        if($num_args <= 1 || $num_args > 3){
            throw new \Exception('Opa, o método WHERE deve ter no mínimo 2 e no máximo 3 argumentos');
        }

        $this->binds = [
            $field => $value
        ];

        $this->sql .= " WHERE {$field} {$sinal} :{$field}";

        return $this;
    }
}