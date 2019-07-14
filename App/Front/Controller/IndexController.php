<?php

namespace Front\Controller;

use Admin\Core\AbstractController;

/**
 * Class IndexController
 * @package Front\Controller
 */
class IndexController extends AbstractController
{
    public function index(){
        var_dump('index front');
        var_dump('bordel l\'autoload marche!!!!!');
        $this->render("home");
    }
}