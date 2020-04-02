<?php

namespace Front\Controller;

use Admin\Core\Config\AbstractController;
use Front\Constants\FrontConstants;
use Front\Traits\PrepareFromConfig;

/**
 * Class IndexController
 * @package Front\Controller
 */
class IndexController extends AbstractController
{
    const HOME_CONTENT = 'home_configuration';

    use PrepareFromConfig;
    public function index($options = []){

        foreach (FrontConstants::FRONT_CONFIG_SECTIONS as $key => $value) {

            if ($key !== 'main' && !empty($config = $this->prepare($key))){
                $options[$key] = $config;
            }
            else {
                $options[$key] = $this->prepare(self::HOME_CONTENT);
            }
        }

        $frontManager = $this->getServiceManager()->getFrontManager();
        $options = $frontManager->getDatas($options);

        $this->render(__NAMESPACE__, 'index', $options);
    }

    public function projet($options = []){


Dumper::dump('CONTROLLER PROJET');die;
        foreach (FrontConstants::FRONT_CONFIG_SECTIONS as $key => $value) {

            if ($key !== 'main' && !empty($config = $this->prepare($key))){
                $options[$key] = $config;
            }
            else {
                $options[$key] = $this->prepare(self::HOME_CONTENT);
            }
        }

        $frontManager = $this->getServiceManager()->getFrontManager();
        $options = $frontManager->getDatas($options);

        $this->render(__NAMESPACE__, 'index', $options);
    }


    public function portfolio($options = []){


        Dumper::dump('CONTROLLER portfolio');die;
        foreach (FrontConstants::FRONT_CONFIG_SECTIONS as $key => $value) {

            if ($key !== 'main' && !empty($config = $this->prepare($key))){
                $options[$key] = $config;
            }
            else {
                $options[$key] = $this->prepare(self::HOME_CONTENT);
            }
        }

        $frontManager = $this->getServiceManager()->getFrontManager();
        $options = $frontManager->getDatas($options);

        $this->render(__NAMESPACE__, 'index', $options);
    }

    public function loisirs($options = []){


        Dumper::dump('CONTROLLER LOISIRS');die;
        foreach (FrontConstants::FRONT_CONFIG_SECTIONS as $key => $value) {

            if ($key !== 'main' && !empty($config = $this->prepare($key))){
                $options[$key] = $config;
            }
            else {
                $options[$key] = $this->prepare(self::HOME_CONTENT);
            }
        }

        $frontManager = $this->getServiceManager()->getFrontManager();
        $options = $frontManager->getDatas($options);

        $this->render(__NAMESPACE__, 'index', $options);
    }

    public function page404($options = []){

        $this->render(__NAMESPACE__, '404', $options);
    }
}
