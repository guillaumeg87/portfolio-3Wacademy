<?php
namespace Services\MenuManager\Requests;

use Admin\Core\Traits\RequestDateTrait;
use Admin\Requests\BaseRequest;
use Services\FormBuilder\Constants\FormBuilderConstants;

class ContentRequest extends BaseRequest
{
    use RequestDateTrait;
    const TABLE_NAME = 'menu';

    public function getMenuEntryList()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE -1";
        $query = $this->dbManager->connection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function createMenuEntry(array $data, bool $isTaxonomy)
    {
        $contentTechnicalName = $isTaxonomy ? $data['contentTechnicalName'] . FormBuilderConstants::TAXO_TABLE_SUFFIX : $data['contentTechnicalName'];
        $sql = "INSERT INTO " . self::TABLE_NAME . " (contentTechnicalName, contentDisplayName, createAt) VALUES (:technical, :display, :createAt)";
        $query = $this->dbManager->connection()->prepare($sql);

        return $query->execute([
            'technical' => $contentTechnicalName,
            'display'   => $data['contentDisplayName'],
            'createAt'  => $this->createAt(),
        ]);
    }

    public function isExist(array $data)
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE contentTechnicalName = :technical";
        $query = $this->dbManager->connection()->prepare($sql);
        $query->execute([
            'technical' => $data['contentTechnicalName'],
        ]);

        return $query->fetch();
    }
}
