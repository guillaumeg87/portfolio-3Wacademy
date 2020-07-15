<?php


namespace Services\FormBuilder\Constants;

final class FormBuilderConstants
{
    const KEY_FIELD_TYPE = 'fieldType';
    const CUSTOM_APP_PATH = '/var/www/html/portfolio-3Wacademy/App';
    const CUSTOM_CONFIG_DIRECTORY = '../configurations/custom/';
    const CUSTOM_TEMPORARY_CONFIG_DIRECTORY = '../configurations/custom/temp/';

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
    const ENTITY_REF = 'EntityReferenceFields';

    // Json file config
    const CONTENT_FORM_CLASS_WRAPPER = 'admin-form';
    const CONTENT_FORM_GROUP_WRAPPER = 'formbuilder-load';
    const CONTENT_FORM_CLASS_BTN_SUBMIT = 'form-btn-submit';

    // CONTENT TYPE SUFFIX
    const CONTENT_TABLE_SUFFIX = "_content";
    const TAXO_TABLE_SUFFIX = "_taxonomy";
    const SETTINGS_TABLE_SUFFIX = "_settings";

    const DEFAULT_VALUES = [
        'name' => '-- Choisissez une option --'
    ];
}
