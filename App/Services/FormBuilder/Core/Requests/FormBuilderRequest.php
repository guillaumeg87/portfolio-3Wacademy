<?php
namespace Services\FormBuilder\Core\Requests;

use Admin\Requests\BaseRequest;
use Connection\DB_conf;
use PDO;
use Services\FormBuilder\Constants\FormBuilderConstants;

class FormBuilderRequest extends BaseRequest
{
    /**
     * If table exist return array
     * Exemple: array (
     * 'Tables_in_portfolio_db (article)' => 'article',
     * 0 => 'article',
     * );
     * Else return false
     * @param $name
     * @param $option
     * @return bool|array
     */
    public function isTableExist($name, $option)
    {

        $tableName = $this->setTableName($name, $option);

        $dbName = "use " . DB_conf::DB_NAME;
        $this->dbManager->connection()->exec($dbName);
        $query = "SHOW TABLES LIKE '" . $tableName . "'";
        $result = $this->dbManager->connection()->prepare($query);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create content table
     * @param $label
     * @param string $sql
     * @param bool $option
     * @return false|int
     * @see https://www.php.net/manual/en/pdo.exec.php
     */
    public function createContentTable($label, $sql, $option)
    {
        $tableName = $this->setTableName($label, $option);

        $dbName = "use " . DB_conf::DB_NAME;
        $this->dbManager->connection()->exec($dbName);
        $query = "CREATE TABLE IF NOT EXISTS " . DB_conf::DB_NAME . '.' . $tableName . ' ' . $sql;

        return $this->dbManager->connection()->exec($query);
    }


    /**
     * Build and return the table name
     * @param $name
     * @param $option
     * @return string|null
     */
    private function setTableName($name, $option):?string
    {
        $tableName = null;

        switch($option) {
            case 'taxonomy':
                $tableName = $name . FormBuilderConstants::TAXO_TABLE_SUFFIX;
            break;
            case'settings':
                $tableName = $name . FormBuilderConstants::SETTINGS_TABLE_SUFFIX;
                break;

            default:
                $tableName = $name . FormBuilderConstants::CONTENT_TABLE_SUFFIX;

        }

        return $tableName;
    }
}

