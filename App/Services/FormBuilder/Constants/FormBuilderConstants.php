<?php


namespace Services\FormBuilder\Constants;


final class FormBuilderConstants
{
    const  MENU_LABEL_COLLECTIONS = [self::DISPLAY_NAME, self::TECHNICAL_NAME];
    const DISPLAY_NAME = 'contentDisplayName';
    const TECHNICAL_NAME = 'contentTechnicalName';

    // Fields class
    const FIELDS_ENTITY_PATH = 'Services\FormBuilder\Core\Entity\\';
    const FIELD_CLASS_SUFFIX = 'Fields';

    // Fields class names
    const INPUT = 'InputFields';
    const TEXTEREA = 'TextareaFields';
    const SELECT = 'SelectFields';
    const RADIO = 'RadioFields';
    const CHECKBOX = 'CheckboxFields';

}
