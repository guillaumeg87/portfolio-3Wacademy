<?php

namespace Services\FormBuilder\Core\Entity;


class RadioFields extends AbstractFields
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $type
     */
    private $type;

    /**
     * @var string $class
     */
    private $class;

    /**
     * @var string $value
     */
    private $value ='';

    /**
     * @var string $group
     */
    private $group;

    /**
     * @var int $contentRef
     */
    private $contentRef;

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
     * @return InputFields
     */
    public function setName(string $name): RadioFields
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Type
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return CheckboxFields
     */
    public function setType(string $type): RadioFields
    {
        $this->type = $type;
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
     * @return InputFields
     */
    public function setClass(string $class): RadioFields
    {
        $this->class = $class;
        return $this;
    }

    /**
     * Get Value
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return TextareaFields
     */
    public function setValue(string $value): RadioFields
    {
        $this->value = $value;
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
     * @return InputFields
     */
    public function setGroup(string $group): RadioFields
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Get ContentRef
     * @return int
     */
    public function getContentRef(): int
    {
        return $this->contentRef;
    }

    /**
     * @param int $contentRef
     * @return InputFields
     */
    public function setContentRef(int $contentRef): RadioFields
    {
        $this->contentRef = $contentRef;
        return $this;
    }


}
