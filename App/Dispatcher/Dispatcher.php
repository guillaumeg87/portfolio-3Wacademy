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

        if($controller && method_exists($controller, $this->request->action)) {

            call_user_func_array([$controller, $this->request->action], $this->request->params);
        }
        else {
            header_remove();
            header('Location: /front/index/page404');
        }
    }

    /**
     * @return bool
     */
    public function loadController()
    {

        $name = str_replace('/', '\\', $this->request->path) . ucfirst($this->request->controller . "Controller");
        $filePath = '../' . $this->request->path . $this->request->controller. 'Controller.php';

        if (\file_exists($filePath)){
            return new $name();
        }
        else{
            return false;
        }
    }
}
