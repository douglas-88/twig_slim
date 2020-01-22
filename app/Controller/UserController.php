<?php


namespace App\Controller;

use App\Model\User;
use Core\Controller;
use Core\Validate;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller
{
   protected $users;

   public function __construct()
   {
       $this->users = new User();
   }

    /**
     * Lista todos os usuários
     * Método de requisição: GET
     */
    public function index(){

        $this->view("home",
            [
                "users" => $this->users->all(),
                "title" => "Listando Usuários"
            ]
        );
    }

    /**
     * Exibe o formulário de criação de usuário
     * Método de requisição: GET
     */
    public function create($data = []){

       $this->view("cadastro",["post" => (!empty($data)) ? $data : ""]);

   }

    /**
     * Processa o formulário de criação de usuário
     * Método de requisição: POST
     */
   public function store(){


       $validate = new Validate();
       $data = $validate->validate([
           "nome"     => "required:max@3",
           "email"    => "required:email:unique@user",
           "telefone" => "required"
       ]);

       if($validate->hasErros()){
           $this->create($_POST);
       }


   }

    /**
     * Exibe o formulário de edição de usuário
     * Método de requisição: GET
     */
    public function edit($id)
    {

    }


    /**
     * Processa o formulário de edição de usuário
     * Método de requisição: POST
     */
    public function update()
    {

    }


    /**
     * Remove um usuário
     * Método de requisição: POST
     */
    public function remove($id)
    {

    }

}