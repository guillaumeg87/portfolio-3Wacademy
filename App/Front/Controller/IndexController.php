<?php

namespace Front\Controller;

use Admin\Core\Config\AbstractController;

/**
 * Class IndexController
 * @package Front\Controller
 */
class IndexController extends AbstractController
{
    public function index(){

        $this->render(__NAMESPACE__, 'index');
    }
}
