<?php

namespace Admin\Requests;

use PDO;

class LoginRequest
{
    /**
     *
     */
    public function getLogin ($datas) {

        $pdo = new PDO('mysql:host=mysql;dbname=portfolio_db', 'root', '');
        $query = $pdo->prepare("SELECT login, password FROM user WHERE login = :login");
        $query->bindValue(':login', $datas['login'], PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetch();
        $pdo = null;

        return $results;

    }
}