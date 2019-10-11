<?php

namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Requests\LoginRequest;
use Services\FlashMessages\FlashMessage;

class AdminController extends AbstractController
{
    //TEMPLATE
    const ADMIN_LOGIN_FORM = 'admin_login';
    const ADMIN_HOME = 'admin_home';
    const FRONT_NAMESPACE = 'Front\Controller';
    const FRONT_HOME = 'index';

    const SESSION_FIELDS = ['login', 'password'];

    public function index($options = [])
    {
        if(empty($_SESSION)) {
            $this->render(__NAMESPACE__, self::ADMIN_LOGIN_FORM, $options);
        }
    }

    /**
     *
     */
    public function login()
    {
        $options = [];
        //@TODO : à retirer test gge / toto
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            $formatedDatas = [];
            foreach (self::SESSION_FIELDS as $key) {
                $formatedDatas[$key] = sha1(htmlspecialchars($_POST[$key]));
            }

            $loginCheck = (new LoginRequest())->getLogin($formatedDatas);

            if(!empty($loginCheck)) {

                if ($formatedDatas['login'] == $loginCheck['login'] && $formatedDatas['password'] == $loginCheck['password']){
                    $options['flash-message'] = (new FlashMessage(
                        'Connexion Réussie',
                        'success'
                    ))->messageBuilder();
                    session_start();

                    $this->handleSessionFields($formatedDatas);

                    $this->render(__NAMESPACE__, self::ADMIN_HOME, $options);
                }else{
                    $this->errorLogin($options);
                }
            }else{
                $this->errorLogin($options);
            }
        }else{
            $this->errorLogin($options);
        }
    }

    public function logout(){

        if (!empty($_SESSION)){

            $this->handleSessionFields();
        }
        $options['flash-message'] = (new FlashMessage(
            'Déconnexion réussie !',
            'success'
        ))->messageBuilder();
        $this->render(self::FRONT_NAMESPACE, self::FRONT_HOME, $options);
    }

    private function handleSessionFields($data = null)
    {
        foreach (self::SESSION_FIELDS as $key) {
            $_SESSION[$key] = $data[$key] ?? null;
        }
        return $_SESSION;
    }

    private function errorLogin($options){
        $options['flash-message'] = (new FlashMessage(
            'Les accès sont incorrectes.',
            'error'
        ))->messageBuilder();
        $this->render(__NAMESPACE__, self::ADMIN_LOGIN_FORM, $options);
    }
}