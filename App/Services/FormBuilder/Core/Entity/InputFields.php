<?php

namespace Services\FormBuilder\Core\Entity;


class InputFields extends AbstractFields
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
     * @var string $placeholder
     */
    private $placeholder ='';

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
    public function setName(string $name): InputFields
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
     * @return InputFields
     */
    public function setType(string $type): InputFields
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
    public function setClass(string $class): InputFields
    {
        $this->class = $class;
        return $this;
    }

    /**
     * Get Placeholder
     * @return string
     */
    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     * @return InputFields
     */
    public function setPlaceholder(string $placeholder): InputFields
    {
        $this->placeholder = $placeholder;
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
    public function setGroup(string $group): InputFields
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
    public function setContentRef(int $contentRef): InputFields
    {
        $this->contentRef = $contentRef;
        return $this;
    }


}
