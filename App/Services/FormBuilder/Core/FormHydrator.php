<?php


namespace Services\FormBuilder\Core;


use Admin\Controller\ContentController;
use Admin\Core\QueryBuilder\QueryBuilder;
use Admin\Requests\Content\ContentRequest;
use Services\FormBuilder\Constants\FormBuilderConstants;


class FormHydrator
{
    const DATETIME_REGEX = '/^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$/';

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
        $suffix = null;

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

                    if ($index === 'select' || $index === 'entityReference') {

                        $queryBuilder = new QueryBuilder();
                        $query = null;

                        if ($queryBuilder instanceof QueryBuilder) {

                            $sql = $queryBuilder->buildSql(
                                [
                                    'content_name' => $arrayField['labelRef']
                                ],
                                'select_all');

                            $results = (new ContentRequest())->selectAll($sql);

                            $jsonToArray['fields'][$item][$index]['option'][] = $this->addDefaultValue($results);

                            if ($contentData && $index === 'entityReference'){

                                $jsonToArray = $this->checkedOptions($contentData, $jsonToArray, $item, $index);
                            }
                        }
                    }

                    if ($arrayField['name']) {
                        $jsonToArray['fields'][$item][$index]['value'] = $contentData[\strtolower($arrayField['name'])];
                    }

                    if (isset($arrayField[$arrayField['name'] . '_url']))  {
                        $jsonToArray['fields'][$item][$index][$arrayField['name'] . '_url'] = $contentData[$arrayField['name'] . '_url'];
                    }

                    if (isset($arrayField[$arrayField['name'] . '_path'])) {
                        $jsonToArray['fields'][$item][$index][$arrayField['name'] . '_path'] = $contentData[$arrayField['name'] . '_path'];

                    }
                    // Boolean checkbox
                    if ($arrayField['type'] === 'checkbox') {

                        if (!empty($contentData)){
                            $results = \preg_grep('/[A-Za-z]/', \array_keys($contentData));
                            foreach ($results as $key => $value) {
                                $jsonToArray['fields'][$item][$index]['value'] = \boolval($contentData[$value]);
                            }
                        }

                    }
                    // Datetime
                    if ($arrayField['type'] === 'date') {


                        foreach ($arrayField as $key => $value) {

                            if (\preg_match('/date/', $value) && preg_match(self::DATETIME_REGEX, $contentData[$value])) {

                                $date = \DateTime::createFromFormat('Y-m-d H:i:s', $contentData[$value]);
                                $jsonToArray['fields'][$item][$index]['value'] = $date->format('Y-m-d');
                            }
                        }
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

    /**
     * Get taxonomy value (multi select) saved in database and add param checked for each option
     * and set boolean values if the option is selected or not
     * @param array $contentData
     * @param array $jsonToArray
     * @param int $item
     * @param string $index
     * @return array
     */
    private function checkedOptions(array $contentData, array $jsonToArray, int $item, string $index ):array
    {
        $target = $jsonToArray['fields'][$item][$index]['name'];
        $values = \explode(',',$contentData[$target]);
        $options = $jsonToArray['fields'][$item][$index]['option'][0];

        foreach ($options as $key => $value) {
            if(\in_array($options[$key]['id'], $values)){
                $jsonToArray['fields'][$item][$index]['option'][0][$key]['checked'] = true;
            }else{
                $jsonToArray['fields'][$item][$index]['option'][0][$key]['checked'] = false;

            }
        }

        return $jsonToArray;
    }
}
