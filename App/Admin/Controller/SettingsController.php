<?php

namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Core\Config\CoreConstants;
use Admin\Core\QueryBuilder\QueryBuilder;
use Admin\Core\Traits\NavigationTrait;
use Admin\Requests\Content\ContentRequest;
use mysql_xdevapi\Exception;
use Services\FlashMessages\FlashMessage;
use Services\FormBuilder\Constants\FormBuilderConstants;
use stdClass;

class SettingsController extends AbstractController
{
    use NavigationTrait;
    //TEMPLATE
    const ADMIN_SETTINGS_DANGER_ZONE = 'settings_danger_zone';


    public function dangerZone($options = [])
    {
        $this->isSessionActive();


        $results = $this->getTableList();

        if ($results instanceof FlashMessage) {
            $options['flash-message'][] = $results;
        } else {
            $options['list'] = $results;
        }
        $this->render(__NAMESPACE__, self::ADMIN_SETTINGS_DANGER_ZONE, $options);

    }

    /**
     * @param $options
     */
    public function delete($options)
    {
        $this->isSessionActive();

        try {
            if (!empty($options['id'])) {
                $tableName = htmlspecialchars($options['id']);
                $tableList = $this->getTableList();
                $isTaxoConfUpdate = null;

                if ($this->isTableExist($tableList, $tableName) && $isTaxoConfUpdate !== false) {

                    $queryBuilder = new QueryBuilder();
                    $request = new ContentRequest();

                    // Remove Content in admin menu table
                    $sqlGetContentInMenu = $queryBuilder->buildSql(['content_name' => 'menu'], 'select_one_in_menu');
                    $getContentInMenu = $request->selectOneInMenu(['content_name' => 'menu', 'contentTechnicalName' => $tableName], $sqlGetContentInMenu);
                    $getContentInMenu['content_name'] = 'menu';
                    $sqlDeleteContentInMenu = $queryBuilder->buildSql($getContentInMenu, 'delete');
                    $isDeleteInMenu = $request->delete($getContentInMenu, $sqlDeleteContentInMenu);

                    if ($isDeleteInMenu) {

                        // Drop content type table
                        $sqlDropTable = $queryBuilder->buildSql(['content_name' => $tableName], 'drop_table');
                        $isTableDroped = $request->dropTable($sqlDropTable);

                        $isConfigFilesDeteted = $this->deleteConfigFiles($tableName);
                        if ($isTableDroped && $isConfigFilesDeteted) {
                            $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
                                'Le type de contenu a bien été supprimé, ainsi que les configurations.'. '</br>' .
                                'Vérifier qu\'un autre contenu n\'est pas lié à celui ci.' ,
                                'success'
                            ))->messageBuilder();
                        }
                    }
                    else {
                        throw new Exception();
                    }
                }
            }
        } catch (\Exception $e) {
            $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
                'ERROR : ' . '</br>' .
                'Code : ' . $e->getCode() .
                'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                'Message : ' . $e->getMessage() . '</br>' .
                'Line : ' . $e->getLine() . '</br>',
                'error'
            ))->messageBuilder();
        }
        $this->dangerZone($options);
        //this->render(__NAMESPACE__, self::ADMIN_SETTINGS_DANGER_ZONE, $options);

    }

    /**
     * Return data table list
     * @return array
     */
    private function getTableList(): array
    {
        try {
            $queryBuilder = new QueryBuilder();
            $sql = $queryBuilder->buildSql([], 'select_table_list');

            $request = new ContentRequest();
            $response = $request->selectAll($sql);
            return $this->ignoreUserTable($response);

        } catch (\Exception $e) {
            return ($this->getServiceManager()->getFlashMessage(
                'ERROR : ' . '</br>' .
                'Code : ' . $e->getCode() .
                'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                'Message : ' . $e->getMessage() . '</br>' .
                'Line : ' . $e->getLine() . '</br>',
                'error'
            ))->messageBuilder();
        }

    }

    /**
     * Avoid to delete user table from BO
     * @param array $list
     * @return array
     */
    private function ignoreUserTable(array $list): array
    {
        foreach ($list as $index => $row) {
            foreach ($row as $key => $value) {
                if (preg_match('/user*|menu*/', $value)) {
                    unset($list[$index]);
                }
            }

        }
        return $list;
    }

    /**
     * Check if Content table exist
     * @param $list
     * @param $tableName
     * @return bool
     */
    private function isTableExist($list, $tableName): bool
    {
        $isExist = false;
        foreach ($list as $row) {

            if (in_array($tableName, $row)) {
                $isExist = true;
            }
        }
        return $isExist;
    }

    /**
     * Delete content type config files
     * @param string $tableName
     * @return bool
     */
    private function deleteConfigFiles(string $tableName): bool
    {

        $isConfDeleted = false;
        $isTempDeleted = false;
        $isListUpdated = false;
        $pathConfigFiles = CoreConstants::CUSTOM_APP_PATH
                            . str_replace('..', '', FormBuilderConstants::CUSTOM_CONFIG_DIRECTORY)
                            . $tableName . '.json';

        $pathTempConfig = CoreConstants::CUSTOM_APP_PATH
                        . str_replace('..', '',FormBuilderConstants::CUSTOM_TEMPORARY_CONFIG_DIRECTORY)
                        . $tableName . '.json';

        if (file_exists($pathConfigFiles)) {
            $isConfDeleted = unlink($pathConfigFiles);

            if (file_exists($pathTempConfig)){
                $isTempDeleted = unlink($pathTempConfig);
            }
        }
        if ($isConfDeleted){
            $isListUpdated = $this->removeInContentList($tableName);
        }

        return $isConfDeleted && $isListUpdated || ($isConfDeleted && $isTempDeleted && $isListUpdated);
    }

    /**
     * @param string $tableName
     * @return bool
     */
    private function removeInContentList(string $tableName):bool
    {
        //delete in content type config list
        $explode = \explode('_', $tableName);
        $contentType = end($explode);
        $save = false;
        $pathContentList = CoreConstants::CUSTOM_APP_PATH
            . str_replace('..', '', FormBuilderConstants::CUSTOM_CONFIG_DIRECTORY)
            . $contentType . '/' . $contentType . '_list.json';

        if (file_exists($pathContentList)) {
            $list = json_decode(file_get_contents($pathContentList), true);

            foreach ($list as $key => $value) {
                if ($value === $tableName) {
                    unset($list[$key]);
                }
            }
            if (empty($list)) {
                $json = \json_encode(new \stdClass, true);
                $save = \file_put_contents($pathContentList, $json);
            } else {

                $save = file_put_contents($pathContentList, json_encode($list));
            }
        }

        return is_int($save) ? true : false;
    }
}
