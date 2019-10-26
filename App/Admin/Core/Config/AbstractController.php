<?php

namespace Admin\Core\Config;

class AbstractController
{
    const REG_CONTROLLER = '/Controller/';
    const VIEWS_PATH = 'Resources/Views/';
    const FRONT_DIR = 'Front/';
    const ADMIN_DIR = 'Admin/';
    const REGEX_IS_ADMIN = '/\b(Admin)\b/';


    /**
     * @var array
     */
    private $vars = [];

    public function addRenderOptions($options)
    {
        $this->vars['options'] = array_merge($this->vars, $options);
    }

    /**
     * @param $namespace
     * @param $filename
     */
    public function render($namespace, $filename, $options = [])
    {
        $this->addRenderOptions($options);
        // @TODO pas utilisé...
        $path = $this->handleNamespace($namespace);
        extract($this->vars);
        ob_start();
        require(ROOT . $this->handleNamespace($namespace)['newDir'] . $filename . '.phtml');
        // @TODO pas utilisé....
        $content_for_layout = ob_get_clean();
        require(ROOT . $this->chooseDirectory($namespace) . self::VIEWS_PATH . $this->getLayout($filename) . '.phtml');
    }

    private function secure_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    protected function secure_form($form)
    {
        foreach ($form as $key => $value)
        {
            $form[$key] = $this->secure_input($value);
        }
    }

    /**
     * Transform Controller Namespace to Views Path
     * @param $namespace
     * @return array
     */
    private function handleNamespace($namespace)
    {
        $path = str_replace('\\', '/', $namespace);

        $newDir = preg_replace(self::REG_CONTROLLER,self::VIEWS_PATH, $path );

        return [
            'path' => $path,
            'newDir' => $newDir
        ];
    }

    public function getLayout($filename = 'index'){

        return $filename;
    }

    /**
     *
     * @param $vars
     * @return string
     */
    private function chooseDirectory($vars):string
    {
        $modVars = str_replace('\\', '/',$vars);

        if(preg_match(self::REGEX_IS_ADMIN, $modVars)) {
            return self::ADMIN_DIR;
        }
        else{
            return self::FRONT_DIR;

        }
    }
}
