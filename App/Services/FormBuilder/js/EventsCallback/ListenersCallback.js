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
    },

    /**
     * Set checkbox attribute not checked => avoid not existing value after submison form
     * @param event
     */
    callback_isChecked_chkbx(event){

        let value = (event.target.getAttribute('checked') === 'true');

        if (value === true){

            event.target.setAttribute('checked', false);
        }else{

            event.target.setAttribute('checked', true);
        }
    }
};

export {ListenersCallback};





