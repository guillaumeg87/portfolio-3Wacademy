<?php
require_once 'App/Autoload.php';
App\Autoload::register();

use Router\Router;
use App\Admin\Core\DatabaseBuilder ;

$router = new Router();
$private = false;
if(!file_exists(DatabaseBuilder::FILE_DB_CONF)) {
    $private = true;
}
$router->path($private);
    //include('App/Front/Resources/views/main_layout.phtml');

?>