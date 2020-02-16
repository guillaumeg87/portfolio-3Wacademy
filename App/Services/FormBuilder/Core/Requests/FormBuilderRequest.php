<?php
namespace Services\FormBuilder\Core\Requests;

use Admin\Requests\BaseRequest;
use Connection\DB_conf;
use PDO;

class FormBuilderRequest extends BaseRequest
{
    /**
     * If table exist return array
     * Exemple: array (
                    'Tables_in_portfolio_db (article)' => 'article',
                    0 => 'article',
                    );
     * Else return false
     * @param $name
     * @return bool|array
     */
    public function isTableExist($name)
    {

        $dbName = "use " . DB_conf::DB_NAME;
        $this->dbManager->connection()->exec($dbName);
        $query = "SHOW TABLES LIKE '" . $name['contentTechnicalName'] . "'";
        $result = $this->dbManager->connection()->prepare($query);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create content table
     * @param $labels
     * @param $sql
     * @see https://www.php.net/manual/en/pdo.exec.php
     * @return false|int
     */
    public function createContentTable($labels, $sql)
    {

        $dbName = "use " . DB_conf::DB_NAME;
        $this->dbManager->connection()->exec($dbName);
        $query = "CREATE TABLE IF NOT EXISTS " . $labels . ' ' . $sql;

        return $this->dbManager->connection()->exec($query);
    }

}

