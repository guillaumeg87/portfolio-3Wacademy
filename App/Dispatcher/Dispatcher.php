<?php

namespace App\Dispatcher;

use Router\Request;
use Router\Router;
use Router\RoutesConstants;



class Dispatcher
{
    private $request;

    /**
     *
     */
    public function dispatch()
    {
        $this->request = new Request();
        $mainPath = explode('?', $this->request->url);

        if (!empty(RoutesConstants::ROUTE_MAP[$mainPath[0]])) {

            $this->request->url = (isset($mainPath[1]) && !empty($mainPath[1])) ? RoutesConstants::ROUTE_MAP[$mainPath[0]] . '?' . $mainPath[1] : RoutesConstants::ROUTE_MAP[$mainPath[0]];
        }
        else {
            header_remove();
            header('Location: /404');
            return;
        }

        Router::parse($this->request->url, $this->request);
        $controller = $this->loadController();

        if($controller && method_exists($controller, $this->request->action)) {

            call_user_func_array([$controller, $this->request->action], $this->request->params);
        }
        else {
            header_remove();
            header('Location: /404');
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
