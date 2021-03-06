<?php


namespace Services\FormBuilder\Core\Requests;

use Connection\DB_conf;
use Services\FormBuilder\Constants\FormBuilderConstants;
use Services\FormBuilder\Core\Entity\FilesFields;
use Services\FormBuilder\Core\Entity\InputFields;

class QueryBuilder
{

    public function buildSqlRequest($fields)
    {
        $sqlQuery = "";
        $toQuery = "";
        $count = count($fields);
        $index = 0;

        foreach ($fields as $field) {

            $explode = explode('\\', get_class($field));
            $length = count($explode);
            $name = $explode[$length - 1];
            switch ($name) {

                case FormBuilderConstants::INPUT :

                    if ($field instanceof InputFields
                        && $field->getType() !== 'checkbox'
                        && $field->getType() !== 'radio'
                    ){

                        $toQuery = $this->formatColumnName(str_replace('-', '_', $field->getName())) . " VARCHAR(255)";
                    }
                    if ($field->getType() === 'checkbox'){

                        $toQuery = $this->formatColumnName($field->getName()) . " BOOLEAN NOT NULL";
                    }
                    if ($field->getType() === 'radio'){

                        $toQuery = $this->formatColumnName($field->getName()) . " BOOLEAN NOT NULL";
                    }
                    if ($field->getType() === 'date'){

                        $toQuery = $this->formatColumnName($field->getName()) . " DATETIME";
                    }

                    break;
                case FormBuilderConstants::FILES:

                    $toQuery = $this->addFileFields($field);

                    break;
                case FormBuilderConstants::TEXTEREA :
                    $toQuery = $this->formatColumnName($field->getName()) . " LONGTEXT";

                    break;

                case FormBuilderConstants::ENTITY_REF :
                case FormBuilderConstants::SELECT :
                    $toQuery = $this->formatColumnName($field->getName()) . "  VARCHAR(255)";

                    break;

                case FormBuilderConstants::RADIO :

                    $toQuery = $this->formatColumnName($field->getName()) . " VARCHAR(255) NOT NULL";
                    break;

                case FormBuilderConstants::CHECKBOX :
                    // @TODO
                    $toQuery = $this->formatColumnName($field->getName()) . " BOOLEAN NOT NULL";
                    break;
            }

            $sqlQuery .= $toQuery;
            $index++;

            if ($index < $count) {
                $sqlQuery .= ", ";
            }
        }

        return $this->addRegularColumns($sqlQuery);
    }

    /**
     * Return formated string for columns names in database
     * Remove uppercase character, spaces
     * @param $label string
     * @return string
     */
    private function formatColumnName($label): string
    {
        return str_replace(' ', '_',
            trim(
                htmlspecialchars($label)
            )
        );
    }

    /**
     * Add regular columns : id createdAt and updatedAt
     * @param $str string
     * @return string
     */
    private function addRegularColumns($str): string
    {
        return "( id int(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, " . $str . ", createdAt DATE NULL default null, updatedAt DATE NULL default null )";
    }

    /**
     * @param FilesFields $field
     * @return string
     */
    private function addFileFields(FilesFields $field)
    {
        if ($field instanceof FilesFields) {

            return $this->formatColumnName($field->getName() . '_' . FilesFields::FILE_URL_LABEL) . " VARCHAR(255)"
                . ', ' . $this->formatColumnName($field->getName() . '_' . FilesFields::FILE_PATH_LABEL) . " VARCHAR(255)";
        }
        return '';

    }

    /**
 * @param string $param
 * @return string
 */
    public function selectAllToFront(string $param):string
    {
        return 'SELECT * FROM ' . DB_conf::DB_NAME . '.' . $param . ' WHERE 1';
    }

    /**
     * @param string $param
     * @param string $id
     * @return string
     */
    public function selectOneToFront(string $param, string $id):string
    {

        return 'SELECT * FROM ' . DB_conf::DB_NAME . '.' . $param . ' WHERE id = :id';
    }
}

