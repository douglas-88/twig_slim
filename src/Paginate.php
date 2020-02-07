<?php


namespace Core;


use App\traits\Links;

class Paginate
{
    private $page;
    private $perPage;
    private $offSet;
    private $pages;
    private $registers;

    use Links;

    private function current(){
        $this->page = filter_input(INPUT_GET,"page",FILTER_SANITIZE_NUMBER_INT) ?? 1;
    }

    private function perPage($perPage){
        $this->perPage = $perPage ?? 30;
    }

    private function offSet(){
       $this->offSet = ($this->page * $this->perPage) - $this->perPage;
    }

    private function pages(){
        $this->pages = ceil($this->registers/$this->perPage);
    }

    public function getRegisters($registers){
       $this->registers = $registers;
    }

    public function sqlPaginate(){
        return " LIMIT {$this->perPage} OFFSET {$this->offSet} ";
    }

    public function paginate($perPage){
        $this->current();
        $this->perPage($perPage);
        $this->offSet();
        $this->pages();
    }
}