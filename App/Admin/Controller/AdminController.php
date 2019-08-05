<?php

namespace Admin\Controller;

use Admin\Core\Config\AbstractController;

class AdminController extends AbstractController
{
    public function index($options = [])
    {

        $this->render(__NAMESPACE__, "admin_login", $options);
    }
}