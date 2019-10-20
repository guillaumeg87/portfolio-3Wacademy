<?php

namespace Admin\Core\Api;

use Admin\Core\Entity\User;

class ApiManager
{

    /**
     * @var String $method
     */
    private $method;

    /**
     * @var String $action
     */
    private $action;

    /**
     * @var array $options
     */
    private $options;

    /**
     * @var User $user
     */
    private $user;


    public function __construct($method, $options,User $user, $action)
    {
        $this->method = $method;
        $this->action = $action;
        $this->options= $options;
        $this->user = $user;
        $this->url = ROOT;
    }

    public function getRights(User $user)
    {

    }

}