<?php

namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Core\QueryBuilder\QueryBuilder;
use Admin\Core\Traits\NavigationTrait;
use Admin\Requests\Content\ContentRequest;
use mysql_xdevapi\Exception;
use Services\Dumper\Dumper;
use Services\FlashMessages\FlashMessage;
use Services\FormBuilder\Constants\FormBuilderConstants;

class SettingsController extends AbstractController
{
    use NavigationTrait;
    //TEMPLATE
    const ADMIN_HOME = 'admin_home';
    const ADMIN_SETTINGS_MAIN = 'settings_main';
    const ADMIN_SETTINGS_DANGER_ZONE = 'settings_danger_zone';
    const TAXONOMY_TEMP_FILE = '/taxonomy_list.json';

    public function mainSettings($options = [])
    {
        if (empty($_SESSION)) {
            $this->render(__NAMESPACE__, self::ADMIN_HOME, $options);
        }
    }

    public function dangerZone($options = [])
    {
        /*if(empty($_SESSION)) {
            $this->render(__NAMESPACE__, self::ADMIN_HOME, $options);
        }*/

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

        /*if(empty($_SESSION)) {
            $this->render(__NAMESPACE__, self::ADMIN_HOME, $options);
        }
*/
        try {
            if (!empty($options['id'])) {
                $tableName = htmlspecialchars($options['id']);
                $tableList = $this->getTableList();
                $isTaxoConfUpdate = null;

                if (preg_match('/_taxo$/', $tableName)){

                    $isTaxoConfUpdate = $this->handleTaxonomyConfiguration($tableName);
                    if($isTaxoConfUpdate){
                        $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
                            'La configuration des taxonomy a bien été mise à jour.',
                            'success'
                        ))->messageBuilder();
                    }else{
                        $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
                        'La configuration des taxonomy n\'a pas été mise à jour.',
                            'success'
                        ))->messageBuilder();;
                    }
                }

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
                    }else {
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
        $this->render(__NAMESPACE__, self::ADMIN_SETTINGS_DANGER_ZONE, $options);

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
        $pathConfigFiles = FormBuilderConstants::CUSTOM_APP_PATH
                            . str_replace('..', '', FormBuilderConstants::CUSTOM_CONFIG_DIRECTORY)
                            . $tableName . '.json';

        $pathTempConfig = FormBuilderConstants::CUSTOM_APP_PATH
                        . str_replace('..', '',FormBuilderConstants::CUSTOM_TEMPORARY_CONFIG_DIRECTORY)
                        . $tableName . '.json';

        if (file_exists($pathConfigFiles)) {
            $isConfDeleted = unlink($pathConfigFiles);
            if(file_exists($pathTempConfig)){
                $isTempDeleted = unlink($pathTempConfig);
            }
        }
        return $isConfDeleted || ($isConfDeleted && $isTempDeleted);
    }

    /**
     * @param $tableName
     * @return bool
     */
    private function handleTaxonomyConfiguration($tableName):bool
    {
        // remove the .. in the path with start with ../Services/.. and after we have /Services/
        $noDot = str_replace('..', '',FormBuilderConstants::TAXONOMY_CONFIG_DIRECTORY);
        $tempTaxoConfFilePath = FormBuilderConstants::CUSTOM_APP_PATH . $noDot . self::TAXONOMY_TEMP_FILE;

        $taxoConfig = json_decode(file_get_contents($tempTaxoConfFilePath), true);
        foreach ($taxoConfig as $key => $value) {
            if ($value === $tableName){
                unset($taxoConfig[$key]);
            }
        }
        return is_int(file_put_contents($tempTaxoConfFilePath, json_encode($taxoConfig)));
    }
}
