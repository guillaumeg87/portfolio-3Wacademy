<?php

use App\Autoload;
//error_reporting(E_ALL);
define('WEBROOT', str_replace("web/index.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT', str_replace("web/index.php", "", $_SERVER["SCRIPT_FILENAME"]));
require_once ('../Autoload.php');
Autoload::register();

require(ROOT . 'Admin/Core/Config/Config.php');
require(ROOT . 'Router/Router.php');
require(ROOT . 'Router/Request.php');
require(ROOT . 'Dispatcher/Dispatcher.php');
$dispatch = new App\Dispatcher\Dispatcher();
$dispatch->dispatch();
