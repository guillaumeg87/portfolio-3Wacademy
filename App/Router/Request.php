<?php

namespace Router;



class Request
{
    /**
     * @var string $url
     */
    public $url;
    public $controller;
    public $action;
    public $path;
    public $params;

    public function __construct()
    {
        $this->url = $_SERVER["REQUEST_URI"];
        $this->controller = null;
        $this->action = null;
        $this->path = null;
        $this->params = [];
    }
}

