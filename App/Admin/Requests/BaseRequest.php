<?php


namespace Admin\Requests;

use Connection\Db_manager;


abstract class BaseRequest
{
    /**
     * @var Db_manager $dbManager
     */
    protected $dbManager;

    public function __construct()
    {
        $this->dbManager = new Db_manager();
    }
}