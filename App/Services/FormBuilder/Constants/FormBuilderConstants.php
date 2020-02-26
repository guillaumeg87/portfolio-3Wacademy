<?php


namespace Services\FormBuilder\Constants;


final class FormBuilderConstants
{
    const KEY_FIELD_TYPE = 'fieldType';
    const CUSTOM_CONFIG_DIRECTORY = '../Services/FormBuilder/configurations/custom/';
    const CUSTOM_TEMPORARY_CONFIG_DIRECTORY = '../Services/FormBuilder/configurations/custom/temp/';

    const  MENU_LABEL_COLLECTIONS = [self::DISPLAY_NAME, self::TECHNICAL_NAME];
    const DISPLAY_NAME = 'contentDisplayName';
    const TECHNICAL_NAME = 'contentTechnicalName';

    // Fields class
    const FIELDS_ENTITY_PATH = 'Services\FormBuilder\Core\Entity\\';
    const FIELD_CLASS_SUFFIX = 'Fields';

    // Fields Class names
    const INPUT = 'InputFields';
    const TEXTEREA = 'TextareaFields';
    const SELECT = 'SelectFields';
    const RADIO = 'RadioFields';
    const CHECKBOX = 'CheckboxFields';
    const FILES = 'FilesFields';

    // Json file config
    const CONTENT_FORM_CLASS_WRAPPER = 'admin-form';
    const CONTENT_FORM_GROUP_WRAPPER = 'formbuilder-load';
    const CONTENT_FORM_CLASS_BTN_SUBMIT = 'form-btn-submit';

    // Taxonomy
    const TAXONOMY_CONFIG_DIRECTORY = '../Services/FormBuilder/configurations/custom/taxonomy';
    const TAXO_TABLE_SUFFIX = "_taxo";

    const DEFAULT_VALUES = [
        'name' => '-- Choisissez une option --'
    ];
}
