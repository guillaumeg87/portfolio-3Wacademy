<?php


namespace Services\FormBuilder\Core\Requests;

use Services\FormBuilder\Constants\FormBuilderConstants;

class QueryBuilder
{
    public function buildSqlRequest($fields)
    {
        $sqlQuery = "";
        $count = count($fields);
        $index = 0;

        foreach ($fields as $field) {

            $explode = explode('\\', get_class($field));
            $length = count($explode);
            $name = $explode[$length - 1];

            switch ($name) {
                case FormBuilderConstants::INPUT :
                    $sqlQuery .= $this->formatColumnName($field->getName()) . " VARCHAR(255)";
                    break;

                case FormBuilderConstants::TEXTEREA :
                    $sqlQuery .= $this->formatColumnName($field->getName()) . " LONGTEXT";
                    break;

                case FormBuilderConstants::SELECT :
                    //@TODO
                    //$sqlQuery .= $this->formatColumnName($field->getName()) . " VARCHAR(255) NOT NULL";
                    break;

                case FormBuilderConstants::RADIO :
                    //@TODO
                    // $sqlQuery .= $this->formatColumnName($field->getName()) . " VARCHAR(255) NOT NULL";
                    break;

                case FormBuilderConstants::CHECKBOX :
                    // @TODO
                    // $sqlQuery .= $this->formatColumnName($field->getName()) . " VARCHAR(255) NOT NULL";
                    break;
            }

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
        return str_replace(' ', '_', strtolower(
                trim(
                    htmlspecialchars($label)
                )
            )
        );
    }

    /**
     * Add regular columns : id createAt and updateAt
     * @param $str string
     * @return string
     */
    private function addRegularColumns($str): string
    {
        return "( id int(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, " . $str . ", createdAt DATE NULL default null, updateAt DATE NULL default null )";
    }
}
