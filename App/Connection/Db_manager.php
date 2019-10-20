<?php

namespace Connection;

use Connection\DB_conf;
use PDO;

class Db_manager
{
    /**
     * @var string $host
     */
    private $host;
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $name
     */
    private $admin;

    /**
     * @var string $name
     */
    private $pwd;

    /**
     * @var PDO $connection
     */
    private $connection;

    /**
     * Db_manager constructor.
     */
    public function __construct($param = []){

        if(empty($param)) {

            $this->host     = DB_conf::DB_HOST;
            $this->name     = DB_conf::DB_NAME;
            $this->admin    = DB_conf::DB_ADMIN;
            $this->pwd      = DB_conf::DB_PASSWORD;
        }
        else {

            $this->host     = $param['Db_host'];
            $this->name     = $param['Db_name'];
            $this->admin    = $param['Db_admin'];
            $this->pwd      = $param['Db_password'];
            $this->connection = $this->connection();
        }

    }

    /**
     * Database Connection
     * @return PDO|null
     */
    public function connection()
    {
        $com_bdd = null;
        try{
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->name;
            $com_bdd = new PDO($dsn, $this->admin, $this->pwd);
            $com_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $com_bdd->exec("SET NAMES UTF8");
        }catch(\Exception $e){
            var_dump('ERROR : ' . '</br>' .
                'Code : ' . $e->getCode() .
                'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                'Message : ' . $e->getMessage() . '</br>' .
                'Line : ' . $e->getLine() . '</br>');
        }
        return $com_bdd;
    }

}