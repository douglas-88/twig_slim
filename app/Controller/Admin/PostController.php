<?php

namespace App\Controller\Admin;

use Core\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class PostController extends Controller {
	/**
	 * Página Inicial
	 */
	public function index() {

		$this->view("admin/post/index", ["template_admin" => $this->templateAdmin]);

	}

	/**
	 * Exibe o formulário de criação
	 */
	public function create() {
		$this->view("admin/post/create", ["template_admin" => $this->templateAdmin]);
	}

	/**
	 * Processa Formulário de criação
	 */
	public function store(Request $request, Response $response) {
		echo 'store';
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
	public function edit($id) {
		echo 'edit';
	}

	/**
	 * Processa o formulário de edição
	 */
	public function update(Request $request, Response $response, $args) {
		echo 'update';
	}

	/**
	 * Remove dados do Banco
	 */
	public function destroy($id) {
		echo 'destroy';
	}

}