<?php

class Controller
{
	private $model;

	public function __construct($model)
	{
		$this->model = $model;
	}

	public function main(){
		echo "Llega";
		if (isset($_COOKIE['usuario'])) {
			header('Location: ./?action=menu');
		} else {
			header('Location: ./?action=login');
		}
	}

	public function login()
	{
		if (isset($_COOKIE['usuario'])) {
			header('Location: ?action=menu');
			return;
		}
		$this->model->string = "login.html";
		$this->model->title = "Login";
		$this->model->addCss("login.css");
	}

	public function logout()
	{
		if (!isset($_COOKIE['usuario'])) {
			header('Location: ?action=accesoIndebido');
			return;
		}
		setcookie("usuario", "", time() - 3600);
		header('Location:  ?action=login');
	}

	public function menu(){
		if (!isset($_COOKIE['usuario'])) {
			header('Location: ?action=accesoIndebido');
			return;
		}
		$this->model->string = "menu.html";
		$this->model->title = "Menu";
		$this->model->addCss('menu.css');
	}

	public function verifyUser(){
		if (isset($_POST['Nombre']) and isset($_POST['Contrasena'])) {
			if ($this->model->verifyUser($_POST['Nombre'], $_POST['Contrasena'])) {
				setcookie('usuario', $_POST['Nombre'], time() + (10 * 365 * 24 * 60 * 30)); // Para dentro de 10 años
				header('Location: ?action=menu');
			} else {
				header('Location: ?action=login&alerta=si');
			}
		} else {
			header('Location: ?action=accesoIndebido');
		}
		die;
	}

	public function cambiarContrasena(){
		if (!isset($_COOKIE['usuario'])) {
			header('Location: ?action=accesoIndebido');
			return;
		}

		$this->model->string = "cambiarContrasena.html";
		$this->model->title = "Cambiar contraseña";
		$this->model->addCss('cambiarContrasena.css');
	}

	public function verifyCambioContrasena(){
		if (!isset($_COOKIE['usuario'])) {
			header('Location: ?action=accesoIndebido');
			return;
		}
		if (isset($_POST['Contrasena1']) and isset($_POST['Contrasena2'])) {
			if (strcmp($_POST['Contrasena1'], $_POST['Contrasena2']) == 0){
				if ($this->model->changePass($_COOKIE['usuario'], $_POST['Contrasena1'])) {
					header('Location: ?action=menu&alerta=siCambio');
				} else {
					header('Location: ?action=menu&alerta=noCambio');
				}
			} else {
				header('Location: ?action=cambiarContrasena&alerta=si');
			}
		} else {
			header('Location: ?action=accesoIndebido');
		}
	}

	public function accesoIndebido()
	{
		$this->model->string = "accesoIndebido.html";
		$this->model->title = "Acceso indebido";
		$this->model->addCss('accesoIndebido.css');
	}

	public function prueba(){
		if (isset($_COOKIE['usuario'])){
			echo $this->model->getPermisos($_COOKIE['usuario']);
		} else {
			echo "no";
		}
		die;
		//phpinfo();
	}

}
