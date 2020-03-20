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
        switch ($this->model->string) {
            default:
                return file_get_contents("./templates/" . $this->model->string)
                break;
        }
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

}
