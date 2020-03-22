<?php
class Model
{
    public $string;
    public $scripts;
    public $logged;
    public $styles;
    public $alerta;

    public function __construct()
    {
        $this->string = "login.html";
        $this->scripts = array();
        $this->styles = array();
        $this->title = "";
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

    private function getConnection()
    {
        return new SQLite3("./BD.db");
    }

    private function bdToArray($datos){
        $salida = array();
        while ($fila = $datos->fetchArray()) {
            array_push($salida, $fila);
        }
        return $salida;
    }

    public function getUsers(){
        $bd = $this->getConnection();
        if (is_null($bd)) {
            return;
        }
        $sentencia = $bd->prepare("SELECT Nombre FROM Usuarios ORDER BY Nombre");
        $resultado = $this->bdToArray($sentencia->execute());
        $bd->close();
        return $resultado;
    }

    public function verifyUser($nombre, $contrasena){
        $bd = $this->getConnection();
        if (is_null($bd)) {
            return;
        }
        $sentencia = $bd->prepare("SELECT Contrasena FROM Usuarios WHERE Nombre = :nombre");
        $sentencia->bindValue(':nombre', $nombre, SQLITE3_TEXT);
        $resultado = $sentencia->execute();
        $bdPass = $resultado->fetchArray();
        $salida = password_verify($contrasena ,$bdPass['Contrasena']);
        $bd->close();
        return $salida;
    }

    public function changePass($nombre, $contrasena){
        $bd = $this->getConnection();
        if (is_null($bd)) {
            return;
        }
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sentencia = $bd->prepare("UPDATE Usuarios SET Contrasena = :contrasena WHERE Nombre = :nombre");
        $sentencia->bindValue(':contrasena', $hash, SQLITE3_TEXT);
        $sentencia->bindValue(':nombre', $nombre, SQLITE3_TEXT);
        $resultado = $sentencia->execute();
        $salida = $resultado->numColumns();
        $bd->close();
        return $salida;
    }

    public function getPermisos($nombre){
        $bd = $this->getConnection();
        if (is_null($bd)) {
            return;
        }
        $sentencia = $bd->prepare("SELECT Permisos FROM Usuarios WHERE Nombre = :nombre");
        $sentencia->bindValue(':nombre', $nombre, SQLITE3_TEXT);
        $resultado = $sentencia->execute()->fetchArray()['Permisos'];
        $bd->close();
        return $resultado;
    }
}
