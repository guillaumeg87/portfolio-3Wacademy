<?php

namespace Router;

use Admin\Controller\LoginController;
use App\Admin\Core\DatabaseBuilder;
use App\Admin\Core\InstallController;

class Router
{
    /**
     * @param bool $private
     */
    public function path($private = false)
    {
        $path = $_SERVER['REQUEST_URI'];

        if(!empty($_POST['private'])){
            $private = $_POST['private'];
        }

        if($private){
            $this->privatePath($path);
        }
        else{
            $this->publicPath($path);
        }
    }

    private function publicPath($path){

        switch ($path){
            case '/':
                // Add Controller
                require 'App/Front/Resources/views/main_layout.phtml';
                break;

            case '/admin/login':

                $controller = new LoginController();
                return $controller->loginAdmin();
                break;

            case '/admin/login/check':

                $controller = new LoginController();
                return $controller->loginAdmin();
                break;

            default:
                // Add Controller

                require 'App/Front/Resources/views/404.phtml';
                break;
        }
    }

    private function privatePath($path){

        switch ($path){
            case '/':
            case '/install/project':

                $install = new InstallController();
                $install->installProject();
                break;

            case '/install/check-install':

                $controller = new DatabaseBuilder();
                $controller->form();
                break;

            default:
                // Add Controller

                require 'App/Front/Resources/views/404.phtml';
                break;
        }
    }
}
