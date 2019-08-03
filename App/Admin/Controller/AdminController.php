<?php

namespace Admin\Controller;

use Admin\Core\AbstractController;

class AdminController extends AbstractController
{
    public function index()
    {
        $this->render(__NAMESPACE__, "admin_login");
    }
}