<?php


namespace Admin\Controller;


use Admin\Core\Config\AbstractController;
use Admin\Requests\LoginRequest;
use Services\Dumper\Dumper;


class LoginController extends AbstractController
{
    //TEMPLATE
    const ADMIN_LOGIN_FORM = 'admin_login';
    const ADMIN_HOME = 'admin_home';
    const FRONT_NAMESPACE = 'Front\Controller';
    const FRONT_HOME = 'index';

    const SESSION_FIELDS = ['login', 'password'];

    /**
     * Main method for login in Back office
     */
    public function checkLogin()
    {
        $options = [];
        if (!empty($_POST['login']) && !empty($_POST['password'])) {
            $formatedDatas = [];
            foreach (self::SESSION_FIELDS as $key) {
                if($key === 'password'){

                    $formatedDatas[$key] = sha1(htmlspecialchars($_POST[$key]));

                }else{

                    $formatedDatas[$key] = htmlspecialchars($_POST[$key]);
                }
            }

            $loginCheck = new LoginRequest();
            $isExist = $loginCheck->getLogin($formatedDatas);
            if(!empty($isExist)) {

                if ($formatedDatas['login'] == $isExist['login'] && $formatedDatas['password'] == $isExist['password']){
                    $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
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

    /**
     * Main method for logout from Back office
     */
    public function logout(){

        session_start();
        if (!empty($_SESSION)){
            session_destroy();

            $this->handleSessionFields();
        }
        $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
            'Déconnexion réussie !',
            'success'
        ))->messageBuilder();

        $this->render(__NAMESPACE__, self::ADMIN_LOGIN_FORM, $options);
        die;
    }

    /**
     * Helper which handle SESSION array when administrator login
     * @param null $data
     * @return mixed
     */
    private function handleSessionFields($data = null):?array
    {
        foreach (self::SESSION_FIELDS as $key) {
            $_SESSION[$key] = $data[$key] ?? null;
        }

        return $_SESSION;
    }

    /**
     * Build response when login and pass word are wrong
     * @param $options
     */
    private function errorLogin($options){
        $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
            'Les accès sont incorrectes.',
            'error'
        ))->messageBuilder();
        $this->render(__NAMESPACE__, self::ADMIN_LOGIN_FORM, $options);
    }
}
