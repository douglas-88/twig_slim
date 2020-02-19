<?php


namespace App\Controller\Admin;

use Core\Controller;
use Core\Flash;
use Core\Load;
use Core\Login;
use Core\Redirect;
use Core\Validate;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\User;

class LoginController extends Controller
{

    /**
     * Página Inicial
     */
    public function index()
    {
       $this->view("admin/login",["template_admin" => $this->templateAdmin]);
    }

    /**
     * Exibe o formulário de criação
     */
    public function create()
    {
        echo 'create';
    }

    /**
     * Processa Formulário de Login
     */
    public function store(Request $request, Response $response)
    {
        $validate = new Validate();
        $data = $validate->validate([
            "email" => "required:email",
            "password" => "required"
        ]);

        if($validate->hasErros()){
            foreach($data as $field => $value){
                flash("post_".$field,$data[$field]);
            }
            back();
        }

        $login = new Login();
        $loggedIn = $login->login($data);

        if(!$loggedIn){
            Flash::add("warning",error("Email ou Senha inválidos."));
            back();
        }

        Redirect::redirect("/painel/admin");


    }

    /**
     * Exibe dado do Banco de dados
     */
    public function show($id)
    {
        echo 'show';
    }

    /**
     * Exibe o formulário de edição
     */
    public function edit($id)
    {
        echo 'edit';
    }

    /**
     * Processa o formulário de edição
     */
    public function update(Request $request, Response $response, $args)
    {
        echo 'update';
    }

    /**
     * Remove dados do Banco
     */
    public function destroy()
    {

        if(isset($_SESSION["loginInfo"]) && !empty($_SESSION["loginInfo"])){
            unset($_SESSION["loginInfo"]);
        }

        Redirect::redirect("/login");

    }

}