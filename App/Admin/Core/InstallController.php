<?php
/**
 * Created by PhpStorm.
 * User: gge
 * Date: 14/03/2019
 * Time: 22:00
 */

namespace App\Admin\Core;


use App\Admin\Core\Render\Render;

class InstallController
{
    public function installProject(){
        $view = new Render();
        echo $view->render("App/Admin/Core/Resources/views/installation_form.phtml");
        //require("App/Admin/Core/Resources/views/installation_form.phtml");
    }
}