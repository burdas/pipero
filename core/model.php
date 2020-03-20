<?php
class Model
{
    public $string;
    public $scripts;
    public $logged;
    public $styles;

    private $BD

    public function __construct()
    {
        $this->string = "main.html";
        $this->scripts = array();
        $this->styles = array();
        $this->title = "";
        $this->$BD = NULL
    }

    public function addCss($fileName)
    {
        if (sizeof($this->styles) == 2) {
            array_pop($this->styles);
        }
        array_push($this->styles, $fileName);
    }

    public function addJs($fileName)
    {
        if (sizeof($this->scripts) == 2) {
            array_pop($this->scripts);
        }
        array_push($this->scripts, $fileName);
    }

    function getConnection()
    {
        $this->$BD = new SQLite3('/../BD.db');
    }

    public function getUsers(){
        if (!is_null($this->$BD)) {
            $sentencia = $bd->prepare('SELECT * FROM Usuarios');
            $resultado = $this->$sentencia->execute();
            echo var_dump($resultado->fetchArray());
        }
    }
}
