<?php

namespace Connection;

use PDO;
use App\Connection\DB_conf;

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
     * Db_manager constructor.
     */
    public function __construct(DB_conf $conf){
        $this->host = $conf::HOST;
        $this->name = $conf::DB_NAME;
        $this->admin = $conf::ADMIN;
        $this->pwd = $conf::PWD;
    }

    /**
     * Connection à la base de donnée
     * @return PDO
     */
    public function connection(){

        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->name;
        $com_bdd = new PDO($dsn, $this->admin, $this->pwd);
        $com_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $com_bdd -> exec("SET NAMES UTF8");
        return $com_bdd;
    }

}