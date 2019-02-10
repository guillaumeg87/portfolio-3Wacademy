<h1>Debut portfolio</h1>
<?php
require_once 'App/Autoload.php';
use Connection\Db_manager;
use Router\Router;
use App\Connection\DB_param as DB;
App\Autoload::register();

/**
 * Creer une commande de création de la base de donnée avec les datas en options
 * => faire un fichier de constante pour garder ça
 * => mais ne pas commiter le fichier
 */
$p = new Db_manager(DB::HOST, DB::DB_NAME, DB::ADMIN, DB::PWD);
// $p->connection();
$rooter = new Router();
?>
<a href="<?= $rooter->path('admin/login') ?>">Admin Login</a>
