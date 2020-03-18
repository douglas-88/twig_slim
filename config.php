<?php

return [
	"login" => [
		"admin" => [
			"loggedIn" => "admin",
			"redirect" => "/painel/admin",
			"idLoggedIn" => "id_admin",
		],
		"user" => [
			"loggedIn" => "professor",
			"redirect" => "/painel/professor",
			"idLoggedIn" => "id_professor",
		],
	],

	"permission" => [
		1 => "/painel/admin",
		2 => "/painel/professor",
		3 => "/painel/cliente",
	],
];