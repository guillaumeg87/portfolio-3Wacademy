<?php

namespace Front\Controller;

class IndexController
{
    public function indexFront(){
        //return 'App/Front/Resources/views/home.phtml';
        return "App/Admin/Resources/views/admin_login.phtml";

    }

    /**
     *
     */
    public function headerFront(){
        return ['header' => 'Hello header depuis controller'];
    }

    /**
     *
     */
    public function footerFront(){
        return ['footer' => 'Hello footer depuis controller'];
    }
}