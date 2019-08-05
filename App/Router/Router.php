<?php

namespace Router;

use Admin\Core\Install\Builder\DatabaseBuilder;

class Router
{
    const ADMIN_PATH = "Admin/Controller/";
    const FRONT_PATH = "Front/Controller/";
    const MATCH_ADMIN_OR_INSTALL = '/(?:admin|install)/';


    static public function parse($url, $request)
    {
        $explode_url = explode('/', trim($url));
        if (preg_match(self::MATCH_ADMIN_OR_INSTALL, $explode_url[1])) {
            /** $explode_url[1] define the controller */
            $request->controller = $explode_url[1];
            /** $explode_url[1] define the action, call the method */
            $request->action = ($explode_url[2] === null)? 'index' : $explode_url[2];
            $request->path = self::ADMIN_PATH;
            $request->params = [];

        }
        elseif(!file_exists(DatabaseBuilder::FILE_DB_CONF)) {
            $request->controller = "install";
            $request->action = 'indexForm';
            $request->path = self::ADMIN_PATH;
            $request->params = [];
        }
        else {

            $explode_url = array_slice($explode_url, 2);

            $request->action = $explode_url[1];
            $request->path = self::FRONT_PATH;

            if (null === $explode_url[0]){
                $explode_url[0] = 'index';
                $request->action = 'index';
            }
            $request->controller = ucfirst($explode_url[0]);
            $request->params = array_slice($explode_url, 2);
        }
    }

}
