<?php

namespace Admin\Core\Entity;

class User
{
    /**
     * @var Integer $id
     */
    private $id;
    /**
     * @var String $login
     */
    private $login;

    /**
     * @var String $pwd
     */
    private $pwd;

    /**
     * @var String $email
     */
    private $email;

    /**
     * @var boolean $isAdmin
     */
    private $isAdmin;

    /**
     * Get Id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get Login
     * @return String
     */
    public function getLogin(): String
    {
        return $this->login;
    }

    /**
     * @param String $login
     * @return User
     */
    public function setLogin(String $login): User
    {
        $this->login = $login;
        return $this;
    }

    /**
     * Get Pwd
     * @return String
     */
    public function getPwd(): String
    {
        return $this->pwd;
    }

    /**
     * @param String $pwd
     * @return User
     */
    public function setPwd(String $pwd): User
    {
        $this->pwd = $pwd;
        return $this;
    }

    /**
     * Get Email
     * @return String
     */
    public function getEmail(): String
    {
        return $this->email;
    }

    /**
     * @param String $email
     * @return User
     */
    public function setEmail(String $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get isAdmin
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     * @return User
     */
    public function setIsAdmin(bool $isAdmin): User
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }
}