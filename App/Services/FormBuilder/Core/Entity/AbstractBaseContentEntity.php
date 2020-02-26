<?php

namespace Services\FormBuilder\Core\Entity;

use Services\Dumper\Dumper;

class AbstractBaseContentEntity
{
    /**
     * @var integer $id
     */
    private $uid;

    /**
     * @var array $fields
     */
    private $fields = [];

    /**
     * @var \DateTime $createdAt
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     */
    private $updatedAt;

    /**
     * Get Id
     * @return int
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * @param int $id
     * @return AbstractBaseContentEntity
     */
    public function setUid(int $uid): AbstractBaseContentEntity
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * Get Fields
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return AbstractBaseContentEntity
     */
    public function setFields(array $fields): AbstractBaseContentEntity
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * Get CreatedAt
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return AbstractBaseContentEntity
     */
    public function setCreatedAt(\DateTime $createdAt): AbstractBaseContentEntity
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get UpdatedAt
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return AbstractBaseContentEntity
     */
    public function setUpdatedAt(\DateTime $updatedAt): AbstractBaseContentEntity
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Helper for set an abject from datas array
     *
     * @param $datas
     * @param string $type
     * @return $this
     */
    public function arrayToObject($datas, $type = 'get'): AbstractBaseContentEntity
    {

        foreach ($datas as $key => $value){

            $method = $type . ucfirst($key);
            if(method_exists($this, $method)){

                $this->$method($value);
            }
        }

        return $this;
    }
}
