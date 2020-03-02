<?php


namespace Services\FormBuilder\Core;


use Admin\Controller\ContentController;
use Admin\Core\QueryBuilder\QueryBuilder;
use Admin\Requests\Content\ContentRequest;
use Services\FormBuilder\Constants\FormBuilderConstants;


class FormHydrator
{

    /**
     * @var array $content
     */
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function buildTemporaryConfiguration(): bool
    {

        $queryBuilder = new QueryBuilder();
        $contentData = null;
        try {
            $sql = $queryBuilder->buildSql($this->content, ContentController::SELECT_ONE_LABEL);
            $request = new ContentRequest();

            $contentData = $request->selectOne($this->content, $sql);
            $tempFile = $this->generateTemporaryJson($contentData);

            if (!empty($tempFile)) {

                return $this->fileGeneration($tempFile);
            }

        } catch (\Exception $e) {
            throw new \Exception();
        }
        return false;
    }

    /**
     * @param $contentData
     * @return string|null
     * @throws \Exception
     */
    private function generateTemporaryJson($contentData): ?string
    {
        $json = \file_get_contents(FormBuilderConstants::CUSTOM_CONFIG_DIRECTORY . $this->content['content_name'] . '.json');
        $jsonToArray = null;
        if ($json) {
            $jsonToArray = \json_decode($json, true);

            $jsonToArray = $this->hiddenFieldId($contentData['id'], $jsonToArray);

            foreach ($jsonToArray['fields'] as $item => $fieldConf) {

                foreach ($fieldConf as $index => $arrayField) {
                    if ($index === 'select'){

                        $queryBuilder = new QueryBuilder();
                        $query = null;

                        if($queryBuilder instanceof QueryBuilder){

                            $sql = $queryBuilder->buildSql(
                                [
                                    'content_name' => $arrayField['labelRef']
                                ],
                                'select_all');

                            $results = (new ContentRequest())->selectAll($sql);

                            $jsonToArray['fields'][$item][$index]['option'][] = $this->addDefaultValue($results);
                        }
                    }
                    if ($arrayField['name']) {

                        $jsonToArray['fields'][$item][$index]['value'] = $contentData[\strtolower($arrayField['name'])];
                    }
                    if (isset($arrayField['url'])) {

                        $jsonToArray['fields'][$item][$index]['url'] = $contentData['url'];
                    }
                    if (isset($arrayField['path'])) {

                        $jsonToArray['fields'][$item][$index]['path'] = $contentData['path'];
                        //$jsonToArray['fields'][$item][$index]['base64'] = $this->toBase64($contentData['url']);

                    }

                }
            }
        }

        if (!empty($jsonToArray)) {
            return \json_encode($jsonToArray);
        }
        return $jsonToArray;
    }

    /**
     * Add input hidden field with content ID from database
     * Needed for content update
     *
     * @param $id string
     * @param $jsonToArray
     * @return array
     */
    private function hiddenFieldId($id, $jsonToArray)
    {

        $hidden = [
            'input' => [
                'type' => 'hidden',
                'name' => 'id',
                'id' => '',
                'class' => '',
                'value' => $id,
                'group' => 'admin-form',
            ]
        ];
        \array_push($jsonToArray['fields'], $hidden);
        return $jsonToArray;
    }

    /**
     * @param $fileData
     * @return bool
     */
    private function fileGeneration($fileData): bool
    {
        if (!\file_exists(FormBuilderConstants::CUSTOM_TEMPORARY_CONFIG_DIRECTORY)) {
            \mkdir(FormBuilderConstants::CUSTOM_TEMPORARY_CONFIG_DIRECTORY, 0777, true);
        }
        $path = FormBuilderConstants::CUSTOM_TEMPORARY_CONFIG_DIRECTORY . $this->content['content_name'] . '.json';

        $isCreated = \file_put_contents($path, $fileData);
        return (\is_int($isCreated) ?? false);
    }

    /**
     * @param array $options
     * @return array
     */
    private function addDefaultValue(array $options):array
    {
        \array_unshift($options, FormBuilderConstants::DEFAULT_VALUES);

        return $options;
    }

    /**
     * @param string $url
     * @return string
     */
    private function toBase64(string $url):string
    {
        return \base64_encode(\file_get_contents($url));
    }
}
