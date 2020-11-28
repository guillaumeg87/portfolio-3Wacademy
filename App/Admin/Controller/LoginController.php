<?php


namespace Admin\Controller;


use Admin\Core\Config\AbstractController;
use Admin\Requests\LoginRequest;
use Services\LogManager\LogConstants;

class LoginController extends AbstractController
{
    //TEMPLATE
    const ADMIN_LOGIN_FORM = 'admin_login';
    const ADMIN_HOME = 'admin_home';

    const SESSION_FIELDS = ['login', 'password', 'id', 'isSuperAdmin'];

    public function login($options = [])
    {
        $options['flash-message'] = [];

        $this->render(__NAMESPACE__, self::ADMIN_LOGIN_FORM, $options);
    }

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

                }
                else {

                    $formatedDatas[$key] = htmlspecialchars($_POST[$key]);
                }
            }

            $loginCheck = new LoginRequest();
            $isExist = $loginCheck->getLogin($formatedDatas);
            if (!empty($isExist)) {

                if ($formatedDatas['login'] === $isExist['login'] && $formatedDatas['password'] === $isExist['password']){
                    $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
                        'Connexion Réussie',
                        'success'
                    ))->messageBuilder();

                    //session_start();
                    $_SESSION = $this->handleSessionFields($isExist);

                    $this->redirectTo('/admin' , $options);

                   // $this->render(__NAMESPACE__, self::ADMIN_HOME, $options);
                }
                else {
                    $this->errorLogin($options, $formatedDatas);
                }
            }
            else {
                $this->errorLogin($options, $formatedDatas);
            }
        }
        else {
            $this->errorLogin($options, $_POST);
        }
    }

    /**
     * Main method for logout from Back office
     */
    public function logout(){
        session_start();
        if (!empty($_SESSION)){
            $_SESSION = [];

        }        // security improvement
            // avoid to come back to the previous page
            $param = session_get_cookie_params();
            setcookie(
                session_name(),
                $param['path'],
                $param['domain'],
                $param['secure'],
                $param['httponly']
            );

            session_unset ();
            session_destroy();

        $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
            'Déconnexion réussie !',
            'success'
        ))->messageBuilder();
        $this->getServiceManager()->getLogManager()->log(
            'User logout',
            LogConstants::ERROR_APP_LABEL,
            LogConstants::INFO_LABEL);
        $this->redirectTo('/login', $options);

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
        $_SESSION['LAST_REQUEST_TIME'] = time();
        return $_SESSION;
    }

    /**
     * Build response when login and pass word are wrong
     * @param $options
     */
    private function errorLogin(array $options, array $datas){
        $_SESSION = [];

        $this->getServiceManager()->getLogManager()->log(
            'Admin access: Bad credentials' .
            (isset($datas['login']) && !empty($datas['login']) ? 'with login: ' .  $datas['login'] : '') ,
            LogConstants::ERROR_APP_LABEL, LogConstants::WARN_LABEL
        );


        $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
            'Les accès sont incorrectes.',
            'error'
        ))->messageBuilder();
        $this->render(__NAMESPACE__, self::ADMIN_LOGIN_FORM, $options);
        exit;
    }
}
