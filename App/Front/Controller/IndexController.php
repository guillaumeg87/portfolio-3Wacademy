<?php

namespace Front\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Requests\Content\ContentRequest;
use Front\Constants\FrontConstants;
use Front\Traits\PrepareFromConfig;
use Services\Dumper\Dumper;
use Services\FormBuilder\Constants\FormBuilderConstants;
use Services\LogManager\LogConstants;
use Services\LogManager\LogManager;

/**
 * Class IndexController
 * @package Front\Controller
 */
class IndexController extends AbstractController
{
    const HOME_CONTENT = 'home_configuration';
    const PORTFOLIO_CONTENT = 'portfolio_configuration';
    const PORTFOLIO_TEMPLATE = 'front_portfolio';
    const PROJECT_CONTENT = 'projects_configuration';
    const PROJECT_TEMPLATE = 'front_projects';
    const SINGLE_PROJECT_TEMPLATE = 'front_single_project';
    const SELECT_ONE = 'select_one';
    const CONTENT_NAME = 'project_content';
    const CONF_404 = '404_configuration';
    use PrepareFromConfig;

    public function index($options = [])
    {

        // Helper for redirect to root url and not path to controller
        if (isset($options['redirect']) && $options['redirect'] === true) {
            $this->redirectTo('/', $options);

        } else {

            $options = $this->getConfig($options, self::HOME_CONTENT);

            $frontManager = $this->getServiceManager()->getFrontManager();
            $options = $frontManager->getDatas($options);

            $this->render(__NAMESPACE__, 'index', $options);
        }
    }

    public function projet($options = [])
    {

        $options = $this->getConfig($options, self::PROJECT_CONTENT);

        $frontManager = $this->getServiceManager()->getFrontManager();
        $options = $frontManager->getDatas($options);

        $this->render(__NAMESPACE__, self::PROJECT_TEMPLATE, $options);
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

        $options = $this->getConfig($options, self::PORTFOLIO_CONTENT);

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

    /**
     * Get a single project and render to front
     * @param array $options
     */
    public function singleProject($options = [])
    {
        $projectTaxo = $this->getTaxoList(self::CONTENT_NAME);

        $id = htmlspecialchars($options['id']);
        $result = null;
        if (!empty($id) && preg_match('/^[0-9]+$/', $id)) {
            try {

                $param = [
                    'id' => $id,
                    'content_name' => self::CONTENT_NAME
                ];

                $sql = $this->getQueryBuilder()->buildSql($param, self::SELECT_ONE);

                $request = new ContentRequest();
                //faire une REQUETE avec des jointures
                $result = $request->selectOne($param, $sql);

                if (!empty($result)) {

                    foreach ($projectTaxo as $key => $value) {
                        $chunk = explode('_', $value);

                        if (array_key_exists($chunk[0], $result)) {
                            $ids = $result[$chunk[0]];
                            $idList = $this->getIdList($ids);explode(', ', $ids);

                            $result['linked'][$chunk[0]] = $this->getLinkedTaxo($value, $idList);

                        }
                    }
                }

            } catch (\Exception $e) {
               $this->getServiceManager()->getLogManager()->log(
                    'An error occured in front controller | single project : ' .  PHP_EOL . $e->getTraceAsString(),
                    LogConstants::ERROR_APP_LABEL,
                    LogConstants::ERROR_LABEL);
            }

        }
        /**
         * Get menu / header / footer datas defined in configuration files
         */
        $options = $this->getConfig($options, '');
        $options = $this->getServiceManager()->getFrontManager()->getDatas($options);

        $options['main']['data'] = $result;

        $this->render(__NAMESPACE__, self::SINGLE_PROJECT_TEMPLATE, $options);

    }

    /**
     * Page 404
     * @param array $options
     */
    public function page404($options = [])
    {
        $options = $this->getConfig($options, self::CONF_404);
        $options = $this->getServiceManager()->getFrontManager()->getDatas($options);

        $this->render(__NAMESPACE__, '404', $options);
    }

    private function errorAPIredirect(int $errorCode)
    {

        $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
            'Une erreur est survenue lors de la récupération du contenue depuis l\'API Github (code erreur: ' . $errorCode . ').',
            'error'
        ))->messageBuilder();

        $this->getServiceManager()->getLogManager()->log(
            'An error occured in front controller | error API Github : ' .  PHP_EOL,
            LogConstants::ERROR_APP_LABEL,
            LogConstants::ERROR_LABEL);

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

    private function getConfig(array $options, string $type):array
    {
        foreach (FrontConstants::FRONT_CONFIG_SECTIONS as $key => $value) {

            if ($key !== 'main' && !empty($config = $this->prepare($key))) {
                $options[$key] = $config;
            } elseif (!empty($type)) {
                $options[$key] = $this->prepare($type);
            }
        }

        return $options;
    }

    /**
     * Extract taxonomy list from configuration file
     * @param $contentName
     * @return array
     */
    private function getTaxoList($contentName)
    {
        $taxoBag = [];
        $json = \file_get_contents(FormBuilderConstants::CUSTOM_CONFIG_DIRECTORY . $contentName . '.json');
        $toArray = json_decode($json, true);

        if (!empty($toArray) && isset($toArray['fields'])) {
            foreach ($toArray['fields'] as $key => $value) {

                if (isset($value['label']['labelRef']) && preg_match('/[a-zA-Z0-9]+_taxonomy/', $value['label']['labelRef'])) {
                    $taxoBag[] = $value['label']['labelRef'];
                }
            }
        }

        return $taxoBag;
    }

    /**
     * Remove empty value in id list
     * @param $ids
     * @return array
     */
    private function getIdList($ids): array
    {
        $cleanArray = [];
        $explode = explode(', ', $ids);

        foreach ($explode as $k => $v) {
            if (!empty($v)) {
                $cleanArray[] = $v;
            }
        }
        return $cleanArray;
    }

    private function getLinkedTaxo($taxoName, $idList)
    {

        $request = new ContentRequest();
        $linkedTaxo = [];

        foreach ($idList as $key => $value) {
            $param = [
                'id' => $value,
                'content_name' => $taxoName
            ];
            try {
                $sql = $this->getQueryBuilder()->buildSql($param, self::SELECT_ONE);
                $result = $request->selectOne($param, $sql);
                if (!empty($result)) {
                    $linkedTaxo[] = $result;
                }
            } catch (\Exception $e){
                $this->getServiceManager()->getLogManager()->log(
                    '[ FRONT ] An error occured in front/index method' . PHP_EOL . $e->getTraceAsString(),
                    LogConstants::ERROR_APP_LABEL,
                    LogConstants::ERROR_LABEL
                );
            }

        }

        return $linkedTaxo;
    }
}

