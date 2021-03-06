<?php

namespace Admin\Core\QueryBuilder;

use Connection\DB_conf;

class QueryBuilder
{
    /**
     * Build the sql string
     *
     * @param $params
     * @param $method
     * @return string|null
     * @throws \Exception
     */
    public function buildSql($params, $method):?string
    {

        $table_name = $params['content_name'];
        if(isset($params['content_name'])){

            unset($params['content_name']);
        }

        $sql = null;

        unset($params['id']);

        if (!empty($table_name)) {
            switch($method){

                case 'create':
                    $dataHandler = $this->getCreateColumnsAndAliases($params);
                    if (!empty($dataHandler)) {
                        $sql = "INSERT INTO " .  DB_conf::DB_NAME . '.'. $table_name . " (" . $dataHandler['columns'] . ") VALUES (" . $dataHandler['aliases'] . ")" ;

                    }
                    break;
                case 'select_one':

                        $sql = "SELECT * FROM " .  DB_conf::DB_NAME . '.'. $table_name . " WHERE id = :id;";

                    break;

                case 'select_all':

                    $sql = "SELECT * FROM " . DB_conf::DB_NAME . '.'. $table_name . " WHERE -1";
                    break;

                case 'update':
                    $dataHandler = $this->getUpdateSqlQuery($params);

                    if (!empty($dataHandler)) {

                        $sql = "UPDATE " .  DB_conf::DB_NAME . '.'. $table_name . " " . $dataHandler . " WHERE id = :id";
                    }
                    break;

                case 'delete':
                    $sql = "DELETE FROM " .  DB_conf::DB_NAME . '.'. $table_name . " WHERE id = :id";
                    break;

                case 'select_one_in_menu':
                    $sql =  $sql = "SELECT * FROM " .  DB_conf::DB_NAME . '.'. $table_name . " WHERE contentTechnicalName = :contentTechnicalName;";
                    break;

                case 'drop_table':
                    $sql = 'DROP TABLE ' . DB_conf::DB_NAME . '.' . $table_name;

                    break;
                default:
                    throw new \Exception('Unexpected value');
            }
        } else {
            switch($method){

                case 'select_table_list':
                    $sql = 'show tables from ' . DB_conf::DB_NAME;
                    break;

            }
        }
        return $sql;
    }

    /**
     * Handler for insert query
     * This method return an array as the following exemple
     *
     * Exemple: array (
                'columns' => 'content_name, title, description, photo',
                'aliases' => ':content_name, :title, :description, :photo',
            );
     *
     * Now it very easy to build the insert query
     *
     * @param $params
     * @return array
     */
    private function getCreateColumnsAndAliases($params): array
    {
        $columns = '';
        $aliases = '';
        if (!empty($params)){
            $keys = array_keys($params);
            for($i = 0; $i < count($params); $i++){
                if ($i === (count($params) - 1)){

                    $columns .= str_replace('-', '_',$keys[$i]);
                    $aliases .= ':' .str_replace('-', '_',$keys[$i]);
                }else{

                    $columns .= str_replace('-', '_',$keys[$i]) . ', ';
                    $aliases .= ':' . str_replace('-', '_',$keys[$i]) . ', ';
                }
            }
        }

        return [
            'columns' => $columns,
            'aliases' => $aliases
        ];
    }

    /**
     * Handler for update query
     * This method return an array as the following exemple
     *
     * Exemple: content_name = :content_name, title = :title, description = :description, photo = :photo'
     *
     * @param $params
     * @return string
     */
    private function getUpdateSqlQuery($params) : string
    {
        $str = '';
        unset($params['id']);
        $keys = array_keys($params);
        $lastElt = end($keys);

        forEach ($params as $key => $value) {
            if  ($lastElt !== $key){
                $str .= $key . " = :" . $key . ', ';

            }
            else {
                $str .= $key . " = :" . $key;
            }

        }
        return 'SET ' .  $str;
    }

    /**
     * Build a string with all table' columns.
     * Useful for the Select One query
     *
     * This method return a string as the following exemple:
     *
     * Exemple : 'content_name, title, description, photo';
     *
     * @param $params
     * @return string
     */
    private function getSelectOne($params) : string
    {
        $str = '';
        $keys = array_keys($params);
        $lastElt = end($keys);

        forEach ($params as $key => $value) {

            if ($lastElt !== $key){

                $str .= $key . ', ';
            }
            else {

                $str .= $key;
            }

        }

        return $str;
    }
}
