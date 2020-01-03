<?php

namespace App\traits;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

trait View{

    protected $twig;

    protected function twig(){

        $loader     = new FilesystemLoader(__DIR__ . "/../../views");
        $this->twig = new Environment($loader);

    }

    protected function load(){
        $this->twig();
    }

    protected function view(string $view, array $data){
        $this->load();
        echo $this->twig->render(str_replace(".","/",$view).".html",$data);
    }
}