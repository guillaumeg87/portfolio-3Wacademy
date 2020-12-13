<?php

namespace Admin\Core\Entity;

class SessionManager
{
    private $session;

    const LIFETIME = 300;

    public function __construct()
    {
        if($this->isSessionExist()){
            $this->session = $_SESSION;
        } else {
            $this->start();
            $this->session = $_SESSION;
        }

    }

    private function start(){
        return session_start();
    }

    /**
     * @return array
     */
    public function getSession():array
    {
        return $this->session;
    }

    /**
     * @param $param
     * @return $this
     */
    public function setSession($param)
    {
        $this->session = $param;
        return $this;

    }

    /**
     * @return bool
     */
    private function isSessionExist ():bool
    {

        if(session_status() < 2){

            $this->start();
            setcookie(session_name(),session_id(),time() + SessionManager::LIFETIME);
        }

        return is_array($_SESSION) ?? false;
    }

    /**
     * @return array|string
     */
    public function createSession()
    {
        if ($this->isSessionExist()){
            return $_SESSION = [];
        } else {
            return $this->getNewSessionID();
        }
    }

    /**
     * @return string
     */
    private function getNewSessionID(){
        return session_id($this->newToken());
    }

    /**
     * @return string
     */
    private function newToken() {
        return sha1(mt_rand(1, 90000) . 'SALT');
    }

    /**
     *
     */
    public function removeSession(){

        session_unset();
        session_destroy();
    }

}
