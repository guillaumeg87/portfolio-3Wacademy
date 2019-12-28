<?php

namespace Services\FormBuilder\Core\Entity;


class TextareaFields extends AbstractFields
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $class
     */
    private $class;

    /**
     * @var string $placeholder
     */
    private $placeholder ='';

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
    public function setName(string $name): TextareaFields
    {
        $this->name = $name;
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
    public function setClass(string $class): TextareaFields
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
    public function setValue(string $value): TextareaFields
    {
        $this->value = $value;
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
    public function setPlaceholder(string $placeholder): TextareaFields
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
    public function setGroup(string $group): TextareaFields
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
    public function setContentRef(int $contentRef): TextareaFields
    {
        $this->contentRef = $contentRef;
        return $this;
    }


}
