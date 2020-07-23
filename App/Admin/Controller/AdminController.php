<?php

namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Core\Traits\NavigationTrait;
use Admin\Requests\Content\ContentRequest;

class AdminController extends AbstractController
{
    use NavigationTrait;
    //TEMPLATE
    const ADMIN_LOGIN_FORM = 'admin_login';
    const ADMIN_HOME= 'admin_home';

    const GITHUB_USER = 'guillaumeg87';
    const WIDGET_API_QUERY_PARAM = [
        'id' => self::GITHUB_USER,
        'content_name' => 'api_github_settings'
    ];

    const WIDGET_PROJECT_LIST_QUERY_PARAM = [
        'content_name' => 'project_content'
    ];

    const WIDGET_TECHNO_LIST_QUERY_PARAM = [
        'content_name' => 'techno_taxonomy'
    ];

    const WIDGET_LANGAGE_LIST_QUERY_PARAM = [
        'content_name' => 'langage_taxonomy'
    ];

    const SELECT_ONE = 'select_one';
    const SELECT_ALL = 'select_all';

    public function index($options = [])
    {
        $this->isSessionActive();

        $options = $this->prepareWidget($options);

        $this->render(__NAMESPACE__, self::ADMIN_HOME, $options);
    }

    public function home($options = [])
    {
        $this->isSessionActive();

        $options = $this->prepareWidget($options);

        $this->render(__NAMESPACE__, self::ADMIN_HOME, $options);
    }

    private function getApiTokenStatus($options):array
    {
        $param = self::WIDGET_API_QUERY_PARAM;
        try {
            $sql = $this->getQueryBuilder()->buildSql($param, self::SELECT_ONE);
            $sql = str_replace('id', 'username', $sql);
            $param['username'] = self::GITHUB_USER;
            unset($param['id']);
            unset($param['content_name']);

            $request = new ContentRequest();
            $result = $request->selectOne($param, $sql);

            $apiManager = $this->getServiceManager()->getApiManager($result);
            $apiResponse  = $apiManager->getAuthorization();

            $options['github_api_status'] = [
                'label' => 'Statut API Token',
                'status' => $apiResponse['code'],
                'class' => $apiResponse['code'] === 200 ?
                    'tokenValid' : 'tokenNotValid'
            ];

        }catch (\Exception $e) {
            //
        }

        return $options;
    }

    /**
     * Api call to Github and return number of commits in the project repository
     * @param $options
     * @return array
     */
    private function getWidgetCommitCount($options):array
    {
        $param = self::WIDGET_API_QUERY_PARAM;
        try {
            $sql = $this->getQueryBuilder()->buildSql($param, self::SELECT_ONE);
            $sql = str_replace('id', 'username', $sql);
            $param['username'] = self::GITHUB_USER;
            unset($param['id']);
            unset($param['content_name']);

            $request = new ContentRequest();
            $result = $request->selectOne($param, $sql);

            $apiManager = $this->getServiceManager()->getApiManager($result);
            $options['github_widget'] = [
                'label' => 'Total des commits',
                'total' => $apiManager->countCommit()
            ];

        }catch (\Exception $e) {
            //
        }
        return $options;
    }

    private function prepareWidget($options):array
    {
        $options = $this->getApiTokenStatus($options);
        $options = $this->getWidgetCommitCount($options);
        $options = $this->getProjectList($options);
        $options = $this->getTechnoList($options);
        $options = $this->getLangageList($options);

        return $options;
    }

    /**
     * @param $options
     * @return array
     */
    private function getProjectList($options):array
    {
        try {
            $sql = $this->getQueryBuilder()->buildSql(
                self::WIDGET_PROJECT_LIST_QUERY_PARAM, self::SELECT_ALL);

            $request = new ContentRequest();
            $result = $request->selectAll($sql);

        }catch (\Exception $e) {
            //
        }

        $options['project_list'] = [
            'label' => 'Liste des projets',
            'list' => $result
        ];

        return $options;
    }

    private function getTechnoList($options):array
    {
        try {
            $sql = $this->getQueryBuilder()->buildSql(
                self::WIDGET_TECHNO_LIST_QUERY_PARAM, self::SELECT_ALL);

            $request = new ContentRequest();
            $result = $request->selectAll($sql);

        }catch (\Exception $e) {
            //
        }

        $options['techno_list'] = [
            'label' => 'Liste des techos',
            'list' => $result
        ];

        return $options;
    }

    private function getLangageList($options):array
    {
        try {
            $sql = $this->getQueryBuilder()->buildSql(
                self::WIDGET_LANGAGE_LIST_QUERY_PARAM, self::SELECT_ALL);

            $request = new ContentRequest();
            $result = $request->selectAll($sql);

        }catch (\Exception $e) {
            //
        }

        $options['langage_list'] = [
            'label' => 'Liste des langages',
            'list' => $result
        ];

        return $options;
    }

}
