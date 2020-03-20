<?php
class Model
{
    public $string;
    public $scripts;
    public $logged;
    public $styles;

    public function __construct()
    {
        $this->string = "main.html";
        $this->scripts = array();
        $this->styles = array();
        $this->title = "";
        $this->addCss('general.css');
        $this->addJs('general.js');
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

}

function getConnection()
{

}
