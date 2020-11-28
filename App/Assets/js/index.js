import {FormBuilderManager} from "../../Services/FormBuilder/js/formBuilderManager";

require("../scss/main.scss");
/****************/
/*     TOOLS    */
/****************/
require("./tools/tools");

/********************/
/*     PAGINATION   */
/********************/
require("./pagination.js");

/****************/
/* FORM BUILDER */
/****************/
// formbuilder
require("../../Services/FormBuilder/js/formBuilderManager.js");
require("../../Services/FormBuilder/js/EventsCallback/ListenersCallback.js");


/**
 * Run init function of app
 * when the document is ready
 */
document.addEventListener("DOMContentLoaded", function() {
    let isForm = document.querySelector('form');
    if (isForm){
        FormBuilderManager.init();

        // Checkbox field
        let checkbox_target = document.querySelectorAll('.update_form input[type="checkbox"]');
        // improve EVENT here
        if(checkbox_target){
            FormBuilderManager.addListListener({
                callback : 'callback_isChecked_chkbx',
                type: 'click'
            }, checkbox_target);
        }
    }


});

