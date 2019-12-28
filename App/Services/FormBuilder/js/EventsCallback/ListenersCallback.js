'use strict';

import {FormBuilderManager} from "../formBuilderManager";

/**
 * ListenersCallback
 *
 * @namespace ListenersCallback
 */
const ListenersCallback = {
    /* CALLBACKS */
    callback_form_addNewField_click_btn(event){

        event.preventDefault();
        FormBuilderManager.addNewField(event);
        event.target.classList.add('disabled');
        event.target.setAttribute('disabled', '');
    },

    callback_disabled_addNewField_click_btn(event){

        event.preventDefault();
        FormBuilderManager.deleteChoiceform();

        let addFieldButton = document.querySelector('.addNewField');

        addFieldButton.classList.remove('disabled');
        addFieldButton.removeAttribute('disabled');

    },

    callback_select_newField_click_btn(event){

        event.preventDefault();
        let selectValue = document.querySelector('#chooseField');

        if (selectValue.value){
            FormBuilderManager.newFieldSelected(selectValue.value);
        }

        document.querySelector('.admin-form').removeChild(document.querySelector('.form_field_choice'));
        let addFieldButton = document.querySelector('.addNewField');

        addFieldButton.classList.remove('disabled');
        addFieldButton.removeAttribute('disabled');
    },

    /**
     * Delete group field
     * @param event
     */
    deleteGroupButton(event){

        event.preventDefault();
        let rank = event.target.dataset.count;
        document.querySelector('.admin-form').removeChild(document.getElementById(`group-${rank}`));
    }
};

export {ListenersCallback};





