<?php

namespace Connection;

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
    public function __construct($host, $name, $admin, $pwd){
        $this->host = $host;
        $this->name = $name;
        $this->admin = $admin;
        $this->pwd = $pwd;
    }

    /**
     * Connection à la base de donnée
     * @return PDO
     */
    public function connection(){

        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->name;
        $com_bdd = new PDO($dsn, $this->admin, $this->pwd);
        $com_bdd -> exec("SET NAMES UTF8");
        return $com_bdd;
    }

    /**
     * Création de la base de donnée
     */
    public function database_builder(){
// Create connection
        $conn = new mysqli($this->host, $this->admin, $this->pwd);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

// Create database
        $sql = "CREATE DATABASE " . $this->name;
        if ($conn->query($sql) === TRUE) {
            echo "Database created successfully";
        } else {
            echo "Error creating database: " . $conn->error;
        }

        $conn->close();
    }
}