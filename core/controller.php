<?php

class Controller
{
	private $model;

	public function __construct($model)
	{
		$this->model = $model;
	}

	public function main()
	{
		$this->model->getUsers();
		$this->model->string = "main.html";
		$this->model->title = "Página principal";
	}

}
