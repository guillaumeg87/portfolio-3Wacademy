<?php

namespace App\Dispatcher;

use Router\Request;
use Router\Router;
use Router\RoutesConstants;
use Services\LogManager\LogConstants;
use Services\LogManager\LogManager;


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

        $redirectUrl = $_SERVER['REDIRECT_URL'];
        if (isset($mainPath[0]) && !empty(RoutesConstants::ROUTE_MAP[$mainPath[0]])) {

            $this->request->url = (isset($mainPath[1]) && !empty($mainPath[1])) ? RoutesConstants::ROUTE_MAP[$mainPath[0]] . '?' . $mainPath[1] : RoutesConstants::ROUTE_MAP[$mainPath[0]];
        }
        else {

            $this->logBadRequest($redirectUrl);

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
            $this->logBadRequest($redirectUrl);

            header_remove();
            header('Location: /404');
            return;
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

    /**
     * Logging bad request
     * @param string $redirectUrl
     */
    private function logBadRequest(string $redirectUrl){
        (new LogManager())->log(
            '[ 404 ] Bad request with this param :  ' . $redirectUrl .  PHP_EOL,
            LogConstants::ERROR_APP_LABEL,
            LogConstants::WARN_LABEL);
    }
}
