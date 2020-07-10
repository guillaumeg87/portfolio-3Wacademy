<?php

namespace Services\FrontManager;

use Admin\Requests\Content\ContentRequest;
use Services\Dumper\Dumper;
use Services\FormBuilder\Constants\FormBuilderConstants;
use Services\FormBuilder\Core\Requests\QueryBuilder;


class FrontManager
{
    const TYPE_QUERY = 'query';

    /**
     * @var QueryBuilder $queryBuilder
     */
    private $queryBuilder;


    /**
     * @var ContentRequest $contentRequest
     */
    private $contentRequest;

    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder();
        $this->contentRequest = new ContentRequest();

    }

    /**
     * @param array $params
     * @return array
     */
    public function getDatas(array $params): array
    {
        foreach ($params as $region => $zones) {
            if (is_array($zones)) {
                foreach ($zones as $zone => $value) {

                    if ($value['type'] === self::TYPE_QUERY) {

                        $sql = $this->queryBuilder->selectAllToFront($value['content']);
                        if (isset($value['sort']) && !empty($value['sort'])) {

                            $sql .= ' ORDER BY ' . $value['sort']['column'] . ' ' . $value['sort']['type'];
                        }
                        $params[$region][$zone]['data'] = $this->contentRequest->selectAll($sql);
                    }
                    if (isset($value['join']) && !empty($value['join'])) {

                        foreach ($value['join'] as $item => $val) {

                            $isTableExist = $this->contentRequest->isTableExist(['content_name' => $val . FormBuilderConstants::TAXO_TABLE_SUFFIX]);
                            if ($isTableExist) {

                                $params = $this->getLinkedTaxonomy($params, $region, $zone, $val);
                            }
                        }
                    }
                }
            }
        }

        return $params;
    }

    /**
     * Handle and agregate taxonomy to each content
     * @param $params
     * @param $region
     * @param $zone
     * @param $contentName
     * @return array
     */
    private function getLinkedTaxonomy(array $params, string $region, string $zone, string $contentName): array
    {

        foreach ($params[$region][$zone]['data'] as $key => $value) {

            foreach ($value as $k => $v) {
                if (is_string($v)) {
                    $taxolist = \explode(', ', $v);
                    if (is_array($taxolist)) {
                        foreach ($taxolist as $item => $id) {

                            if (preg_match('/' . $contentName . '/', $k)) {
                                $sql = $this->queryBuilder->selectOneToFront($contentName . FormBuilderConstants::TAXO_TABLE_SUFFIX,
                                    $id);
                                $params[$region][$zone]['data'][$key]['linked'][$contentName][] = $this->contentRequest->selectOne(
                                    ['id' => $id], $sql
                                );

                            }
                        }
                    }
                }
            }
        }

        return $params;
    }
}
