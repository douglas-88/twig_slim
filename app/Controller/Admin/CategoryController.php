<?php

namespace App\Controller\Admin;

use Core\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Category;
use Core\Validate;
use Core\Redirect;

class CategoryController extends Controller {
	/**
	 * Página Inicial
	 */
	public function index() {

	    $category = new Category;
	    $categories = $category->select()->busca("name")->paginate(3)->get();
		$this->view("admin/categories/index", [
		    "template_admin" => $this->templateAdmin,
            "categories" => $categories,
            "links" => $category->links()
        ]);

	}

	/**
	 * Exibe o formulário de criação
	 */
	public function create() {
		$this->view("admin/categories/create", ["template_admin" => $this->templateAdmin]);
	}

	/**
	 * Processa Formulário de criação
	 */
	public function store(Request $request, Response $response) {
		//$data = filter_input_array(($_SERVER['REQUEST_METHOD'] == "POST") ? INPUT_POST : INPUT_GET, FILTER_SANITIZE_STRING);
		$validate = new Validate();
        $data = $validate->validate([
            "name" => "required"
        ]);

        if($validate->hasErros()){
            foreach($data as $field => $value){
                flash("post_".$field,$data[$field]);
            }
            back();
        }
   
		$category = new Category;
        $category->create($data);
        if($category->lastCreated > 0){
            flash("name",success("Cadastrado com sucesso"));
            Redirect::redirect("/painel/admin/category");
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
        $category = new Category;
        $category = $category->select()->where2(["id","=",$args["id"]])->first();
        return $response->write($this->view("admin/categories/edit", [
                            "template_admin" => $this->templateAdmin,
                            "category" => $category
                        ]));

    }

	/**
	 * Processa o formulário de edição
	 */
	public function update(Request $request, Response $response, $args) {

        $validate = new Validate();
        $data = $validate->validate([
            "name" => "required"
        ]);



        if($validate->hasErros()){
            foreach($data as $field => $value){
                flash("post_".$field,$data[$field]);
            }
            back();
        }

        $category = new Category;
        $category->update2(["name" => $data["name"]])->where2(["id","=",$args["id"]])->exec();
        return Redirect::redirect("/painel/admin/category");
	}

	/**
	 * Remove dados do Banco
	 */
	public function destroy(Request $request, Response $response, $args) {
		$category = new Category();
		$category->delete2()->where2(["id","=",$args["id"]])->exec();

        return Redirect::redirect("/painel/admin/category");
	}

}