<?php
namespace Services\FormBuilder\Core\Requests;

use Admin\Requests\BaseRequest;
use Connection\DB_conf;
use PDO;
use Services\Dumper\Dumper;
use Services\FormBuilder\Constants\FormBuilderConstants;

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
    public function isTableExist($name, $isTaxonomy)
    {

        $table_name = $isTaxonomy ? $name['contentTechnicalName'] . FormBuilderConstants::TAXO_TABLE_SUFFIX : $name['contentTechnicalName'];

        $dbName = "use " . DB_conf::DB_NAME;
        $this->dbManager->connection()->exec($dbName);
        $query = "SHOW TABLES LIKE '" . $table_name . "'";
        $result = $this->dbManager->connection()->prepare($query);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create content table
     * @param string $labels
     * @param string $sql
     * @param bool $isTaxonomy
     * @return false|int
     * @see https://www.php.net/manual/en/pdo.exec.php
     */
    public function createContentTable($labels, $sql, $isTaxonomy)
    {
        $table_name = $isTaxonomy ? $labels . FormBuilderConstants::TAXO_TABLE_SUFFIX : $labels;

        $dbName = "use " . DB_conf::DB_NAME;
        $this->dbManager->connection()->exec($dbName);
        $query = "CREATE TABLE IF NOT EXISTS " . DB_conf::DB_NAME . '.' . $table_name . ' ' . $sql;

        return $this->dbManager->connection()->exec($query);
    }

}

