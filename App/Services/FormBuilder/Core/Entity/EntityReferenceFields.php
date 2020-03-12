<?php

namespace Services\FormBuilder\Core\Entity;


class EntityReferenceFields extends AbstractFields
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $options
     */
    private $options = [];

    /**
     * @var string $class
     */
    private $class;

    /**
     * @var string $group
     */
    private $group;

    /**
     * @var string $labelRef
     */
    private $labelRef;

    /**
     * @var string $idRef
     */
    private $idRef;

    /**
     * Get Name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SelectFields
     */
    public function setName(string $name): EntityReferenceFields
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Options
     * @return string
     */
    public function getOptions(): string
    {
        return $this->options;
    }

    /**
     * @param string $options
     * @return SelectFields
     */
    public function setOptions(string $options): EntityReferenceFields
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Get Class
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return SelectFields
     */
    public function setClass(string $class): EntityReferenceFields
    {
        $this->class = $class;
        return $this;
    }

    /**
     * Get Group
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param string $group
     * @return SelectFields
     */
    public function setGroup(string $group): EntityReferenceFields
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Get LabelRef
     * @return string
     */
    public function getlabelRef(): string
    {
        return $this->labelRef;
    }

    /**
     * @param string $labelRef
     * @return SelectFields
     */
    public function setLabelRef(string $labelRef): EntityReferenceFields
    {
        $this->labelRef = $labelRef;
        return $this;
    }

    /**
     * Get IdRef
     * @return int
     */
    public function getIdRef(): string
    {
        return $this->idRef;
    }

    /**
     * @param int $idRef
     * @return SelectFields
     */
    public function setIdRef(string $idRef): EntityReferenceFields
    {
        $this->idRef = $idRef;
        return $this;
    }


}
