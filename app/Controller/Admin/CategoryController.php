<?php

namespace App\Controller\Admin;

use Core\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Categories;
use Core\Validate;
use Core\Redirect;

class CategoryController extends Controller {
	/**
	 * Página Inicial
	 */
	public function index() {

	    $category = new Categories;
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
		$validate = new Validate($_POST);
        $data = $validate->validate([
            "name" => "required"
        ]);

        if($validate->hasErros()){
            return $this->view("admin/categories/create", ["template_admin" => $this->templateAdmin,"post" => $_POST]);
        }
   
		$category = new Categories;
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
        $category = new Categories;
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

        $validate = new Validate($_POST);
        $data = $validate->validate([
            "name" => "required"
        ]);

        $category = new Categories;

        if($validate->hasErros()){


            $category = $category->select()->where2(["id","=",$args["id"]])->first();
            return $response->write($this->view("admin/categories/edit", [
                "template_admin" => $this->templateAdmin,
                "category" => $category,
                "post" => $_POST
            ]));

        }
            $category->update2(["name" => $data["name"]])->where2(["id","=",$args["id"]])->exec();
            return Redirect::redirect("/painel/admin/category");
	}

	/**
	 * Remove dados do Banco
	 */
	public function destroy(Request $request, Response $response, $args) {
		$category = new Categories();
		$category->delete2()->where2(["id","=",$args["id"]])->exec();

        return Redirect::redirect("/painel/admin/category");
	}

}