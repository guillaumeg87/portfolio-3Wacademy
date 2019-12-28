<?php


namespace Services\FormBuilder\Core\Entity;


class AbstractFields extends AbstractBaseContentEntity
{

    /**
     * @var string $labelDisplay
     */
    private $labelDisplay;

    /**
     * Get LabelDisplay
     * @return string
     */
    public function getLabelDisplay(): string
    {
        return $this->labelDisplay;
    }

    /**
     * @param string $labelDisplay
     * @return AbstractFields
     */
    public function setLabelDisplay(string $labelDisplay): AbstractFields
    {
        $this->labelDisplay = $labelDisplay;
        return $this;
    }
}
