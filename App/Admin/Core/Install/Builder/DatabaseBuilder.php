<?php

namespace Admin\Core\Install\Builder;

use Admin\Controller\AdminController;
use Admin\Controller\InstallController;
use Admin\Core\Traits\Hash;
use Connection\Db_conf;
use Connection\Db_manager;
use PDO;
use PDOException;
use Router\Router;
use Services\FlashMessages\FlashMessage;

class DatabaseBuilder
{
    use Hash;

    const DB_INSTALL = ['DB_NAME', 'HOST', 'ADMIN', 'PWD'];
    const FILE_DB_CONF = '../Connection/DB_conf.php';
    const FILE_START = '<?php 
namespace Connection;

final class DB_conf
{
';
    const FILE_END = '
}
';

    /**
     * Get data from Install form
     */
    public function form()
    {
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
            foreach ($admin as $key => $value) {
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
            $config_file = [];

            foreach ($array_const as $key => $value) {

                $config_file[] = "const " . $key . " = '" . $value . "';\r\n";

            }


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
     * @param $admin array
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
     * @param $admin array
     * @return void
     */
    private function builder(DB_conf $conf, $admin)
    {
        $alert = [];
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

            $message = new FlashMessage(
            'ERROR : ' . '</br>' . $sql . '</br>' . $e->getMessage(),
                'error'
            );

            unlink('../Connection/DB_conf.php');
            $retryInstallation = new InstallController();

            return $retryInstallation->indexForm($message->messageBuilder());
        }


        /* @TODO : une fois la base créée rediriger vers l'accueil ou la page de login admin */
        $message = new FlashMessage(
            "DB created successfully",
            'success'
        );

        $admin = new AdminController();
        return $admin->index($message->messageBuilder());


    }

    /**
     * @param $connection
     * @param $admin array
     */
    public function saveAdmin($connection, $admin)
    {
        //@TODO: A FINIR -> Insersion Admin dans BDD
        try {
            $sql = "INSERT INTO user (login, password) VALUES (:login,:pwd)";
            $query = $connection->prepare($sql);
            $response = $query->execute([
                'login' => $admin['login'],
                'pwd' => $admin['pwd']
            ]);
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();

        }
    }
}