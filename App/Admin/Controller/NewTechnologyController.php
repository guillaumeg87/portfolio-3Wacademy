<?php


namespace Admin\Controller;


use Admin\Core\Config\AbstractController;

class NewTechnologyController extends AbstractController
{
    const NEW_TECHNO_FORM = 'new_techno_form';

    public function index($options = []){

        if(empty($_SESSION)) {
            $this->render(__NAMESPACE__, self::NEW_TECHNO_FORM, $options);
        }
    }

    public function saveNewCategory()
    {
        var_dump('HELLO SAVE NEW TECHNO'); die;
    }
}