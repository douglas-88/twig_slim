<?php


namespace App\traits;



use App\Model\User;

trait Read
{

    /**
     * Método responsável por
     * @param string $fields
     * @return User
     */
    public function select($fields = "*"):User{
       $this->sql = "SELECT {$fields} FROM {$this->table}";
       return $this;
    }

    /**
     * Método responsável por Preparar as Instruções SQL e Fazer o Bind
     * @return \PDOStatement
     */
    public function bindAndExecute():\PDOStatement{
        $select = $this->connection->prepare($this->sql);
        $select->execute($this->binds);
        return $select;
    }

    /**
     * Método responsável por obter apenas o 1º Registro encontrado.
     * @return object
     */
    public function first(){
        $select  = $this->bindAndExecute();
        return $select->fetch();
    }


    /**
     * Método responsável por obter todos os registros.
     * @return array
     */
    public function get():array{
        $select  = $this->bindAndExecute();
        return $select->fetchAll();
    }

    /**
     * Melhorar este método para que possa aceitar a o operador AND, por exemplo:
     * WHERE field =:field AND field2 =:field2 ...
     * @return $this
     * @throws \Exception
     */
    public function where():User{
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