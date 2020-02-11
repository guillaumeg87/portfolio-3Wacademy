<?php
namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Core\QueryBuilder\QueryBuilder;
use Admin\Requests\Content\ColorsRequest;
use Admin\Requests\Content\ContentRequest;
use Services\Dumper\Dumper;
use Services\FlashMessages\FlashMessage;

class ContentController extends AbstractController
{
    const HANDLE_CONTENT_INDEX = 'handle_content_index';
    const HANDLE_CONTENT_FORM = 'handle_content_form';

    const CONTENT_FORM_CREATE = 'create_form';
    const CONTENT_FORM_UPDATE = 'update_form';

    const CREATE_LABEL = 'create';
    const EDIT_LABEL = 'edit';
    const UPDATE_LABEL = 'update';
    const DELETE_LABEL = 'delete';
    const SELECT_ONE_LABEL = 'select_one';

    public function index($options = [])
    {
        if (empty($_SESSION)) {

            if (!empty($options)) {

                if($options['content_name'] || $options['widget']){
                    $content_name = $options['content_name'] ?? $options['widget']['content_name'];

                    $widget = $this->getAdminWidget($content_name);
                    $options['labels'] = $this->getContentLabels($content_name);
                    $options['list'] = $widget->getElementList();
                    if (!empty($widget->getElementList()) && is_array($widget->getElementList())) {
                        $options['header'] = array_keys($widget->getElementList()[0]);
                    }
                }

                // @TODO = regarder si $widget->getElementList(); ne retourne pas de flash message
            }

            $this->render(__NAMESPACE__, self::HANDLE_CONTENT_INDEX, $options);
        }
    }

    public function formContent($options = [])
    {

        if (empty($_SESSION)) {
            // @TODO au lieu de create ici retourner un message d'erreur
            $options['action'] = $options['isEdit'] ? self::EDIT_LABEL : self::CREATE_LABEL;

            $form = $this->getFormBuilderManager($options)->updateContentdata();
            if(!empty($form) && $options['action'] === self::EDIT_LABEL){
                $options['form-selector'] = self::CONTENT_FORM_UPDATE;

            }
            elseif ($options['action'] === self::CREATE_LABEL){
                $options['form-selector'] = self::CONTENT_FORM_CREATE;
            }
            else {
                $options['flash-message'][] = (new FlashMessage(
                  'Une erreur est survenue lors de la récupération du contenue.',
                    'error'
                ))->messageBuilder();
            }

            $this->render(__NAMESPACE__, self::HANDLE_CONTENT_FORM, $options);
        }
    }

    private function verifyDatasFromForm($data): array
    {
        $formDatas = [];

        foreach ($_POST as $key => $value) {
            $formDatas[$key] = htmlspecialchars($value);
        }
        return $formDatas;
    }

    public function create($options = [])
    {
        if (empty($_SESSION)) {

            $formDatas = $this->verifyDatasFromForm($_POST);

            $options['widget'] = [
                'id'            => $formDatas['content_id'],
                'content_name'  => $formDatas['content_name']
            ];
            unset($formDatas['content_id']);

            try {
                $options['flash-message'][] = $this->saveContent(self::CREATE_LABEL, $formDatas);
            } catch (\Exception $e) {
                // @TODO
            }

            $options['form-selector'] = $options['content_name'];

            $this->index($options);
        }
    }

    /**
     * @param $options
     */
    public function edit ($options)
    {
        $formDatas = $this->verifyDatasFromForm($_POST);
        $options['widget'] = [
            'id'            => $formDatas['content_id'],
            'content_name'  => $formDatas['content_name']
        ];
        unset($formDatas['content_id']);

        if (!empty($formDatas) && !empty($formDatas['id'])) {
            try {
                $queryBuilder = new QueryBuilder();
                $sql = $queryBuilder->buildSql($formDatas, self::UPDATE_LABEL);
                $request = new ContentRequest();
                $isUpdated = $request->updateContent($formDatas, $sql);

                if ($isUpdated) {

                    $options['content'] = $isUpdated;


                    $options['flash-message'][] = (new FlashMessage(
                        "La contenu a bien été modifiée!",
                        'success'
                    ))->messageBuilder();

                    $this->index($options);
                }

            } catch (\Exception $e) {

                $options['flash-message'][] = (new FlashMessage(
                    'ERROR : ' . '</br>' .
                    'Code : ' . $e->getCode() .
                    'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                    'Message : ' . $e->getMessage() . '</br>' .
                    'Line : ' . $e->getLine() . '</br>',
                    'error'
                ))->messageBuilder();

                $this->render(__NAMESPACE__, self::HANDLE_CONTENT_FORM, $options);

            }
        }
    }

    /**
     * @param $params
     */
    public function delete($options)
    {

        if (!empty($options) && !empty($options['id'])) {
            try {
                $query = new ContentRequest();
                $queryBuilder = new QueryBuilder();
                $sql = $queryBuilder->buildSql($options, self::DELETE_LABEL);
                $isDeleted = $query->delete($options, $sql);

                if ($isDeleted) {
                    $options['flash-message'][] = (new FlashMessage(
                        "Le contenu a bien été supprimée!",
                        'success'
                    ))->messageBuilder();

                    if($options['content_name']){
                        $widget = $this->getAdminWidget($options['content_name']);
                        $options['labels'] = $this->getContentLabels($options['content_name']);
                        $options['list'] = $widget->getElementList();

                        if (!empty($widget->getElementList()) && is_array($widget->getElementList())) {
                            $options['header'] = array_keys($widget->getElementList()[0]);
                        }
                    }

                    $this->render(__NAMESPACE__, self::HANDLE_CONTENT_INDEX, $options);
                }

            } catch (\Exception $e) {
                $options['flash-message'][] = (new FlashMessage(
                    'ERROR : ' . '</br>' .
                    'Code : ' . $e->getCode() .
                    'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                    'Message : ' . $e->getMessage() . '</br>' .
                    'Line : ' . $e->getLine() . '</br>',
                    'error'
                ))->messageBuilder();
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
    public function saveContent($method, $params)
    {

        try {
            $request = new ContentRequest();

            $isTableExist = $request->isTableExist($params);

            $isSaved = false;
            if ($isTableExist) {
                $sql = $this->getQueryBuilder()->buildSql($params, $method);

                if ($method == self::CREATE_LABEL) {

                    $isSaved = $request->createContent($params, $sql);

                } elseif ($method == self::UPDATE_LABEL) {

                    $isSaved = $request->updateContent($params, $sql);
                }
            }

            if ($isSaved) {

                $flash_message = (new FlashMessage(
                    "Le contenu a bien été sauvegardée",
                    'success'
                ))->messageBuilder();


            } else {
                $flash_message = (new FlashMessage(
                    "Le contenu n'a pas été sauvegardée",
                    'error'
                ))->messageBuilder();
            }
        } catch (\Exception $e) {
            $flash_message = (new FlashMessage(
                'ERROR : ' . '</br>' .
                'Code : ' . $e->getCode() .
                'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                'Message : ' . $e->getMessage() . '</br>' .
                'Line : ' . $e->getLine() . '</br>',
                'error'
            ))->messageBuilder();

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

}
