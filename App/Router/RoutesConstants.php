<?php


namespace Router;


final class RoutesConstants
{
   const ROUTE_MAP = [
       //FRONT
       '/'                      => '/',
       '/projects'              => '/front/index/projet',
       '/portfolio'             => '/front/index/portfolio',
       '/404'                   => '/front/index/page404',
       '/single-project'        => '/front/index/singleProject',

        //ADMIN
       '/admin/'                => '/admin/admin/home',
       '/admin'                 => '/admin/admin/home',
       '/content/create'        => '/admin/content/create',
       '/content/edit'          => '/admin/content/edit',
       '/content/index'         => '/admin/content/index',
       '/logout'                => '/admin/login/logout',
       '/new-content-type'      => '/admin/formBuilder/index',
       '/login-check'           => '/admin/login/checkLogin',
       '/login-form'            => '/admin/login/login',
       '/admin/home'            => '/admin/admin/home',
       '/admin/settings'        => '/admin/settings',
       '/form/validator'        => '/admin/formBuilder/validator',
       '/content/form'          => '/admin/content/formContent',
       '/content/delete'        => '/admin/content/delete',
       '/installation'          => '/admin/install/startInstall',
       '/delete-content'        => '/admin/settings/delete',
       '/settings/dangerZone'   => '/admin/settings/dangerZone',
       '/logs/clear'            => '/admin/admin/clearLogsDirectory',
       '/admin/logs/download'   => '/admin/admin/downloadLogFile',

       //Ajax Routes
       '/ajax/getSession'       => 'admin/ajax/getSessionID'
   ];
}
