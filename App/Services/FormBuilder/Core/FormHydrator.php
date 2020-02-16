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
            if (!empty($contentData)) {
                $tempFile = $this->generateTemporaryJson($contentData);
                if (!empty($tempFile)) {

                    return $this->fileGeneration($tempFile);
                }
            }
        } catch (\Exception $e) {
            throw new \Exception();
        }
        return false;
    }

    /**
     * @param $contentData
     * @return string|null
     */
    private function generateTemporaryJson($contentData): ?string
    {
        $json = file_get_contents(FormBuilderConstants::CUSTOM_CONFIG_DIRECTORY . $this->content['content_name'] . '.json');
        $jsonToArray = null;
        if ($json) {
            $jsonToArray = json_decode($json);

            $jsonToArray = $this->hiddenFieldId($contentData['id'], $jsonToArray);

            foreach ($jsonToArray->fields as $item) {

                foreach ($item as $index => $arrayField) {
                    if ($arrayField->name) {

                        $arrayField->value = $contentData[strtolower($arrayField->name)];
                    }
                    if (isset($arrayField->url)) {

                        $arrayField->url = $contentData['url'];
                    }
                    if (isset($arrayField->path)) {

                        $arrayField->path = $contentData['path'];
                        $arrayField->value = 'bbang.jpeg';
                    }
                }
            }
        }
        if (!empty($jsonToArray)) {
            return json_encode($jsonToArray);
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
        array_push($jsonToArray->fields, $hidden);
        return $jsonToArray;
    }

    /**
     * @param $fileData
     * @return bool
     */
    private function fileGeneration($fileData): bool
    {
        if (!file_exists(FormBuilderConstants::CUSTOM_TEMPORARY_CONFIG_DIRECTORY)) {
            mkdir(FormBuilderConstants::CUSTOM_TEMPORARY_CONFIG_DIRECTORY, 0777, true);
        }
        $path = FormBuilderConstants::CUSTOM_TEMPORARY_CONFIG_DIRECTORY . $this->content['content_name'] . '.json';

        $isCreated = file_put_contents($path, $fileData);
        return (is_int($isCreated) ?? false);
    }
}
