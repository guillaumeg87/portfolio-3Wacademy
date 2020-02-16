<?php


namespace Services\ImagesManager;


class Image
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
     * @var string $tmp_name
     */
    private $tmp_name;

    /**
     * @var string $error
     */
    private $error;

    /**
     * @var string $size
     */
    private $size;


    public function __construct(array $datas)
    {
        $this->name     = $datas['name'];
        $this->type     = $datas['type'];
        $this->tmp_name = $datas['tmp_name'];
        $this->error    = $datas['error'];
        $this->size     = $datas['size'];
    }


    /**
     * Get Name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Image
     */
    public function setName($name): Image
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Type
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Image
     */
    public function setType($type): Image
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get TmpName
     * @return string
     */
    public function getTmpName()
    {
        return $this->tmp_name;
    }

    /**
     * @param mixed $tmp_name
     * @return Image
     */
    public function setTmpName($tmp_name): Image
    {
        $this->tmp_name = $tmp_name;
        return $this;
    }

    /**
     * Get Error
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     * @return Image
     */
    public function setError($error): Image
    {
        $this->error = $error;
        return $this;
    }

    /**
     * Get Size
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return Image
     */
    public function setSize($size): Image
    {
        $this->size = $size;
        return $this;
    }



}
