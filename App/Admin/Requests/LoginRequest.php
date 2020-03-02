<?php

namespace Admin\Requests;

use PDO;

class LoginRequest extends BaseRequest
{
    /**
     * Get the current user wich want to be connected to the back office
     * @param $datas
     * @return mixed
     */
    public function getLogin (array $datas)
    {

        $sql = "SELECT * FROM user WHERE login = :login";
        $query = $this->dbManager->connection()->prepare($sql);
        $query->bindValue(':login', $datas['login'], PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);

        return $results;

    }
}
