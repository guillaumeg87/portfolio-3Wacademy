<?php

namespace App\Dispatcher;

use Router\Request;
use Router\Router;

class Dispatcher
{
    private $request;

    /**
     *
     */
    public function dispatch()
    {
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);
        $controller = $this->loadController();
        call_user_func_array([$controller, $this->request->action], $this->request->params);
    }

    /**
     * @return mixed
     */
    public function loadController()
    {

        $name = str_replace('/', '\\', $this->request->path) . ucfirst($this->request->controller . "Controller");
        $controller = new $name();

        return $controller;
    }

    /**
     * @param $file string
     * @return string
     */
    private function getNamespace($file)
    {
        $path = explode('/App', str_replace('.php', '', $file));
        $namespace = str_replace('/', '\\', $path);
        return $namespace[1];
    }
}