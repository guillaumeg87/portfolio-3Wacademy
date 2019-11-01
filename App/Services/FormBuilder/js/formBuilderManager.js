'use strict';

/**
 * FormBuilderManager
 *
 * @namespace FormBuilderManager
 */
const FormBuilderManager = {
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
        $formBuilderBlock : document.getElementsByClassName('formbuilder')
    },

    /**
     * Initialize app
     */
    init() {
        this.log('app', 'init');
        if (this.selectors.$formBuilderBlock.length > 0) {
            this.fieldsBuilder();
        }

    },

    fieldsBuilder(){

        let json = require('../configurations/init-builder.json');

        for(let field in json){
            if(json.hasOwnProperty(field) && field != 'fields') {
                this.log('app', 'ok : '+ field);

                let inDom = document.createElement(field);

                for(let elt in json[field]) {
                    if (json[field].hasOwnProperty(elt)) {

                        if (json[field][elt].length > 0) {
                            switch(elt) {

                                case 'name':
                                case 'for':
                                case 'type':
                                case 'id':

                                    inDom.setAttribute(elt, json[field][elt]);
                                    break;

                                case 'class':

                                    if (Array.isArray(json[field][elt])) {

                                        for (let i = 0; i < json[field][elt].length; i++) {

                                            this.log(i);
                                            this.log(json[field][elt][i]);
                                            inDom.classList.add(json[field][elt][i]);
                                        }
                                    }
                                    break;

                                case 'content':

                                    inDom.innerHTML = json[field][elt];
                                    break;
                            }
                        }
                    }
                }
                this.log('app',inDom);

                if(field == "fieldset"){
                    this.log(this.selectors.$formBuilderBlock[0]);
                    this.selectors.$formBuilderBlock[0].appendChild(inDom);
                }else{
                    let op = document.getElementsByTagName('fieldset');
                    if(null != op){
                        op[0].appendChild(inDom);
                    }
                }
            }
            //input détecte bien les inputs
            else if(field == 'fields' && Array.isArray(json[field])){
                let $fields = ['label', 'input'];
                //this.log('app', json[field]);

                json[field].forEach(function(k){

                    for(let i = 0; i < $fields.length; i++){
                       //this.log('app' ,$fields[i]);
                        let inDom = document.createElement($fields[i]);

                        for(let elt in k[$fields[i]]){
                            if (k[$fields[i]].hasOwnProperty(elt)) {
                                if (k[$fields[i]][elt].length > 0) {
                                    switch (elt) {

                                        case 'name':
                                        case 'for':
                                        case 'type':
                                        case 'id':
                                        case 'placeholder':

                                            inDom.setAttribute(elt, k[$fields[i]][elt]);
                                            break;

                                        case 'class':

                                            if (Array.isArray(k[$fields[i]][elt])) {

                                                for (let j = 0; j < k[$fields[i]][elt].length; j++) {

                                                    this.log(j);
                                                    this.log(k[$fields[i]][elt][j]);
                                                    inDom.classList.add(k[$fields[i]][elt][j]);
                                                }
                                            }
                                            break;

                                        case 'content':

                                            inDom.innerHTML = k[$fields[i]][elt];
                                            break;
                                    }
                                }
                                let op = document.getElementsByTagName('fieldset');
                                if(null != op){
                                    op[0].appendChild(inDom);
                                }
                            }
                        }
                    }
                });
            }
        }
    },

};

/**
 * Run init function of app
 * when the document is ready
 */
$(document).ready(function() {
    FormBuilderManager.init();
});