<?php


namespace App\Controller\Admin;

use Core\Controller;


class PainelController extends Controller
{
   public function index(){

       $this->view("admin/painel",["title" => "Painel Admin"]);
   }

}