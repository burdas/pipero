<?php
class View
{
    private $model;
    private $controller;

    public function __construct($controller, $model)
    {
        $this->controller = $controller;
        $this->model = $model;
    }

    public function output()
    {
        $salida = '';
        switch ($this->model->string) {
            case 'login.html':
                if (isset($_GET['alerta'])) {
                    $salida .= $this->alerta('Los datos introducidos no son correctos.', 'danger');
                }
                $html = file_get_contents("./templates/" . $this->model->string);
                $html = str_replace("{{USUARIOS}}", $this->montarOpcionesUsuarios(), $html);
                $salida .= $html;
                break;
            case 'menu.html':
                if (isset($_GET['alerta'])) {
                    if (strcmp($_GET['alerta'], 'siCambio')) {
                        $salida .= $this->alerta('La contraseña se ha cambiado correctamente.', 'success');
                    } else {
                        $salida .= $this->alerta('Ha ocurrido un error al cambiar las contraseña.', 'danger');
                    }
                    
                }
                $html = file_get_contents("./templates/" . $this->model->string);
                $html = str_replace("{{NOMBRE}}", $_COOKIE['usuario'], $html);
                $salida .= $html;
                break;
            case 'cambiarContrasena.html':
                if (isset($_GET['alerta'])) {
                    $salida .= $this->alerta('Las contraseñas no coinciden.', 'danger');
                }
                $salida .= file_get_contents("./templates/" . $this->model->string);
                break;
            default:
                $salida = file_get_contents("./templates/" . $this->model->string);
                break;
        }
        return $salida;
    }

    public function getTitle()
    {
        return '<title>' . 'Pipero - ' . $this->model->title . ' </title>' . PHP_EOL;
    }

    public function getScripts()
    {
        if (empty($this->model->scripts)) return '';
        $htmlScripts = '';
        $rowModel = '<script src="./js/##SCRIPT##"></script>';
        foreach ($this->model->scripts as $value) {
            $htmlScripts .= str_replace('##SCRIPT##', $value, $rowModel) . PHP_EOL;
        }
        return $htmlScripts . PHP_EOL;
    }

    public function getStyles()
    {
        if (empty($this->model->styles)) return '';
        $htmlStyles = '';
        $rowModel = '<link rel="stylesheet" href="./css/##STYLES##">';
        foreach ($this->model->styles as $value) {
            $htmlStyles .= str_replace('##STYLES##', $value, $rowModel) . PHP_EOL;
        }
        return $htmlStyles . PHP_EOL;
    }

    private function addNavbar()
    {
        return file_get_contents("./templates/navbar.html") . PHP_EOL;
    }

    private function addFooter()
    {
        return PHP_EOL . file_get_contents("./templates/footer.html");
    }

    private function montarOpcionesUsuarios(){
        $salida = "";
        $plantilla = '<option value="{{nombre}}"></option>';
        $usuarios = $this->model->getUsers();
        foreach ($usuarios as $fila) {
            $salida .= str_replace("{{nombre}}", $fila["Nombre"], $plantilla);
        }
        return $salida;
    }

    private function alerta($mensaje, $tipo){
        $plantilla = '<div class="text-center alert alert-{{TIPO}}" role="alert">{{MENSAJE}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button></div>';
        $salida = str_replace('{{TIPO}}', $tipo, $plantilla);
        $salida = str_replace('{{MENSAJE}}', $mensaje, $salida);
        return $salida;
    }
}
