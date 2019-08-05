<?php


namespace Admin\Controller;



use Admin\Core\Config\AbstractController;
use Admin\Core\Install\Builder\DatabaseBuilder;

class InstallController extends AbstractController
{
    public function indexForm($alert = [])
    {
        $this->render(__NAMESPACE__, 'installation_form', $alert);
    }

    /**
     *
     */
    public function checkInstall()
    {
        $installer = new DatabaseBuilder();
        $installer->form();

    }
}