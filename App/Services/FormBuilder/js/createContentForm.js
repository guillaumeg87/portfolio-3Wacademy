'use strict';

/**
 * CreateContentForm
 *
 * @namespace createContentForm
 */
let CreateContentForm = {
    debug: false,

    /**
     * Log something in console
     *
     * @param {string} context
     * @param {*} message
     */
    log(context, message) {
        if (this.debug) {
            console.log(context + ': ' + message);
        }
    },

    selectors: {

    },

    test() {
        console.log('HELLO TEST');
    },
    /**
     * Initialize app
     */
    init(formWrapper) {

        this.log('createContentForm', 'init');
    },
};

/**
 * Run init function of app
 * when the document is ready
 */
$(document).ready(function() {
    CreateContentForm.init();
});
