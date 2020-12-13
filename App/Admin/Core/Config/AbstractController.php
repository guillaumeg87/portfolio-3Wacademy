<?php

namespace Admin\Core\Config;


use Admin\Core\Entity\SessionManager;
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

use NavigationTrait;

    /**
     * @var array
     */
    private $vars = [];

    /**
     * @param $options
     */
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
     * @param array $options
     */
    public function render($namespace, $filename, $options = [])
    {
        $this->addRenderOptions($options);

        extract($this->vars);
        ob_start();

        require(ROOT . $this->handleNamespace($namespace)['newDir'] . $filename . '.phtml');
        ob_get_clean();
        require(ROOT . $this->chooseDirectory($namespace) . self::VIEWS_PATH . $this->getLayout($filename) . '.phtml');

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

    public function getSessionManager (){
        return new SessionManager();
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder();
    }

    public function isSessionActive()
    {
        $this->getSessionManager();
        $this->getSessionManager()->getSession();

        $flashMessage = ($this->getServiceManager()->getFlashMessage(
            'Session expirée, veuillez vous connecter pour accéder à l\'admin',
            'error'
        ))->messageBuilder();

        if ((!isset($_SESSION['LAST_REQUEST_TIME']) || $_SESSION === []) ) {

            $_SESSION = [];
            $options['flash-message'][] = $flashMessage;
            $this->redirectTo('/login-form', $options);

        } elseif (isset($_SESSION['LAST_REQUEST_TIME']) && ((time() - $_SESSION['LAST_REQUEST_TIME']) > CoreConstants::SESSION_DURATION)){
            session_destroy();
            $_SESSION = [];
            $options['flash-message'][] = $flashMessage;
            $this->redirectTo('/login-form', $options);
        }
    }

    /**
     * Redirection function
     * Allow to send flash-message to other controller with the key 'flash-message'
     * @param string $path
     * @param array $options
     */
    public function redirectTo(string $path, $options = []) {

        if (isset($options['flash-message']) && !empty($options['flash-message'])) {
            $_SESSION['flash-message'] = $options['flash-message'];
        }
        header_remove();
        header('Location: ' . $path, true, 301);

    }
}
