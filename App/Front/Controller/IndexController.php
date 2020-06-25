<?php

namespace Front\Controller;

use Admin\Core\Config\AbstractController;
use Front\Constants\FrontConstants;
use Front\Traits\PrepareFromConfig;
use Services\Dumper\Dumper;

/**
 * Class IndexController
 * @package Front\Controller
 */
class IndexController extends AbstractController
{
    const HOME_CONTENT = 'home_configuration';
    const PORTFOLIO_CONTENT = 'portfolio_configuration';
    const PORTFOLIO_TEMPLATE = 'front_portfolio';

    use PrepareFromConfig;

    public function index($options = [])
    {

        // Helper for redirect to root url and not path to controller
        if (isset($options['redirect']) && $options['redirect'] === true) {
            header_remove();
            header('Location: /');

        } else {

            $options = $this->getDatas($options, self::HOME_CONTENT);

            $frontManager = $this->getServiceManager()->getFrontManager();
            $options = $frontManager->getDatas($options);

            $this->render(__NAMESPACE__, 'index', $options);
        }
    }

    public function projet($options = [])
    {

        Dumper::dump('CONTROLLER PROJET');
        die;

        $options = $this->getDatas($options, self::HOME_CONTENT);
        $frontManager = $this->getServiceManager()->getFrontManager();
        $options = $frontManager->getDatas($options);

        $this->render(__NAMESPACE__, 'index', $options);
    }


    public function portfolio($options = [])
    {
        $page = 1;
        $per_page = 10;

        if (isset($options['page']) && !empty($options['page'])
            && isset($options['per_page']) && !empty($options['per_page'])) {
            $page = (int)$options['page'];
            $per_page = (int)$options['per_page'];
            unset($options['page']);
            unset($options['per_page']);
        }

        $options = $this->getDatas($options, self::PORTFOLIO_CONTENT);

        $frontManager = $this->getServiceManager()->getFrontManager();
        $options = $frontManager->getDatas($options);
        $credentials = $options['main']['section_1']['data'][0];

        $apiManager = $this->getServiceManager()->getApiManager($credentials);

        $user = $apiManager->getUser();

        if ($user['code'] == 200) {

            $options['main']['section_1']['data']['github_user'] = json_decode($user['response'], true);
            $commitList = $apiManager->getCommitList($page, $per_page);

            if ($commitList['code'] === 200) {

                $options['main']['pagination'] = $commitList['pagination'];

                $options['main']['section_2']['data']['commitList'] = $this->handleCommitsData(json_decode($commitList['response'],
                    true));
                unset($options['main']['section_1']['data'][0]);

            } else {

                $this->errorAPIredirect((int)$commitList['code']);
            }
        } else {

                $this->errorAPIredirect((int)$user);
            }

        $this->render(__NAMESPACE__, self::PORTFOLIO_TEMPLATE, $options);
    }

    public function loisirs($options = [])
    {


        Dumper::dump('CONTROLLER HOBBY');
        die;


        $this->render(__NAMESPACE__, 'index', $options);
    }

    public function page404($options = [])
    {

        $this->render(__NAMESPACE__, '404', $options);
    }

    private function errorAPIredirect(int $errorCode)
    {

        $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
            'Une erreur est survenue lors de la récupération du contenue depuis l\'API Github (code erreur: ' . $errorCode . ').',
            'error'
        ))->messageBuilder();

        $options['redirect'] = true;
        $this->index($options);
    }


    private function handleCommitsData(array $datas): array
    {
        foreach ($datas as $index => $array) {
            foreach ($array as $key => $value) {

                if (is_array($value)) {
                    if (isset($value['message']) && !empty($value['message'])) {

                        if (preg_match('/:/', $value['message'])) {

                            $explode = explode(':', $value['message']);

                            $datas[$index][$key][FrontConstants::LABEL_COMMIT] = trim($explode[0]);
                            if (preg_match('/- /', $explode[1])) {

                                $explode = explode('- ', trim($explode[1]));
                                foreach ($explode as $k) {

                                    if (!empty($k)) {

                                        $datas[$index][$key][FrontConstants::COMMIT_MESSAGE][] = trim($k);

                                    }
                                }
                            } else {

                                $datas[$index][$key][FrontConstants::COMMIT_MESSAGE] = trim($explode[1]);
                            }
                        }
                    }
                }
            }

        }
        return $datas;
    }

    private function getDatas(array $options, string $type):array
    {
        foreach (FrontConstants::FRONT_CONFIG_SECTIONS as $key => $value) {

            if ($key !== 'main' && !empty($config = $this->prepare($key))) {
                $options[$key] = $config;
            } else {
                $options[$key] = $this->prepare($type);
            }
        }

        return $options;
    }
}
