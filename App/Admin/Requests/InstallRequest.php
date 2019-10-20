<?php


namespace Admin\Requests;


use Connection\Db_manager;
use PDO;


class InstallRequest extends BaseRequest
{

    /**
     * Process Project Installation
     * Request which create the user table
     *
     * @param array $db_data
     * @return bool
     */
    public function createUserTable(array $db_data)
    {
        $sql = "use " . $db_data['Db_name'];
        $this->dbManager->connection()->exec($sql);
        $sql = "CREATE TABLE IF NOT EXISTS user ( id int(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, isSuperAdmin BOOLEAN NULL)";
        return (bool)$this->dbManager->connection()->exec($sql);
    }

    /**
     * Process Project Installation
     * Request which create admin account
     *
     * @param array $user
     * @return bool
     */
    public function createAdminAccount(array $user)
    {
        $sql = "INSERT INTO user (login, password, email) VALUES (:login,:pwd, :email)";
        $query = $this->dbManager->connection()->prepare($sql);
        return $query->execute([
            'login' => $user['login'],
            'pwd' => $user['pwd'],
            'email' => $user['email'],
        ]);
    }

}