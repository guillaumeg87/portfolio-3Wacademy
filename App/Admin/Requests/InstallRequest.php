<?php


namespace Admin\Requests;


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
        $sql = "CREATE TABLE IF NOT EXISTS user_settings ( 
                id int(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, 
                login VARCHAR(255) NOT NULL, 
                password VARCHAR(255) NOT NULL, 
                email VARCHAR(255) NOT NULL, 
                isSuperAdmin BOOLEAN NULL
                )";
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
        $sql = "INSERT INTO user_settings (login, password, email, isSuperAdmin) 
        VALUES (:login,:pwd, :email, :isSuperAdmin)";
        $query = $this->dbManager->connection()->prepare($sql);
        return $query->execute([
            'login' => $user['login'],
            'pwd' => $user['pwd'],
            'email' => $user['email'],
            'isSuperAdmin' => $user['isSuperAdmin'],
        ]);
    }

    public function createMenuEntryTable(array $db_data)
    {
        $sql = "use " . $db_data['Db_name'];
        $this->dbManager->connection()->exec($sql);
        $sql = "CREATE TABLE IF NOT EXISTS menu ( 
                id int(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, 
                contentTechnicalName VARCHAR(255) NOT NULL, 
                contentDisplayName VARCHAR(255) NOT NULL, 
                createdAt DATE NOT NULL, 
                updatedAt DATE NULL
                )";
        return (bool)$this->dbManager->connection()->exec($sql);
    }

    public function addUserEntryInMenu(array $params)
    {
        $sql = "INSERT INTO menu (contentTechnicalName, contentDisplayName, createdAt, updatedAt) 
                VALUES (:contentTechnicalName, :contentDisplayName, :createdAt, :updatedAt)";

        $query = $this->dbManager->connection()->prepare($sql);

        return $query->execute([
            'contentTechnicalName' => $params['contentTechnicalName'],
            'contentDisplayName' => $params['contentDisplayName'],
            'createdAt' => $params['createdAt'],
            'updatedAt' => $params['updatedAt'],
        ]);

    }
}
