<?php


namespace App\traits;


trait Validations
{

    private $erros = [];

    /**
     * Verifica se o campo foi preenchido.
     * @var void
     */
    protected function required($field){

        if(empty($_POST[$field]) OR !isset($_POST[$field])){
            $this->erros[$field][] = flash($field, error("Favor preencha esse campo"));
        }
    }

    /**
     * Verifica se o campo é um e-mail válido.
     * @var void
     */
    protected function email($field){

        if(!filter_var($_POST[$field],FILTER_VALIDATE_EMAIL)){
            $this->erros[$field][] = flash($field, error("Favor informar um e-mail válido."));
        }

    }

    /**
     * Verifica se o campo é um número de telefone válido.
     * @var void
     */
    protected function phone(){

    }

    /**
     * Verifica se o campo possui determinado tamanho de caracteres.
     * @var void
     */
    protected function max($field,$param){
        if(strlen($_POST[$field]) > $param){
            $this->erros[$field][] = flash($field, error("Favor preencha esse campo com até {$param} caracteres."));
        }
    }


    /**
     * Verifica se o valor informado já não existe cadastrado no Banco de Dados
     * a fim de evitar duplicidade.
     * @var void
     */
    protected function unique($field,$model){
         $model = "app\\Model\\".ucfirst($model);
         $model = new $model;
         $unique = $model->select()->where($field,$_POST[$field])->first();
         if($unique){
             $this->erros[$field][] = flash($field, error("Já existe um cadastro com esse valor."));
         }
    }

    public function hasErros(){

       return !empty($this->erros);
    }

    public function getErros(){
        return $this->erros;
    }

}