<?php

namespace App\Controller\Admin;

use App\Model\Categories;
use App\Model\User;
use Core\Controller;
use Core\Image;
use Core\Redirect;
use Core\Validate;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Post;

class PostController extends Controller {
	/**
	 * Página Inicial
	 */
	public function index() {

	    $posts = new Post();

		$this->view("admin/post/index", [
		    "template_admin" => $this->templateAdmin,
            "posts" => $posts->list(),
            "links" => $posts->links()
            ]);

	}

	/**
	 * Exibe o formulário de criação
	 */
	public function create() {

	    $categories = new Categories();
	    $categories = $categories->getAll();

		$this->view("admin/post/create",
            [
		        "template_admin" => $this->templateAdmin,
                "categories" => $categories
            ]);
	}

	/**
	 * Processa Formulário de criação
	 */
	public function store(Request $request, Response $response) {


        $validate = new Validate($_POST);
        $data = $validate->validate([
            "title" => "required",
            "content" => "required",
            "category_id" => "required"
        ]);
        if($validate->hasErros()){
            foreach($data as $field => $value){
                flash("post_".$field,$data[$field]);
            }
            back();
        }

        $post = new Post;
        $image = new Image("thumbnail");
        $data["thumbnail"] = $image->size("capa")->upload();
        $data["user_id"] = (new User)->user()->id;
        $post->create($data);
        if($post->lastCreated > 0){
            flash("name",success("Cadastrado com sucesso"));
            Redirect::redirect("/painel/admin/posts");
        }
	}

	/**
	 * Exibe dado do Banco de dados
	 */
	public function show($id) {
		echo 'show';
	}

	/**
	 * Exibe o formulário de edição
	 */
	public function edit(Request $request, Response $response, $args) {

	    $bodyRequest = $request->getParsedBody();
        $categories = new Categories();
        $categories = $categories->getAll();

        $post = new Post();
        $post = $post->select()->where2(["id","=",$args["id"]])->first();

        if(!is_null($bodyRequest)){
            $post = get_object_vars($post);
            foreach ($post as $key => $value){
                if(!key_exists($key,$bodyRequest)){
                    $bodyRequest[$key] = $value;
                }
            }
        }

        $this->view("admin/post/edit",
            [
                "template_admin" => $this->templateAdmin,
                "categories" => $categories,
                "post" => (is_null($bodyRequest)) ? $post : $bodyRequest
            ]);
	}

	/**
	 * Processa o formulário de edição
	 */
	public function update(Request $request, Response $response, $args) {
        $validate = new Validate($request->getParsedBody());
        $data = $validate->validate([
            "title" => "required",
            "content" => "required",
            "category_id" => "required"
        ]);
        if($validate->hasErros()){
          $this->edit($request,$response,$args);
          exit;
        }

        $post = new Post;
        if(!$_FILES["thumbnail"]["error"]){
            $image = new Image("thumbnail");
            $data["thumbnail"] = $image->size("capa")->upload();
        }
        $data["user_id"] = (new User)->user()->id;
        $result = $post->update2($data)->where2(["id","=", $args["id"]])->exec();
        if($result){
            Redirect::redirect("/painel/admin/posts");
        }

	}

	/**
	 * Remove dados do Banco
	 */
	public function destroy(Request $request, Response $response, $args) {
        $post = new Post;
        $post->delete2()->where2(["id","=",$args["id"]])->exec();

        return Redirect::redirect("/painel/admin/posts");
	}

}