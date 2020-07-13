<?php


namespace Services\Widget;

use Admin\Core\QueryBuilder\QueryBuilder;
use Admin\Requests\Content\ContentRequest;
use Services\FlashMessages\FlashMessage;

class AdminWidgetManager
{
    const SELECT_ALL = 'select_all';
    /**
     * @var $contentData string
     */
    private $contentName;

    public function __construct(string $contentName)
    {
        $this->contentName = $contentName;
    }

    /**
     * @return array
     */
    public function getElementList(): array
    {
        $results = [];
        try {
            $queryBuilder = new QueryBuilder();
            $params['content_name'] = $this->contentName;

            $sql = $queryBuilder->buildSql($params, self::SELECT_ALL);

            $request = new ContentRequest();

            $isList = $request->selectAll($sql);
            if(!empty($isList)){
                $results = $isList;
            }
        } catch (\Exception $e) {
            $results['flash-message'][] = (new FlashMessage(
                'ERROR : ' . '</br>' .
                'Code : ' . $e->getCode() .
                'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                'Message : ' . $e->getMessage() . '</br>' .
                'Line : ' . $e->getLine() . '</br>',
                'error'
            ))->messageBuilder();
        }
        return $results;
    }
}
