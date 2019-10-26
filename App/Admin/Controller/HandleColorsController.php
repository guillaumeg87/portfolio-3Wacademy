<?php


namespace Admin\Controller;


use Admin\Core\Config\AbstractController;
use Admin\Requests\Content\ColorsRequest;
use Services\FlashMessages\FlashMessage;

class HandleColorsController extends AbstractController
{
    const HANDLE_COLORS_FORM = 'handle_colors_form';

    const CREATE_LABEL = 'create';
    const CREATE_COLOR_FIELDS_TABLE = ['color', 'class-color'];

    const UPDATE_LABEL = 'update';
    const UPDATE_COLOR_FIELDS_TABLE = ['id', 'color', 'class-color'];

    public function index($options = []){

        if(empty($_SESSION)) {

            $contentName = 'content_color';
            $widget = new AdminWidgetController();
            $options['list'] = $widget->getElementList($contentName);

            $this->render(__NAMESPACE__, self::HANDLE_COLORS_FORM, $options);
        }
    }

    public function handleContentData()
    {
        $data = [];
//@TODO ne pas faire de sauvegarde si les champs sont vides
        if (!empty($_POST)) {

            if($_POST['id'] === null){
                foreach ($_POST as $key => $value) {
                    if (in_array($key, self::CREATE_COLOR_FIELDS_TABLE)) {

                        $data[$key] = $value;

                    }
                }

                $this->saveColor(self::CREATE_LABEL, $data);
            }else{
                foreach ($_POST as $key => $value) {
                    if (in_array($key, self::UPDATE_COLOR_FIELDS_TABLE)) {

                        $data[$key] = $value;

                    }
                }

                $this->saveColor(self::UPDATE_LABEL, $data);
            }
        }
    }

    public function edit($params)
    {

        if (!empty($params) && !empty($params['id'])) {
            try{
                $request = new ColorsRequest();
                $isUpdated = $request->selectOne($params);
                if ($isUpdated) {

                    $options['response'] = $isUpdated;
/*
 * A modifier, a afficher si la couleur est sauvegardée
                    $options['flash-message'][] = (new FlashMessage(
                        "La couleur a bien été modifiée!",
                        'success'
                    ))->messageBuilder();
*/
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
                $this->render(__NAMESPACE__, self::HANDLE_COLORS_FORM, $options);

            }
        }
    }

    /**
     * @param $params
     */
    public function delete ($params)
    {
        if (!empty($params) && !empty($params['id'])) {
            try{
                $request = new ColorsRequest();
                $isDeleted = $request->delete($params);
                if ($isDeleted){
                    $options['flash-message'][] = (new FlashMessage(
                        "La couleur a bien été supprimée!",
                        'success'
                    ))->messageBuilder();
                    $this->index();
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
                $this->render(__NAMESPACE__, self::HANDLE_COLORS_FORM, $options);

            }
        }
    }

    /**
     * @param String $method
     * @param array $params
     */
    public function saveColor($method, $params){

        try{
            $request = new ColorsRequest();

            $isTableExist = $request->createColorTable();
            $isSaved = false;
            if (!$isTableExist){

                if($method == self::CREATE_LABEL){

                    $isSaved = $request->createColorContent($params);

                }elseif($method == self::UPDATE_LABEL){

                    $isSaved = $request->updateColorContent($params);
                }
            }

            if ($isSaved) {

                $options['flash-message'][] = (new FlashMessage(
                    "La couleur a bien été sauvegardée",
                    'success'
                ))->messageBuilder();


            }else{
                $options['flash-message'][] = (new FlashMessage(
                    "La couleur n'a pas été sauvegardée",
                    'error'
                ))->messageBuilder();
            }
        }catch (\Exception $e) {
            $options['flash-message'][] = (new FlashMessage(
                'ERROR : ' . '</br>' .
                'Code : ' . $e->getCode() .
                'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                'Message : ' . $e->getMessage() . '</br>' .
                'Line : ' . $e->getLine() . '</br>',
                'error'
            ))->messageBuilder();

            $this->render(__NAMESPACE__, self::HANDLE_COLORS_FORM, $options);

        }
        $this->index();
    }
}