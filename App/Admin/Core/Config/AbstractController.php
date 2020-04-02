<?php

namespace Admin\Core\Config;


use Admin\Controller\AdminController;
use Admin\Core\QueryBuilder\QueryBuilder;
use Admin\Core\Traits\NavigationTrait;
use Services\FlashMessages\FlashMessage;
use Services\ServiceManager\ServiceManager;


class AbstractController
{
    const REG_CONTROLLER = '/Controller/';
    const VIEWS_PATH = 'Resources/Views/';
    const FRONT_DIR = 'Front/';
    const ADMIN_DIR = 'Admin/';
    const REGEX_IS_ADMIN = '/\b(Admin)\b/';
    const ADMIN_CONTROLLER_NAMESPACE = 'Admin/Controller/';

use NavigationTrait;

    /**
     * @var array
     */
    private $vars = [];

    public function addRenderOptions($options)
    {
        if(!$this->getNavigation() instanceof FlashMessage){
            $options['navigation'] = $this->getNavigation();
        }else{
            $this->vars['options'][] = $this->getNavigation();
        }
        $this->vars['options'] = array_merge($this->vars, $options);
    }

    /**
     * @param $namespace
     * @param $filename
     */
    public function render($namespace, $filename, $options = [])
    {
        $this->addRenderOptions($options);

/* ********************************* */
        /*
        $engine = $this->getEngine(ROOT . $this->handleNamespace($namespace)['newDir'] . $filename . '.phtml');
        $engine->setTags('options', $options);

        $engine->engineRender();
        $engine->replaceTags();
*/
/* ********************************* */
        extract($this->vars);
        ob_start();

        require(ROOT . $this->handleNamespace($namespace)['newDir'] . $filename . '.phtml');
        ob_get_clean();
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

        if (preg_match(self::REGEX_IS_ADMIN, $modVars)) {

            return self::ADMIN_DIR;
        }
        else{
            return self::FRONT_DIR;

        }
    }

    /**
     * @return ServiceManager
     */
    public function getServiceManager():ServiceManager
    {
        return new ServiceManager();
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder();
    }

    /**
     * @param $options
     */
    public function isSessionActive()
    {
        session_start();
        $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
            'Session expirée, veuillez vous connecter pour accéder à l\'admin',
            'error'
        ))->messageBuilder();
        if ($_SESSION !== [] && !isset($_SESSION['LAST_REQUEST_TIME'])) {
            if (time() - $_SESSION['LAST_REQUEST_TIME'] > CoreConstants::SESSION_DURATION) {

                $_SESSION = [];
                session_destroy();


                $this->render(self::ADMIN_CONTROLLER_NAMESPACE, AdminController::ADMIN_LOGIN_FORM, $options);
                exit;
            }
        }
        elseif (!isset($_SESSION['LAST_REQUEST_TIME']) && !isset($_SESSION['login'])){
            $this->render(self::ADMIN_CONTROLLER_NAMESPACE, AdminController::ADMIN_LOGIN_FORM, $options);
            exit;
        }

    }
}
