<?php

namespace Admin\Requests\Content;

use Admin\Requests\BaseRequest;
use Connection\DB_conf;
use PDO;

class ColorsRequest extends BaseRequest
{
    const TABLE_NAME = 'content_color';

    /**‡
     * Request which create the color table
     *
     * @return bool
     */
    public function createColorTable()
    {
        $sql = "use " . DB_conf::DB_NAME;
        $this->dbManager->connection()->exec($sql);
        $sql = "CREATE TABLE IF NOT EXISTS " .self::TABLE_NAME ." (id int(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, color VARCHAR(255) NOT NULL, classColor VARCHAR(255) NOT NULL)";
        // @TODO vérifier le retour de la requete et voir si ça bloque pas la requête suivante

        return (bool)$this->dbManager->connection()->exec($sql);
    }

    /**
     * Request which create color content
     *
     * @param array $user
     * @return bool
     */
    public function createColorContent(array $data)
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . " (color, classColor) VALUES (:color, :classColor)";
        $query = $this->dbManager->connection()->prepare($sql);
        return $query->execute([
            'color'         => $data['color'],
            'classColor'    => $data['class-color'],

        ]);
    }


    public function updateColorContent($data){

        $sql = "UPDATE ". self::TABLE_NAME . " SET color = :color, classColor = :classColor WHERE id = :id";
        $query = $this->dbManager->connection()->prepare($sql);
        return $query->execute([
            'id'            => $data['id'],
            'color'         => $data['color'],
            'classColor'    => $data['class-color'],

        ]);
    }

    /**
     * Request which select all color content
     *
     * @param $params
     * @return array
     */
    public function selectAll($params)
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE -1";
        $query = $this->dbManager->connection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Select one content Element
     *
     * @param $params
     * @return array
     */
    public function selectOne($params)
    {
        $sql = "SELECT id, color, classColor FROM " . self::TABLE_NAME . " WHERE id = :id";
        $query = $this->dbManager->connection()->prepare($sql);
        $query->execute([
            'id' => $params['id']
        ]);

        return $query->fetch();
    }

    /**
     * Delete on content element
     * @param $params
     * @return bool
     */
    public function delete($params)
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE id = :id";
        $query = $this->dbManager->connection()->prepare($sql);
        return $query->execute([
            'id' => $params['id']
        ]);


    }
}