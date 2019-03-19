<?php

namespace Admin\Controller;

use App\Admin\Core\Render\Render;

class LoginController
{

    public function loginAdmin(){

        $view = new Render();
        echo $view->render("App/Admin/Resources/views/admin_login.phtml");
        //require("App/Admin/Resources/views/admin_login.phtml");
    }
}