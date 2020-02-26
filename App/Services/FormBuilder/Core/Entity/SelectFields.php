<?php

namespace Services\FormBuilder\Core\Entity;


class SelectFields extends AbstractFields
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
     * @var int $idRef
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
    public function setName(string $name): SelectFields
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
    public function setOptions(string $options): SelectFields
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
    public function setClass(string $class): SelectFields
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
    public function setGroup(string $group): SelectFields
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Get LabelRef
     * @return string
     */
    public function getlabelRef(): int
    {
        return $this->labelRef;
    }

    /**
     * @param string $labelRef
     * @return SelectFields
     */
    public function setLabelRef(string $labelRef): SelectFields
    {
        $this->labelRef = $labelRef;
        return $this;
    }

    /**
     * Get IdRef
     * @return int
     */
    public function getIdRef(): int
    {
        return $this->idRef;
    }

    /**
     * @param int $idRef
     * @return SelectFields
     */
    public function setIdRef(int $idRef): SelectFields
    {
        $this->idRef = $idRef;
        return $this;
    }


}
