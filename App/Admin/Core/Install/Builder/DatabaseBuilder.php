<?php

namespace Admin\Core\Install\Builder;

use Admin\Controller\AdminController;
use Admin\Controller\InstallController;
use Admin\Core\Traits\Hash;
use Admin\Requests\InstallRequest;
use Connection\Db_manager;
use mysql_xdevapi\Exception;
use PDO;
use PDOException;
use Services\FlashMessages\FlashMessage;
use Services\Mailer\MailerService;

class DatabaseBuilder
{
    use Hash;

    const DB_INSTALL = ['Db_name', 'Db_host', 'Db_admin', 'Db_password'];
    const USER_TECHNICAL_NAME = 'user_settings';
    const USER_DISPLAY_NAME = 'Utilisateur';
    const USER_FIELDS_TABLE = ['login', 'pwd', 'email', 'isSuperAdmin', 'createdAt', 'updatedAt'];
    const USER_MENU_COLUMS = [
        'contentTechnicalName' => self::USER_TECHNICAL_NAME,
        'contentDisplayName' => self::USER_DISPLAY_NAME,
    ];
    const LABEL_PWD = 'pwd';
    const FILE_DB_CONF = '../Connection/DB_conf.php';
    const JSON_FILE_DB_CONF = '../Connection/Db_config.json';

    // Two constants below needed for class dynamically
    const FILE_START =
'<?php 

namespace Connection;

final class DB_conf
{
';
    const FILE_END =
'
}
';

    /**
     * Handle installation form datas
     * Build two array for each entty needed : admin and db datas
     * Get data from Install form
     */
    public function form()
    {
        if (!empty($_POST)) {
            $data = [];

            foreach ($_POST as $key => $value) {
                if (in_array($key, self::USER_FIELDS_TABLE)) {
                    if ($key == self::LABEL_PWD) {
                        $admin[$key] = $this->hashString($value);
                    } else {
                        $admin[$key] = $value;
                    }
                }

                if ($key != 'private') {
                    $data[strtoupper($key)] = $value;
                }
            }

            // Delete Admin acces before Write database config in file
            foreach ($admin as $key => $value) {
                unset($data[strtoupper($key)]);
            }


            $this->init_param($data, $admin);
        }

    }

    /**
     * Init params database buildings
     * Create Class DB_conf.php && handle json configuration file
     * @param $param
     * @param $admin
     */
    public function init_param(array $param, array $admin)
    {
        $db_data = array_combine(self::DB_INSTALL, $param);

        /** PHP CONSTANT CLASS DATABASE CONFIG **/
        $this->generateConstantClassConf($db_data);

        /** JSON DATABASE CONFIG **/
        $this->generateJsonConfigFile($db_data);
        sleep(2);
        $this->prepareBuild($admin, $db_data);
    }

    /**
     * Process Installation
     * Building preparation
     * @param $admin
     * @param $db_data
     */
    public function prepareBuild(array $admin, array $db_data)
    {


        try {
            $this->builder($admin, $db_data);

        } catch (\Exception $e) {
            $this->installationFailed($e, $db_data);
        }
    }

    /**
     * Process Installation
     * Creation database
     * If an error occured, Rollback function are called
     *
     * @param $admin array
     * @param $db_data
     * @return void
     */
    private function builder($admin, $db_data)
    {
        try {
            // Create Database
            $connection = new \PDO("mysql:host=" . $db_data['Db_host'], $db_data['Db_admin'], $db_data['Db_password']);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE IF NOT EXISTS " . $db_data['Db_name'];
            $connection->exec($sql);
            $isCreate = $this->createDataBase($db_data);

            if ($isCreate) {

                $request = new InstallRequest();
                $request->createUserTable($db_data);
                $request->createMenuEntryTable($db_data);

                $request->addUserEntryInMenu(array_merge(
                    self::USER_MENU_COLUMS,
                    ['createdAt' => (new \DateTime())->format('Y-m-d H:m:i'),
                        'updatedAt' => null
                    ]));
                $superAdmin = array_merge($admin, ['isSuperAdmin' => true]);
                $this->saveAdmin($request, $superAdmin, $db_data);
            }
            $options['flash-message'][] = (new FlashMessage(
                "DB created successfully",
                'success'
            ))->messageBuilder();

        } catch (\Exception $e) {

            $this->installationFailed($e, $db_data);

        }


        // Send mail
       /*
        * @TODO A VOIR PLUS TARD : a ecxecuter avec npm run watch qui tourne...
        * https://hub.docker.com/r/djfarrelly/maildev/
        * */
/*
        $user = new User();
        $user->setEmail($admin['email']);
        $user->setLogin($admin['login']);
        $user->setPwd($admin['pwd']);
        $to = $user;
        $subject = 'TEST MAILER';
        $message = 'Bonjour,  je teste mon service d\'envoi de mail';
        try{
            $mailer = (new MailerService($to, $subject, $message))->sendMail();
            var_dump($mailer);
            if($mailer){
                $options['flash-message'][] = (new FlashMessage(
                    "Le mail a été envoyé",
                    'success'
                ))->messageBuilder();
            }else{
                $options['flash-message'][] = (new FlashMessage(
                    "Le mail n'a pas été envoyé",
                    'error'
                ))->messageBuilder();
            }
        }catch(\Exception $e){
            throw new Exception(
                'ERROR : ' . '</br>' .
                'Code : ' . $e->getCode() .
                'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                'Message : ' . $e->getMessage() . '</br>' .
                'Line : ' . $e->getLine() . '</br>'
            );

        }
*/
        $admin = new AdminController();
        $admin->index([]);
    }

    /**
     * Process Installation
     * Admin account creation
     * @param InstallRequest $request
     * @param $admin array
     * @param array $db_data
     */
    public function saveAdmin(InstallRequest $request, array $admin, array $db_data)
    {

        try {
            $request->createAdminAccount($admin);

        } catch (PDOException $e) {

            $this->installationFailed($e, $db_data);

        }
    }

    /**
     * Process Installation
     * Rollback function if an error occured
     *
     * @param $e
     * @return void
     */
    private function installationFailed(\Exception $e, array $db_data)
    {

        $sql = "DROP DATABASE " . $db_data['Db_name'];
        try {
            $connection = new \PDO("mysql:host=" . $db_data['Db_host'], $db_data['Db_admin'], $db_data['Db_password']);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->exec($sql);
        } catch (\Exception $exception) {
            throw new Exception(
                'ERROR : ' . '</br>' .
                'Code : ' . $e->getCode() .
                'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                'Message : ' . $e->getMessage() . '</br>' .
                'Line : ' . $e->getLine() . '</br>'
            );
        }

        $options['flash-message'] = (new FlashMessage(
            'ERROR : ' . '</br>' .
            'Code : ' . $e->getCode() .
            'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
            'Message : ' . $e->getMessage() . '</br>' .
            'Line : ' . $e->getLine() . '</br>',
            'error'
        ))->messageBuilder();
        // Deletion of the 2 generated files
        /** Don't delete PHP file configuration, reset values to null for each attibute */
        //unlink(Constants::FILE_DB_CONF);
        $this->generateConstantClassConf(array_combine(self::DB_INSTALL, [null, null, null, null]));
        unlink(self::JSON_FILE_DB_CONF);

        header('Location: /');
        header_remove();

    }

    /**
     * Process Installation
     * Use for check keep project configuration in one file
     * @param $db_data
     */
    private function generateJsonConfigFile(array $db_data)
    {
        foreach ($db_data as $key => $value) {
            $jsonArray['Database'][$key] = $db_data[$key];
        }

        $jsonData = json_encode($jsonArray);

        file_put_contents(self::JSON_FILE_DB_CONF, $jsonData);
    }

    /**
     * Process Installation
     * Fast and easiest than Json encode and decode
     * @param $param
     */
    private function generateConstantClassConf(array $param)
    {
        $config_file = [];

        foreach ($param as $key => $value) {

            $config_file[] = "const " . strtoupper($key) . " = '" . $value . "';\r\n";
        }

        $path_to_wp_config = self::FILE_DB_CONF;
        $handle = fopen($path_to_wp_config, 'w');
        fwrite($handle, self::FILE_START);

        foreach ($config_file as $key => $value) {

            fwrite($handle,$value);
        }

        fwrite($handle, self::FILE_END);
        fclose($handle);
        chmod($path_to_wp_config, 0666);

    }

    /**
     * Process Installation
     * Hard coded database creation
     * Avoid error like missing files or configuration
     * @param array $db_data
     * @return int
     */
    private function createDataBase(array $db_data)
    {
        $connection = new \PDO("mysql:host=" . $db_data['Db_host'], $db_data['Db_admin'], $db_data['Db_password']);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE IF NOT EXISTS " . $db_data['Db_name'];
        return (bool)$connection->exec($sql);
    }
}
