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
		$this->model->string = "main.html";
		$this->model->addCss('main.css');
		$this->model->title = "Página principal";
		$this->model->addVisita('principal');
	}

}
