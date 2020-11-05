<?php

namespace Connection;


use mysql_xdevapi\Exception;
use PDO;
use Services\LogManager\LogConstants;
use Services\LogManager\LogManager;

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
     * @param array $param
     */
    public function __construct($param = []){

        if(empty($param)) {
            $this->host     = DB_conf::DB_HOST;
            $this->name     = '`' . DB_conf::DB_NAME . '`';
            $this->admin    = DB_conf::DB_ADMIN;
            $this->pwd      = DB_conf::DB_PASSWORD;
            $this->connection = $this->connection();
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

        if(!empty($this->host) && !empty($this->admin) && !empty($this->name)){
            try{
                $dsn = "mysql:host=" . $this->host . ";";
                $com_bdd = new PDO($dsn, $this->admin, $this->pwd);
                $com_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $com_bdd->exec("SET NAMES UTF8");
                $com_bdd->exec("USE ".$this->name);
            }catch(\Exception $e){
                (new LogManager())->log(
                    '[ Db Manager ] An error occured, data base connection'  .  PHP_EOL . $e->getTraceAsString(),
                    LogConstants::ERROR_APP_LABEL,
                    LogConstants::INFO_LABEL);
                throw new Exception('ERROR : ' . '</br>' .
                    'Code : ' . $e->getCode() .
                    'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                    'Message : ' . $e->getMessage() . '</br>' .
                    'Line : ' . $e->getLine() . '</br>');
            }
        }
        return $com_bdd;
    }

}
