<?php

namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Requests\LoginRequest;
use Connection\Db_manager;
use Services\FlashMessages\FlashMessage;

class AdminController extends AbstractController
{
    //TEMPLATE
    const ADMIN_LOGIN_FORM = 'admin_login';

    public function index($options = [])
    {
        if(empty($_SESSION)) {
            $this->render(__NAMESPACE__, self::ADMIN_LOGIN_FORM, $options);
        }
    }

}