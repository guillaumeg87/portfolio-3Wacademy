<?php

namespace Admin\Core\Config;

use PDO;

class DatabaseConnection
{
    private static $bdd = null;
    private function __construct() {
    }
    public static function getBdd() {
        if(is_null(self::$bdd)) {
            self::$bdd = new PDO("mysql:host=XXXX;dbname=XXXX", 'XXXX', 'XXXX');
        }
        return self::$bdd;
    }
}
