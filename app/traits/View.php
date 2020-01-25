<?php

namespace App\traits;
use Core\Load;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

trait View{

    protected $twig;

    protected function twig(){

        $loader     = new FilesystemLoader(__DIR__ . "/../../views");
        $this->twig = new Environment($loader, ['debug' => true]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

   protected function functions(){
        $functions = Load::file("/app/Functions/twig.php");

        foreach ($functions as $function){
            $this->twig->addFunction($function);
        }
   }

    protected function load(){
        $this->twig();
        $this->functions();
    }

    protected function view(string $view, array $data = []){
        $this->load();
        echo $this->twig->render(str_replace(".","/",$view).".html",$data);
    }
}