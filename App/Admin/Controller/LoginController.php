<?php


namespace Admin\Controller;


use Admin\Core\Config\AbstractController;
use Admin\Requests\LoginRequest;
use Services\LogManager\LogConstants;

class LoginController extends AbstractController
{
    //TEMPLATE
    const ADMIN_LOGIN_FORM = 'admin_login';

    const SESSION_FIELDS = ['login', 'password', 'id', 'isSuperAdmin'];

    public function login($options = [])
    {
        $options['deletePHP_SESSION_ID'] = true;
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
                    if (isset($_POST[$key])){
                        $formatedDatas[$key] = htmlspecialchars($_POST[$key]);
                    }
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

                    //session_set_cookie_params(time() + 300,'/','',false,false);

                    $this->getSessionManager()->createSession();
                    $this->getSessionManager()->setSession($this->handleSessionFields($isExist));

                    $token = sha1(mt_rand(1, 90000) . 'SALT');

                    setcookie(
                        'PHPSESSID',
                        $token,
                        time()+300
                    );

                    $this->redirectTo('/admin' , $options);
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

        $this->getSessionManager()->removeSession();

        $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
            'Déconnexion réussie !',
            'success'
        ))->messageBuilder();
        $this->getServiceManager()->getLogManager()->log(
            'User logout',
            LogConstants::ERROR_APP_LABEL,
            LogConstants::INFO_LABEL);
        $options['deletePHP_SESSION_ID'] = true;
        $this->redirectTo('/login-form', $options);

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
