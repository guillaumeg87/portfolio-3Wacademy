<?php

namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Core\Traits\NavigationTrait;
use Services\FormBuilder\Core\FormBuilderManager;
use Services\MenuManager\ContentManager;

class FormBuilderController extends AbstractController
{
    use NavigationTrait;

    const FORM_BUILDER_INDEX = 'formbuilder';

    public function index($options = [])
    {

        if (empty($_SESSION)) {
            //@TODO: DANS L'AUTRE CAS IL FAUDRA PASSER UPDATE
            if (!array_key_exists('form-selector', $options)) {
                $options['form-selector'] = 'form-init';
            }

            $this->render(__NAMESPACE__, self::FORM_BUILDER_INDEX, $options);
        }
    }

    public function validator($options = [])
    {

        // @TODO $_POST n'est jamais vide mais les champs peuvent l'être
        if (empty($_POST)) {
            $this->render(__NAMESPACE__, self::FORM_BUILDER_INDEX, $options);
        }
        $formData = $_POST;

        $formBuilderManager = $this->getServiceManager()->getFormBuilderManager($formData);
        $suffix = $formBuilderManager->buildIndex($formData);
        $formatedDatas = $formBuilderManager->sortFormdata($formData, $suffix);

        if ($formatedDatas['toMenu']) {

            $contentMgr = new ContentManager();
            $options['flash-message'][] = $contentMgr->addEntry($formatedDatas['labels']);

        } else {
            $options['flash-message'][] = $formatedDatas['flash-message'];
        }
        $this->render(__NAMESPACE__, self::FORM_BUILDER_INDEX, $options);

    }

    public function updateContent($options = [])
    {
        $this->render(__NAMESPACE__, self::FORM_BUILDER_INDEX, $options);
    }
}
