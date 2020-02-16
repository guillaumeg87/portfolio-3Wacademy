<?php

namespace Services\FormBuilder\Core\Entity;


class FilesFields extends AbstractFields
{

    const FILE_URL_LABEL = 'url';
    const FILE_PATH_LABEL = 'path';

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $type
     */
    private $type;

    /**
     * @var string $group
     */
    private $group;

    /**
     * @var string $path
     */
    private $path;

    /**
     * @var string $url
     */
    private $url;

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
     * @return FilesFields
     */
    public function setName(string $name): FilesFields
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
     * @return FilesFields
     */
    public function setType(string $type): FilesFields
    {
        $this->type = $type;
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
     * @return FilesFields
     */
    public function setGroup(string $group): FilesFields
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Get Path
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return FilesFields
     */
    public function setPath(string $path): FilesFields
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get Url
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return FilesFields
     */
    public function setUrl(string $url): FilesFields
    {
        $this->url = $url;
        return $this;
    }


}
