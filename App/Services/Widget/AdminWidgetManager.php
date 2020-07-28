<?php


namespace Services\Widget;

use Admin\Core\QueryBuilder\QueryBuilder;
use Admin\Requests\Content\ContentRequest;
use Services\FlashMessages\FlashMessage;
use Services\LogManager\LogConstants;
use Services\LogManager\LogManager;

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
                'Une erreur et survenue, veuillez consulter les logs',
                'error'
            ))->messageBuilder();
            (new LogManager())->log(
                '[ WIDGET MANAGER] An error occured when try to get this widget :  ' . $this->contentName .  PHP_EOL . $e->getTraceAsString(),
                LogConstants::ERROR_APP_LABEL,
                LogConstants::INFO_LABEL);
        }
        return $results;
    }
}
