<?php

namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Core\Traits\NavigationTrait;

class AdminController extends AbstractController
{
    use NavigationTrait;
    //TEMPLATE
    const ADMIN_LOGIN_FORM = 'admin_login';
    const ADMIN_HOME= 'admin_home';

    public function index($options = [])
    {
        if(empty($_SESSION)) {
            $this->render(__NAMESPACE__, self::ADMIN_LOGIN_FORM, $options);
        }
    }

    public function home($options = [])
    {
        if(empty($_SESSION)) {
            $this->render(__NAMESPACE__, self::ADMIN_HOME, $options);
        }
    }

}
