<?php
namespace App\Admin\Core;
use App\Admin\Core\Traits\Hash;
use App\Connection\DB_conf;
use Connection\Db_manager;
use PDO;
use PDOException;
use Router\Router;

class DatabaseBuilder
{
    use Hash;

    const DB_INSTALL = ['DB_NAME', 'HOST', 'ADMIN', 'PWD'];
    const FILE_DB_CONF = 'App/Connection/DB_conf.php';
    const FILE_START = '<?php 
namespace App\Connection;

final class DB_conf
{
';
    const FILE_END = '
}
';

    /**
     *
     */
    public function form()
    {
        include('App/Admin/Core/Resources/Views/installation_form.phtml');
        if (!empty($_POST)) {
            $data = [];

            foreach ($_POST as $key => $value) {
                if ($key != 'private') {
                    $data[strtoupper($key)] = $value;
                }
                if ($key == 'login' || $key == 'pwd') {
                    $admin[$key] = $this->hashString($value);

                }
            }

            // Delete Admin acces before Write database config in file
            foreach ($admin as $key => $value){
                unset($data[strtoupper($key)]);
            }

            $this->init_param($data, $admin);
        }

    }

    /**
     * Init params database buildings
     * Create Class DB_conf.php
     *
     */
    public function init_param($param, $admin)
    {

        if (!file_exists(self::FILE_DB_CONF)) {

            $array_const = array_combine(self::DB_INSTALL, $param);

            foreach ($array_const as $key => $value) {

                $config_file[] = "const " . $key . " = '" . $value . "';\r\n";

            }

            //echo '<pre>' , var_dump($config_file) , '</pre>';

            $path_to_wp_config = self::FILE_DB_CONF;
            $handle = fopen($path_to_wp_config, 'w');
            fwrite($handle, self::FILE_START);
            foreach ($config_file as $key => $value) {

                fwrite($handle, $value);
            }
            fwrite($handle, self::FILE_END);

            fclose($handle);
            chmod($path_to_wp_config, 0666);
            return $this->prepareBuild($admin);
        }
    }

    /**
     *
     */
    public function prepareBuild($admin)
    {
        $count = 0;
        do {
            $count++;
        } while (!file_exists(self::FILE_DB_CONF));

        if (file_exists(self::FILE_DB_CONF)) {
            return $this->builder(new DB_conf(), $admin);
        }
    }

    /**
     * Création de la base de donnée
     * @param DB_conf $conf
     */
    private function builder(DB_conf $conf, $admin)
    {
// Create connection
        try {
            $connection = new \PDO("mysql:host=" . $conf::HOST, $conf::ADMIN, $conf::PWD);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE IF NOT EXISTS " . $conf::DB_NAME;
            $connection->exec($sql);
            $sql = "use " . $conf::DB_NAME;
            $connection->exec($sql);
            $sql = "CREATE TABLE IF NOT EXISTS user ( id int(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL)";
            $connection->exec($sql);
            $this->saveAdmin($connection, $admin, $conf);
            //echo "DB created successfully";
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }


        /* @TODO : une fois la base créée rediriger vers l'accueil ou la page de login admin */
       $_SERVER['REQUEST_URI'] = '/admin/login';
       $_GET['info_db'] = "DB created successfully";
       $router = new Router();
       $_POST['private'] = false;
       return $router->path(false);

    }

    /**
     * @param $connection
     * @param $admin
     * @param $conf
     */
    public function saveAdmin($connection, $admin, $conf){
        //@TODO: A FINIR -> Insersion Admin dans BDD
        try{
            $sql = "INSERT INTO user (login, password) VALUES (:login,:pwd)";
            $query = $connection -> prepare($sql);
            $response = $query -> execute([
                'login' => $admin['login'],
                'pwd'   => $admin['pwd']
            ]);
        }catch (PDOException $e){
            echo $sql . "<br>" . $e->getMessage();

        }
    }
}