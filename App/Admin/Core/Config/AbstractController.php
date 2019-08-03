<?php

namespace Admin\Core;

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

    public function set($d)
    {
        $this->vars = array_merge($this->vars, $d);
    }

    /**
     * @param $namespace
     * @param $filename
     */
    public function render($namespace, $filename)
    {

        $path = $this->handleNamespace($namespace);
        extract($this->vars);
        ob_start();
        require(ROOT . $this->handleNamespace($namespace)['newDir'] . $filename . '.phtml');
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
