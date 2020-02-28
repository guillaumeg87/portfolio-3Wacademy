<?php

namespace Services\FormBuilder\Core;

use mysql_xdevapi\Exception;
use Services\FlashMessages\FlashMessage;
use Services\FormBuilder\Constants\FormBuilderConstants;
use Services\FormBuilder\Core\Entity\InputFields;
use Services\FormBuilder\Core\Requests\FormBuilderRequest;
use Services\FormBuilder\Core\Requests\QueryBuilder;
use stdClass;


class FormBuilderManager
{
    /**
     * @var $data array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build list of index => help to sort form data
     * @param $formData array
     * @return array
     *
     */
    public function buildIndex(array $formData): array
    {
        $suffixe = [];

        unset($formData[FormBuilderConstants::DISPLAY_NAME]);
        unset($formData[FormBuilderConstants::TECHNICAL_NAME]);

        $arrayKey = array_keys($formData);
        foreach ($arrayKey as $key) {

            $num = explode('_', $key);
            if (!in_array($num[1], $suffixe)) {
                $suffixe[$num[1]] = [];
            }
        }

        return $suffixe;
    }

    /**
     * @param array $formData
     * @param array $suffix
     * @return array
     */
    public function sortFormdata(array $formData, array $suffix): array
    {
        $isTaxonomy  = $this->isTaxonomy($formData);
        $reformatedDatas = $this->splitDatas($formData);
        $fieldItem = '';
        $idRef = '';

        foreach ($reformatedDatas['reformatedEntry'] as $key => $value) {

            $explode = explode('_', $key);
            $index = $explode[1];

            if (!empty($index) && preg_match('/[' . $index . ']$/', $key)) {

                if (array_key_exists($index, $suffix)) {
                    if ($explode[0] == FormBuilderConstants::KEY_FIELD_TYPE) {

                        $fieldItem = htmlspecialchars($value);
                        $suffix[$index][$value] = [];

                    } else {
                        if ($reformatedDatas['reformatedEntry'][$key] === 'file') {
                            //manage input type file
                            $suffix[$index][$fieldItem] = array_merge($suffix[$index][$fieldItem],
                                $this->addFileFields());
                            $suffix[$index][$fieldItem][$explode[0]] = htmlspecialchars($value);

                        }

                        else if (preg_match('/labelRef_'. $index .'/', $key)){
                            // manage select field
                            $splitRef = explode('_', $value);
                            $idRef = (int) $splitRef[0];
                            array_shift($splitRef);
                            $labelRef = '';
                            $end = end($splitRef);
                            foreach ($splitRef as $k => $v) {

                                if($k != $end){
                                    $labelRef .= '_' . $v;

                                }else{
                                    $labelRef .= $v;
                                }
                            }
                            $suffix[$index][$fieldItem][$explode[0]] = htmlspecialchars($labelRef);
                        }
                        else if (!empty($idRef) && preg_match('/idRef_'. $index .'/', $key)) {

                            $suffix[$index][$fieldItem][$explode[0]] = (int) htmlspecialchars($idRef);
                        }
                        else{
                            $suffix[$index][$fieldItem][$explode[0]] = htmlspecialchars($value);

                       }
                    }
                }
            }
        }
        /** Reformated Array */
        $datas = [];
        $instancesCart = [];
        foreach ($suffix as $index => $field) {

            foreach ($field as $key => $value) {

                $instancesCart[] = $this->toObject($field, $key);
                // Label required only  for the configuration file generation
                $datas[] = $this->setLabel($field, $key);
            }
        };

        $queryManager = new QueryBuilder();
        $query = $queryManager->buildSqlRequest($instancesCart);

        try {
            $isTableExist = $this->getFormBuilderRequest()->isTableExist($reformatedDatas['labels'], $isTaxonomy);

        } catch (\PDOException $exception) {
            throw new \PDOException();
        }

        if (!is_array($isTableExist)) {

            try {
                /**
                 * This function return int (number of affected rows) or false
                 * In this case, return 0 => table creation, any affected rows
                 * I wait non boolean result, because this function use exec and can return false
                 * https://www.php.net/manual/en/pdo.exec.php
                 */
                $isTableCreated = $this->getFormBuilderRequest()->createContentTable($reformatedDatas['labels'][FormBuilderConstants::TECHNICAL_NAME],
                   $query,$isTaxonomy);

                if ($isTableCreated !== false) {
                    if ($isTaxonomy) {
                        $isTaxonomySaved = $this->handleTaxonomy($reformatedDatas['labels']);
                        if (!$isTaxonomySaved){
                            $flashMessage = (new FlashMessage('La taxonomy n\'a pas été créée dans le fichier de configuration',
                                'error')
                            )->messageBuilder();
                        }

                    }
                    $this->writeJsonConfigFile(
                        $this->additionnalFields($datas, $reformatedDatas['labels']),
                        $reformatedDatas['labels'],
                        $isTaxonomy
                    );
                }

            } catch (\PDOException $exception) {
                throw new \PDOException();
            }

            return [
                'labels'        => $reformatedDatas['labels'],
                'toMenu'        => true,
                'flash-message' => $flashMessage,
                'isTaxonomy'    => $isTaxonomy
            ];

        } else {

            $flashMessage = (new FlashMessage('Ce contenu existe déjà, il n\'a donc pas été créé en doublon',
                'error')
            )->messageBuilder();

            return [
                'flash-message' => $flashMessage,
                'toMenu' => false
            ];
        }
    }

    /**
     * Build Label from input field datas
     * @param $field array
     * @param $type string
     * @return array
     */
    public function setLabel(array $field, $type): array
    {
        $formated = [];
        $formated['label'] = $field[$type];
        $formated[$type] = $field[$type];

        unset($formated['label']['type']);
        unset($formated['label']['placeholder']);
        $formated['label']['for'] = $field[$type]['name'];
        unset($formated['label']['name']);

        if ($field[$type]['type'] === 'file') {
            unset($formated['label']['url']);
            unset($formated['label']['path']);
        }

        return $formated;
    }

    /**
     * Write json configuration in a json file
     * @param $datas
     */
    public function writeJsonConfigFile(array $datas, array $labels, $isTaxonomy)
    {
        $fileName = $isTaxonomy ? $labels[FormBuilderConstants::TECHNICAL_NAME] . FormBuilderConstants::TAXO_TABLE_SUFFIX : $labels[FormBuilderConstants::TECHNICAL_NAME];
        if (!is_dir(FormBuilderConstants::CUSTOM_CONFIG_DIRECTORY)) {

            mkdir(FormBuilderConstants::CUSTOM_CONFIG_DIRECTORY);
        }

        $path = FormBuilderConstants::CUSTOM_CONFIG_DIRECTORY . $fileName . '.json';

        $json = json_encode($datas);
        file_put_contents($path, $json);
    }

    /**
     * @param array $field
     * @param string $type
     * @return Entity\AbstractBaseContentEntity|InputFields
     */
    public function toObject(array $field, string $type)
    {
        $name = $this->getEntityType($field, $type);

        try {
            if ($name !== null && class_exists($name)) {
                $class = new $name();

                if ($class instanceof $name) {

                    return $fieldInstance = $class->arrayToObject($field[$type], 'set');
                }
            }
        } catch (\Exception $e) {
            throw new Exception($e->getCode() . ' : ' . $e->getMessage() . '</br>' . $e->getTraceAsString());
        }
        return null;
    }


    /**
     * Extract necessaries fields for labels and return splited arrays
     * @param $datas
     * @return array
     */
    private function splitDatas($datas)
    {
        $labelsDatas = [];

        foreach ($datas as $key => $value) {
            if (in_array($key, FormBuilderConstants::MENU_LABEL_COLLECTIONS)) {
                $labelsDatas[$key] = ($key === FormBuilderConstants::DISPLAY_NAME) ?
                    strtolower(trim($value)) : str_replace(' ', '_', strtolower(trim($value)));
                unset($datas[$key]);
            }
        }

        return [
            'labels' => $labelsDatas,
            'reformatedEntry' => $datas
        ];
    }

    /**
     * Get instance of FormBuilderRequest
     * @return FormBuilderRequest
     */
    private function getFormBuilderRequest()
    {
        return new FormBuilderRequest();
    }

    /** Add usual fields needed for each forms :
     * - wrapper for all the fields
     * - submit button
     *
     * @param $datas
     * @param $labels
     * @return array
     */
    private function additionnalFields($datas, $labels)
    {
        $configJson = $this->addWrapperFields($labels);
        $configJson['fields'] = $datas;
        $configJson['buttons'][] = $this->addSubmitButton();

        return $configJson;
    }


    /**
     * Move the fields in the wrapper
     * @param array $labels
     * @return array
     */
    private function addWrapperFields(array $labels): array
    {
        return [
            'fieldset' => [
                'id' => '',
                'class' => [FormBuilderConstants::CONTENT_FORM_CLASS_WRAPPER],
                'group' => FormBuilderConstants::CONTENT_FORM_GROUP_WRAPPER
            ],
            'legend' => [
                'content' => 'Nouveau ' . strtolower($labels[FormBuilderConstants::DISPLAY_NAME]),
                'id' => '',
                'class' => [],
                'group' => FormBuilderConstants::CONTENT_FORM_CLASS_WRAPPER
            ]
        ];
    }

    /**
     * Add the submit button
     * @return array
     */
    private function addSubmitButton()
    {
        return [
            'button' => [
                'type' => 'submit',
                'id' => '',
                'class' => [FormBuilderConstants::CONTENT_FORM_CLASS_BTN_SUBMIT],
                'content' => 'validez',
                'group' => FormBuilderConstants::CONTENT_FORM_GROUP_WRAPPER
            ]
        ];
    }

    public function updateContentdata()
    {

        if (!empty($this->data)) {
            return $this->getformHydrator($this->data)->buildTemporaryConfiguration();
        }
        return null;
    }

    private function getformHydrator($datas)
    {
        return new FormHydrator($datas);
    }

    /**
     * Add the field for file field
     * @return array
     */
    private function addFileFields(): array
    {

        return [
            'path' => '',
            'url' => ''
        ];
    }

    /**
     * @param array $field
     * @param string $type
     * @return string|null
     */
    private function getEntityType(array $field, string $type)
    {
        $name = null;
        switch ($field[$type]['type']) {

            case 'file':
                $name = FormBuilderConstants::FIELDS_ENTITY_PATH . ucfirst('files') . FormBuilderConstants::FIELD_CLASS_SUFFIX;
                break;

            default:
            case 'text':
                $name = FormBuilderConstants::FIELDS_ENTITY_PATH . ucfirst($type) . FormBuilderConstants::FIELD_CLASS_SUFFIX;

        }
        return $name;
    }

    /**
     * @param array $data
     * @return bool
     */
    private function isTaxonomy(array $data):bool
    {
        return isset($data['isTaxonomy']) ? true : false;
    }

    /**
     * Add technicalname (as table name) in taxonomy list configuration
     * @param $labels
     * @return false|int
     */
    public function handleTaxonomy($labels)
    {
        $path = FormBuilderConstants::TAXONOMY_CONFIG_DIRECTORY . '/taxonomy_list.json';
        if (!is_dir(FormBuilderConstants::TAXONOMY_CONFIG_DIRECTORY)) {

            mkdir(FormBuilderConstants::TAXONOMY_CONFIG_DIRECTORY);

            if (!file_exists($path)){

                $json  = json_encode (new stdClass, true);
                file_put_contents($path,$json);
            }
        }

        $fileContent = json_decode(file_get_contents($path), true);
        $index = is_array($fileContent) && count($fileContent) === 0 ? 1 : count($fileContent) + 1;
        $fileContent[$index] = $labels['contentTechnicalName'] . FormBuilderConstants::TAXO_TABLE_SUFFIX;

        return file_put_contents($path, json_encode($fileContent, true));
    }
}
