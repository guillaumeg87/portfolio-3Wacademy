<?php


namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Core\Install\Builder\DatabaseBuilder;


class InstallController extends AbstractController
{
    const REGEX_EMAIL = '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/';
    const FORM_ADMIN_FIELDS = ['login', 'pwd', 'email', 'isSuperAdmin'];

    /**
     * Index Installation form
     * @param array $alert
     */
    public function indexForm($alert = [])
    {
        $this->redirectTo('/installation');
    }

    /**
     * Init Project Installation
     */
    public function startInstall()
    {

        $installer = new DatabaseBuilder();
        $email = $_POST['email'];

        if (preg_match(self::REGEX_EMAIL,$email)) {

            $installer->form();

        }
        else {
            $options['flash-message'] = ($this->getServiceManager()->getFlashMessage(
                'L\'adresse mail est incorrecte, veuillez vérifier',
                'error'
            ))->messageBuilder();

            foreach (self::FORM_ADMIN_FIELDS as $key) {
                $options['data'][$key] = $_POST[$key] ?? true;
            }
            $this->redirectTo('/installation');
        }
    }
}
