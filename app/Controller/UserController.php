<?php


namespace App\Controller;

use App\Model\User;
use Core\Controller;
use Core\Login;
use Core\Password;
use Core\Validate;
use Slim\Http\Request;
use Slim\Http\Response;
use Core\Redirect;
use Core\Flash;

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
                "users" => $this->users->select()->busca("nome,email")->paginate(1)->get(),
                "title" => "Listando Usuários",
                "links" => $this->users->links()
            ]
        );

    }


    /**
     * Exibe o formulário de criação de usuário
     * Método de requisição: GET
     */
    public function create(){
        
       $this->view("cadastro");

   }

    /**
     * Processa o formulário de criação de usuário
     * Método de requisição: POST
     */
   public function store(){


       $validate = new Validate();
       $data = $validate->validate([
           "nome"     => "required:max@30",
           "email"    => "required:email:unique@user",
           "telefone" => "required"
       ]);

       if($validate->hasErros()){
           foreach($data as $field => $value){
               flash("post_".$field,$data[$field]);
           }
           back();
           exit;
       }

       $this->users->create($data);

       if(empty($this->users->getErros())){
           flash("message",success("Dados cadastrados com sucesso."));
           Redirect::redirect("/");
           exit;
       }else{
           flash("message",error("<span class='font-weight-bold'>Falha ao cadastrar</span>: ". $user->getErros()));
           Redirect::redirect("/users/create");
           exit;
       }


   }

    /**
     * Exibe o formulário de edição de usuário
     * Método de requisição: GET
     */
    public function edit($request,$response,$args)
    {
        $user = (array) $this->users->select()->where("id",$args["id"])->first();

        foreach($user as $field => $value){
            flash("post_".$field,$user[$field]);
        }

        $this->view("editar");
    }


    /**
     * Processa o formulário de edição de usuário
     * Método de requisição: POST
     */
    public function update($request,$response,$args)
    {

        $validate = new Validate();
        $data = $validate->validate([
            "nome"     => "required:max@20",
            "email"    => "required:email",
            "telefone" => "required"
        ]);

        if($validate->hasErros()){
            foreach($data as $field => $value){
                flash("post_".$field,$data[$field]);
            }
            back();
            exit;
        }

        $this->users->find("id",$args["id"])->update($data);


        if(empty($this->users->getErros())){
            flash("message",success("Dados atualizados com sucesso."));
            Redirect::redirect("/");
            exit;
        }else{
            flash("message",error("<span class='font-weight-bold'>Falha ao atualizar</span>: ". $this->users->getErros()));
            Redirect::redirect("/users/edit/{$args["id"]}");
            exit;
        }
    }


    /**
     * Remove um usuário
     * Método de requisição: POST
     */
    public function delete($request,$response,$args)
    {
       $deleted = $this->users->find("id",$args["id"])->delete();
       if($deleted){
           flash("message",success("Dados removidos com sucesso."));
       }else{
           flash("message",error("Falha ao deletar dados."));
       }
        Redirect::redirect("/");
        exit;
    }

}