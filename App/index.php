<?php

use App\Autoload;


define('WEBROOT', str_replace("web/index.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT', str_replace("web/index.php", "", $_SERVER["SCRIPT_FILENAME"]));

 //var_dump(ROOT); //=> /var/www/html/portfolio-3Wacademy/App/

require_once('../Autoload.php');
Autoload::register();

require(ROOT . 'Admin/Core/Config/Config.php');
require(ROOT . 'Router/Router.php');
require(ROOT . 'Router/Request.php');
require(ROOT . 'Dispatcher/Dispatcher.php');
$dispatch = new App\Dispatcher\Dispatcher();
$dispatch->dispatch();
?>