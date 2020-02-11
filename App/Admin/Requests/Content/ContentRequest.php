<?php

namespace Admin\Requests\Content;

use Admin\Requests\BaseRequest;
use Connection\DB_conf;
use PDO;


class ContentRequest extends BaseRequest
{

    /**‡
     * Request which create the color table
     * @param array $data
     * @return bool
     */
    public function isTableExist(array $data): bool
    {
        $dbName = "use " . DB_conf::DB_NAME;
        $this->dbManager->connection()->exec($dbName);
        $query = "SHOW TABLES LIKE '" . $this->getTable($data) . "'";
        $result = $this->dbManager->connection()->prepare($query);
        $result->execute();

        return (bool) $result->fetch();
    }

    /**
     * Request which create color content
     *
     * @param array $data
     * @param string $sql
     * @return bool
     */
    public function createContent(array $data, string $sql)
    {

        unset( $data['content_name']);
        $query = $this->dbManager->connection()->prepare($sql);

        return $query->execute($data);
    }

    /**
     * @param $data
     * @param $sql
     * @return bool
     */
    public function updateContent(array $data, string $sql)
    {

        unset($data['content_name']);

        $query = $this->dbManager->connection()->prepare($sql);
        return $query->execute($data);
    }

    /**
     * Request which select all color content
     *
     * @param array $data
     * @param string $sql
     * @return array
     */
    public function selectAll(array $data, string $sql)
    {
        $sql = "SELECT * FROM " . $this->getTable($data) . " WHERE -1";
        $query = $this->dbManager->connection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Select one content Element
     *
     * @param array $data
     * @param string $sql
     * @return array
     */
    public function selectOne(array $data, string $sql)
    {

        $query = $this->dbManager->connection()->prepare($sql);
        $query->execute([
            'id' => $data['id']
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Delete on content element
     * @param $data
     * @param $sql
     * @return bool
     */
    public function delete($data, $sql)
    {

        $query = $this->dbManager->connection()->prepare($sql);
        return $query->execute([
            'id' => $data['id']
        ]);
    }

    /**
     * @param array $data
     * @return string|null
     */
    private function getTable(array $data):?string
    {
        $tableName = null;
        if(!empty($data['content_name'])){
            $tableName =  $data['content_name'];
        }

        return $tableName;
    }
}
