<?php

namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Core\Traits\NavigationTrait;

class AdminController extends AbstractController
{
    use NavigationTrait;
    //TEMPLATE
    const ADMIN_LOGIN_FORM = 'admin_login';

    public function index($options = [])
    {
        if(empty($_SESSION)) {
            $this->render(__NAMESPACE__, self::ADMIN_LOGIN_FORM, $options);
        }
    }

}
