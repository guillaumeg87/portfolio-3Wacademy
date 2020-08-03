<?php
namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Core\QueryBuilder\QueryBuilder;
use Admin\Core\Traits\Hash;
use Admin\Core\Traits\RequestDateTrait;
use Admin\Requests\Content\ContentRequest;
use Services\LogManager\LogConstants;

class ContentController extends AbstractController
{
    use Hash;
    use RequestDateTrait;
    const HANDLE_CONTENT_INDEX = 'handle_content_index';
    const HANDLE_CONTENT_FORM = 'handle_content_form';

    const CONTENT_FORM_CREATE = 'create_form';
    const CONTENT_FORM_UPDATE = 'update_form';

    const CREATE_LABEL = 'create';
    const EDIT_LABEL = 'edit';
    const UPDATE_LABEL = 'update';
    const DELETE_LABEL = 'delete';
    const SELECT_ONE_LABEL = 'select_one';

    const USER_FIELDS = ['login', 'password', 'email', 'isSuperAdmin'];

    /**
     * @param array $options
     */
    public function index(array $options = [])
    {
        $this->isSessionActive();

        if (!empty($options)) {

            if($options['content_name'] || $options['widget']){
                $content_name = $options['content_name'] ?? $options['widget']['content_name'];

                $widget = $this->getServiceManager()->getAdminWidget($content_name);

                $options['labels'] = $this->getContentLabels($content_name);

                $options['list'] = $widget->getElementList();
                if (!empty($widget->getElementList()) && is_array($widget->getElementList())) {

                    if (!empty($widget->getElementList()[0])){
                         $temp = array_keys($widget->getElementList()[0]);
                        // Limit display field in table
                        $options['header'] = [];
                        foreach ($temp as $key => $value){
                            if (count($options['header']) < 6 && (preg_match('/(id|createdAt|updatedAt)/', $value) || !preg_match('/(url|path)/', $value))){
                                $options['header'][] = $value;
                            }

                        }
                    }
                }
            }
            // @TODO = regarder si $widget->getElementList(); ne retourne pas de flash message
        }

        $this->render(__NAMESPACE__, self::HANDLE_CONTENT_INDEX, $options);
    }

    public function formContent($options = [])
    {
        $this->isSessionActive();

        // @TODO au lieu de create ici retourner un message d'erreur
        $options['action'] = $options['isEdit'] ? self::EDIT_LABEL : self::CREATE_LABEL;

        if($options['action'] === self::EDIT_LABEL) {
            try {
                $form = $this->getServiceManager()->getFormBuilderManager($options)->updateContentdata();

            } catch (\Exception $e) {
                $this->getServiceManager()->getLogManager()->log($e->getTraceAsString(), LogConstants::ERROR_PHP_LABEL, LogConstants::ERROR_LABEL);
            }
        }

        // Sleep needed for temporary Json configuration file
        sleep(1);

        if (!empty($form) && $options['action'] === self::EDIT_LABEL){
            $options['form-selector'] = self::CONTENT_FORM_UPDATE;

        }
        elseif ($options['action'] === self::CREATE_LABEL){
            $options['form-selector'] = self::CONTENT_FORM_CREATE;
        }
        else {
            $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
                'Une erreur est survenue lors de la récupération du contenue.',
                'error'
            ))->messageBuilder();
        }

        $this->render(__NAMESPACE__, self::HANDLE_CONTENT_FORM, $options);
    }

    private function verifyDatasFromForm($data): array
    {

        $formDatas = [];
        $multipleValues = '';
        foreach ($_POST as $key => $value) {

            if (is_array($value)){
                $lastElt = end($value);

                foreach ($value as $k=> $v){
                    if  ($lastElt !== $v){
                        $multipleValues .= $v. ', ';

                    }
                    else {
                        $multipleValues .= $v;
                    }
                }
                $formDatas[$key] =  $multipleValues;
            }else{
                $formDatas[$key] = htmlspecialchars($value);

                // case of boolean => in user table for exemple
                if (preg_match('/^is[a-zA-Z]/',$key)){
                    $formDatas[$key] = boolval($value);
                }
            }
            $multipleValues = '';
        }
        return $formDatas;
    }

    /**
     * @param array $options
     */
    public function create($options = [])
    {
        $this->isSessionActive();


        $formDatas = $this->verifyDatasFromForm($_POST);
        $formDatas = $this->getFilesData($formDatas, $_FILES);

        $options['widget'] = [
            'id'            => $formDatas['content_id'],
            'content_name'  => $formDatas['content_name']
        ];
        unset($formDatas['content_id']);

        try {
            $options['flash-message'][] = $this->saveContent(self::CREATE_LABEL, $formDatas);
        } catch (\Exception $e) {
            $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
                'Une erreur est survenue, voir les logs',
                'error'
            ))->messageBuilder();
            $this->getServiceManager()->getLogManager()->log(
                'An error occured when try to edit content : ' . $formDatas['content_name'] . PHP_EOL . $e->getTraceAsString(),
                LogConstants::ERROR_APP_LABEL,
                LogConstants::ERROR_LABEL);
        }

        $options['form-selector'] = $options['content_name'];

        $this->redirectTo('/content/index', $options);
    }

    /**
     * @param $options
     */
    public function edit ($options)
    {
        $this->isSessionActive();

        $formDatas = $this->verifyDatasFromForm($_POST);
        $formDatas = $this->getFilesData($formDatas, $_FILES);
        $options['widget'] = [
            'id'            => $formDatas['content_id'],
            'content_name'  => $formDatas['content_name']
        ];
        $content = $formDatas['content_id'];
        unset($formDatas['content_id']);

        if(preg_match('/^user_?[a-z]/',$formDatas['content_name'])){
            foreach (self::USER_FIELDS as $key){
                // In case of checkbox value = false
                if(!isset($formDatas[$key])){
                    $formDatas[$key] = (int)false;
                }
            }
            $formDatas['password'] = $this->hashString($formDatas['password']);
        }
        $formDatas['updatedAt'] = $this->updatedAt();

        if (!empty($formDatas) && !empty($formDatas['id'])) {
            try {
                $queryBuilder = new QueryBuilder();
                $sql = $queryBuilder->buildSql($formDatas, self::UPDATE_LABEL);

                $request = new ContentRequest();
                $isUpdated = $request->updateContent($formDatas, $sql);
                // Delete temporary configuration file
                $isDelete = $this->getServiceManager()->getFormBuilderManager($formDatas)->deleteTemporaryConfigFile($formDatas['content_name']);
                if ($isUpdated && $isDelete) {

                    $options['content'] = $isUpdated;

                    $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
                        "Le contenu a bien été modifié!",
                        'success'
                    ))->messageBuilder();
                    if (!empty($options['widget']['content_name']) && $options['widget']['id']) {

                        $this->redirectTo('/content/index?content_name=' . $options['widget']['content_name'] . '&id=' . $options['widget']['id'], $options);
                    } else {
                        $this->index($options);
                    }

                }

            } catch (\Exception $e) {

                $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
                    'Une erreur est survenue, voir les logs',
                    'error'
                ))->messageBuilder();
                $this->getServiceManager()->getLogManager()->log(
                    'An error occured when try to edit content : ' . $content . PHP_EOL . $e->getTraceAsString(),
                    LogConstants::ERROR_APP_LABEL,
                    LogConstants::ERROR_LABEL);
                $this->render(__NAMESPACE__, self::HANDLE_CONTENT_FORM, $options);
            }
        }
    }

    /**
     * @param array $options
     */
    public function delete($options = [])
    {
        $this->isSessionActive();

        if (!empty($options) && !empty($options['id'])) {
            $content = $options['content_name'];
            try {
                $query = new ContentRequest();
                $queryBuilder = new QueryBuilder();
                $sql = $queryBuilder->buildSql($options, self::DELETE_LABEL);
                $isDeleted = $query->delete($options, $sql);

                if ($isDeleted) {
                    $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
                        "Le contenu a bien été supprimée!",
                        'success'
                    ))->messageBuilder();

                    if($options['content_name']){
                        $widget = $this->getServiceManager()->getAdminWidget($options['content_name']);
                        $options['labels'] = $this->getContentLabels($options['content_name']);
                        $options['list'] = $widget->getElementList();

                        if (!empty($widget->getElementList()) && is_array($widget->getElementList())) {
                            $options['header'] = array_keys($widget->getElementList()[0]);
                        }
                    }

                    $this->render(__NAMESPACE__, self::HANDLE_CONTENT_INDEX, $options);
                }

            } catch (\Exception $e) {
                $options['flash-message'][] = ($this->getServiceManager()->getFlashMessage(
                    'Une erreur est survenue, voir les logs',
                    'error'
                ))->messageBuilder();

                $this->getServiceManager()->getLogManager()->log(
                    'An error occured when try to delete content : ' . $content . PHP_EOL . $e->getTraceAsString(),
                    LogConstants::ERROR_APP_LABEL,
                    LogConstants::ERROR_LABEL);

                $this->render(__NAMESPACE__, self::HANDLE_CONTENT_INDEX, $options);

            }
        }
    }

    /**
     * @param String $method
     * @param array $params
     * @return array
     * @throws \Exception
     */
    private function saveContent($method, $params)
    {
        $content = $params['content_name'];

        try {
            $request = new ContentRequest();

            $isTableExist = $request->isTableExist($params);
            $isSaved = false;
            if ($isTableExist) {

                if ($method == self::CREATE_LABEL) {
                    $params['createdAt'] = $this->createdAt();
                    $sql = $this->getQueryBuilder()->buildSql($params, $method);

                    $isSaved = $request->createContent($params, $sql);

                } elseif ($method == self::UPDATE_LABEL) {
                    $params['updatedAt'] = $this->updatedAt();
                    $sql = $this->getQueryBuilder()->buildSql($params, $method);

                    $isSaved = $request->updateContent($params, $sql);
                }
            }

            if ($isSaved) {

                $flash_message = ($this->getServiceManager()->getFlashMessage(
                    "Le contenu a bien été sauvegardée",
                    'success'
                ))->messageBuilder();


            } else {
                $flash_message = ($this->getServiceManager()->getFlashMessage(
                    "Le contenu n'a pas été sauvegardée",
                    'error'
                ))->messageBuilder();
            }
        } catch (\Exception $e) {
            $flash_message = ($this->getServiceManager()->getFlashMessage(
                'Une erreur est survenue, voir les logss',
                'error'
            ))->messageBuilder();

            $this->getServiceManager()->getLogManager()->log(
                'An error occured when try to save content : ' . $content . PHP_EOL . $e->getTraceAsString(),
                LogConstants::ERROR_APP_LABEL,
                LogConstants::ERROR_LABEL);

        }
        return $flash_message;
    }

    /**
     * @param string $name
     * @return array
     */
    private function getContentLabels(string $name)
    {
        return [
            'displayName' => ucfirst(str_replace('_', ' ', $name)),
            'technicalName' => $name
        ];
    }

    /**
     * Add files datas in formated datas array
     * @param $formDatas
     * @param $files
     * @return array
     */
    private function getFilesData($formDatas, $files):array
    {
        $key = array_keys($files);
        $mainIndex = $key[0];
        foreach ($files as $key => $value){
            if ($files[$key]['size'] !== 0){

                $imageManager = $this->getServiceManager()->getImageManager();
                $isUploaded = $imageManager->imageHandler($files[$key]);
                if ($isUploaded) {

                    $formDatas[$key . '_url'] = $imageManager->getFileUrl($files[$key]['name'])['url'];
                    $formDatas[$key . '_path'] = $imageManager->getFileUrl($files[$key]['name'])['path'];

                }
            }
        }
        return $formDatas;
    }
}
