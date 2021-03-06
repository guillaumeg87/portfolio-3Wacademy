<?php

namespace Admin\Controller;

use Admin\Core\Config\AbstractController;
use Admin\Core\Traits\NavigationTrait;
use Services\MenuManager\ContentManager;

class FormBuilderController extends AbstractController
{
    use NavigationTrait;

    const FORM_BUILDER_INDEX = 'formbuilder';

    public function index($options = [])
    {
        $this->isSessionActive();

        if (!array_key_exists('form-selector', $options)) {
            $options['form-selector'] = 'form-init';
        }

        $this->render(__NAMESPACE__, self::FORM_BUILDER_INDEX, $options);

    }

    public function validator($options = [])
    {
        $this->isSessionActive();

        if (empty(array_keys($_POST))) {
            $this->render(__NAMESPACE__, self::FORM_BUILDER_INDEX, $options);
        }
        $formData = $_POST;

        $formBuilderManager = $this->getServiceManager()->getFormBuilderManager($formData);
        $suffix = $formBuilderManager->buildIndex($formData);
        $formatedDatas = $formBuilderManager->sortFormdata($formData, $suffix);

        if ($formatedDatas['toMenu']) {
            $contentType = $formatedDatas['option_type'] ?? false;
            $contentMgr = new ContentManager();
            $options['flash-message'][] = $contentMgr->addEntry($formatedDatas['labels'], $contentType);

        } else {
            $options['flash-message'][] = $formatedDatas['flash-message'];
        }
        $this->render(__NAMESPACE__, self::FORM_BUILDER_INDEX, $options);

    }

    public function updateContent($options = [])
    {
        $this->isSessionActive();

        $this->render(__NAMESPACE__, self::FORM_BUILDER_INDEX, $options);
    }
}
