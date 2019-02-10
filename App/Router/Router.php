<?php

namespace Router;

class Router
{
    public function path($path)
    {
        switch ($path){
            case 'admin/login':

                return "App/Admin/Resources/views/admin_login.phtml";
        }
    }
}
