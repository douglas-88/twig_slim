<?php


namespace App\traits;

use App\Model\User;
use Core\Model;
use Core\Paginate;


trait Read
{

    /**
     * Método responsável por
     * @param string $fields
     * @return User
     */
    public function select($fields = "*"){
       $this->sql = "SELECT {$fields} FROM {$this->table} ";
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

    public function getAll(){
        return $this->select()->get();
    }

    /**
     * Método responsável por Obter a quantidade de registros para a paginação.
     * @return Int
     */
    public function count():int {

        $select = $this->connection->prepare($this->sql);
        $select->execute($this->binds);
        return $select->rowCount();
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

    public function exec(){

        $select = $this->connection->prepare($this->sql);

        return $select->execute($this->binds);
    }
    /**
     * Melhorar este método para que possa aceitar a o operador AND, por exemplo:
     * WHERE field =:field AND field2 =:field2 ...
     * @return $this
     * @throws \Exception
     */
    public function where():Model{
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

    public function where2(array $rules){

       $this->sql .= " WHERE ";

        foreach ($rules as $key => $value){
            if(is_array($rules[$key])){
                $this->sql .= "{$rules[$key][0]} {$rules[$key][1]} :{$rules[$key][0]}  AND ";
                $this->binds[$rules[$key][0]] = $rules[$key][2];
            }else{
                $this->sql .= "{$rules[0]} {$rules[1]} :{$rules[0]}";
                $this->binds[$rules[0]] = $rules[2];
                break;
            }

        }

        $this->sql = rtrim($this->sql," AND ");
        return $this;
    }

    public function paginate($perPage){

       $this->paginate = new Paginate();
       $this->paginate->getRegisters($this->count());
       $this->paginate->paginate($perPage);

       $this->sql .= $this->paginate->sqlPaginate();

       return $this;
    }

    public function links(){
        return $this->paginate->links();
    }

    public function busca($fields){

       $fields = explode(",",$fields);

       if(!empty(busca())){
               if(substr_count($this->sql,"WHERE") > 0){
                   $this->sql .= " AND ";
               }else{
                   $this->sql .= " WHERE ";
               }

               foreach($fields as $field){
                    /*
                   if(substr_count($field,".") > 0){

                       list($table,$column) = explode(".",$field);
                       $tabela = $table;
                       $table = "\\App\\Model\\".ucfirst($table);
                       $model = new $table;
                       $id = $model->select("id")->where2(["name","LIKE", "%".busca()."%"])->first();
                       $this->sql .= " ".$tabela.".id = :".$tabela.".id"." OR ";
                       $this->binds[$column] = $id;

                   }else{
                       $this->sql .= " {$field} LIKE :{$field} OR ";
                       $this->binds[$field] = "%".busca()."%";
                   }
               */

                   $this->sql .= " {$field} LIKE :{$field} OR ";
                   $this->binds[$field] = "%".busca()."%";
               }
               $this->sql = rtrim($this->sql,"OR ");

       }

       return $this;

    }

    public function join($table,$column1,$column2){

        $this->sql .= " INNER JOIN {$table} ON({$column1} = {$column2}) ";

        return $this;

    }

    public function order($order){
        $this->sql .= " {$order} ";
        return $this;
    }
}