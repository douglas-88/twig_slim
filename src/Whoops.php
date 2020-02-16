<?php


namespace Core;
use Dopesong\Slim\Error\Whoops as WhoopsError;

class Whoops extends WhoopsError
{
   private function slim($container){

       $container['errorHandler'] = function(){
           return $this;
       };
   }

   private function php(){

       $this->pushHandler(new \Whoops\Handler\PrettyPageHandler);
       $this->whoops->register();
   }

   public function run($app){
       $this->slim($app);
       $this->php();
   }

}