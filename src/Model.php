<?php


namespace Core;
use App\traits\Create;
use App\traits\Read;
use App\traits\Update;
use App\traits\Delete;

/**
 * Class Model
 * @package Core
 */
 class Model extends Connection
{

    protected $field;
    protected $value;
    protected $sql;
    protected $binds;
    protected $paginate;

    use Create,Read,Update,Delete;


    public function find($field,$value){

        if((!isset($field) || empty($field))|| (!isset($value) || empty($value))){
            throw new \Exception("Opa, favor informar um FIELD e um VALUE ao chamar o método find().");
        }

        $this->field = filter_var($field,FILTER_SANITIZE_STRING);
        $this->value = filter_var($value,FILTER_SANITIZE_NUMBER_INT);

        return $this;
    }


}