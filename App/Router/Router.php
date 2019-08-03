<?php

namespace Router;

class Router
{
    const ADMIN_PATH = "Admin/Controller/";
    const FRONT_PATH = "Front/Controller/";
    const MATCH_ADMIN = '/[admin::(.*?)]/';

    static public function parse($url, $request)
    {
        $explode_url = explode('/', trim($url));
        if (preg_match(self::MATCH_ADMIN, $explode_url[1])) {
            $request->controller = "admin";
            $request->action = ($explode_url[1] === 'admin')? 'index' : $explode_url[1];
            $request->path = self::ADMIN_PATH;
            //$request->action = array_slice(explode('/', $url),2);
            $request->params = [];

        } else {
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
