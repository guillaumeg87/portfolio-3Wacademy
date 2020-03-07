<?php


namespace Services\Templating\Engine;

use Services\FlashMessages\FlashMessage;

class TemplateEngine
{
    /**
     * @var array $tags
     */
    private $tags;

    /**
     * @var string $templateFile
     */
    private $templateFile;

    public function __construct($templateFile)
    {
        $this->templateFile = $this->getFile($templateFile);

        if (!$this->templateFile) {
            return (new FlashMessage(
                'Impossible de charger ce template : '. $templateFile,
                'error'
            ))->messageBuilder();
        }
    }

    /**
     * @param $file
     * @return bool|false|string
     */
    public  function getFile($file)
    {
        if (file_exists($file)) {
            return  file_get_contents($file);
        }
        else {
            return false;
        }
    }

    /**
     * Helper to set up the tags and values
     * @param $tag
     * @param $value
     */
    public function setTags($tag, $value)
    {
        $this->tags[$tag] = $value;
    }

    /**
     * This function replace double bracket in template
     * @return bool
     */
    public function replaceTags()
    {
        $key =  "";
        foreach ($this->tags as $tag => $value){

            if (is_array($value)){
                $key .= $tag;
                $this->templateFile = $this->embricatedDatas($key, $value);
            }
        }


        return true;
    }

    /**
     * Used for displaying te template
     */
    public function engineRender()
    {
        $this->replaceTags();

        echo $this->templateFile;
    }

    /**
     * Replace double bracket and key in template by their value
     * /!\ WARNING : Recursive function /!\
     * @param $key
     * @param $array
     * @return bool|false|mixed|string
     */
    private function embricatedDatas($key, $array)
    {
        foreach ($array as $tag => $value){

            if (is_array($value)){

                $key .= $tag;
                $this->embricatedDatas($key, $value);

            }
            elseif (is_string($value)) {

                $key .= '.' . $tag;
            }

            $this->templateFile = str_replace('{{ ' . $key . ' }}', $value, $this->templateFile);
        }
        return  $this->templateFile;
    }
}
