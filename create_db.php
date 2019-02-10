<?php
require 'Autoload.php';
    Autoloader::register();
    $p = new Db_manager("mysql", "portfolio_db", "root", "");
    // $p->database_builder();