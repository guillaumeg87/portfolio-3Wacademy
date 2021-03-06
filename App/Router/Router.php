<?php

namespace Router;

use Admin\Core\Install\Builder\DatabaseBuilder;

class Router
{
    const ADMIN_PATH = "Admin/Controller/";
    const FRONT_PATH = "Front/Controller/";
    const MATCH_ADMIN_OR_INSTALL = '/(?:admin|install)/';
    const INDEX = 'index';

    // Install
    const INSTALL = 'install';
    const INSTALL_FORM = 'indexForm';


    /**
     * @param $url
     * @param $request
     */
    static public function parse($url, $request)
    {

        $explode_url = explode('/', trim($url));
        if (preg_match(self::MATCH_ADMIN_OR_INSTALL, $explode_url[1])) {

            /** $explode_url[2] define the controller */
            if (!empty($explode_url[2])) {

                $request->controller = ucfirst($explode_url[2]);

            } else {

                $request->controller = ucfirst($explode_url[1]);
            }

            /** $explode_url[1] define the action, call the method */
            $action = ($explode_url[3] === null) ? self::INDEX : $explode_url[3];
            $request->action = explode('?', $action)[0];
            $request->path = self::ADMIN_PATH;
            $request->params[] = (strpos($url, '?') ? self::urlParams($url) : []);

        } elseif (!file_exists(DatabaseBuilder::JSON_FILE_DB_CONF)) {

            $request->controller = self::INSTALL;
            $request->action = self::INSTALL_FORM;
            $request->path = self::ADMIN_PATH;
            $request->params = [];

            header('Location: /admin/install/indexForm');
            header_remove();

        } else {

            $explode_url = array_slice($explode_url, 2);
            $split = null;
            if (isset($explode_url[1]) && preg_match('/[a-z-0-9?&=_]+/', $explode_url[1])){
                $split = isset($explode_url[1]) ? explode('?', $explode_url[1]) : null;
            }

            $request->action = isset($split[0]) ? $split[0] : $split ;
            $request->params[] = (strpos($url, '?') ? self::urlParams($url) : []);

            $request->path = self::FRONT_PATH;

            if (!isset($explode_url[0]) || null === $explode_url[0]) {
                $explode_url[0] = self::INDEX;
                $request->action = self::INDEX;
            }

            $request->controller = ucfirst($explode_url[0]);
        }
    }

    /**
     * Return url's params in array
     * @param $url
     * @return array
     */
    static function urlParams($url)
    {
        $requestParams = [];
        $explodeUrl = explode('?', trim($url));
        $explodeParamsList = explode(',', $explodeUrl[1]);
        $paramsList = explode('&', $explodeParamsList[0]);

        foreach ($paramsList as $item) {
            $param = explode('=', $item);
            $requestParams[$param[0]] = $param[1];
        }

        return $requestParams;
    }
}
