<?php
namespace Admin\Controller;

use Admin\Core\Config\AbstractController;

class FormBuilderController extends AbstractController
{
    const FORM_BUILDER_INDEX = 'formbuilder';

    public function index($options= [])
    {
        if(empty($_SESSION)) {
            // DANS L'AUTRE CAS IL FAUDRA PASSER UPDATE
            if (!array_key_exists('form-selector', $options)){
                $options['form-selector'] = 'init';
            }
            $this->render(__NAMESPACE__, self::FORM_BUILDER_INDEX, $options);
        }
    }
}