'use strict';

import {ListenersCallback} from "./EventsCallback/ListenersCallback";
import {Tools} from "../../../Assets/js/tools/tools";

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
        $formBuilder : document.querySelector('.formbuilder'),
        $formBuilder__buildNewForm : document.getElementsByClassName('form-init'),
        $formBuilder__loadConfiguration : document.getElementsByClassName('formbuilder-load'),
        $formBuilder__updateConfiguration : document.getElementsByClassName('update_form'),
        $formBuilder__settings : document.getElementsByClassName('settings'),

    },

    data: {
        countNewfield : 0
    },
    regex: {
        getClass : 'getConf-*',
        settings : 'settings-*'
    },

    /**
     * Initialize formbuilder
     */
    init: function () {
        this.log('form', 'init');
        let emptySelectValue = true;
        let contentType = null;

        if (this.selectors.$formBuilder__buildNewForm.length > 0) {
            let json = require('../configurations/init-builder.json');
            this.fieldsBuilder(json, emptySelectValue);
        }
        if ((this.selectors.$formBuilder__loadConfiguration.length > 0 && this.selectors.$formBuilder__updateConfiguration.length === 0) ||
            (this.selectors.$formBuilder__loadConfiguration.length > 0 && this.selectors.$formBuilder__updateConfiguration.length > 0)) {

            contentType = this.getConfigurationFile(this.selectors.$formBuilder__loadConfiguration);
            if (contentType === '') {
                 this.showError();
            }else{
                emptySelectValue = !this.selectors.$formBuilder__updateConfiguration.length > 0;
                let json = require(`../configurations/custom/temp/${contentType}.json`);
                this.fieldsBuilder(json, emptySelectValue);
            }
        }
        if (this.selectors.$formBuilder__settings.length > 0) {
            let regex = RegExp(this.regex.settings);
            this.selectors.$formBuilder.classList.forEach( function (elt){
                if(regex.test(elt)){
                    contentType = elt;
                }
            });

            emptySelectValue = !this.selectors.$formBuilder__updateConfiguration.length > 0;
            let json = require(`../configurations/${contentType}.json`);
            this.fieldsBuilder(json, emptySelectValue);
        }
    },
    /**
     * Event on button 'Add new field' and add fields wich help us to add a new custom field in form
     */
    addNewField() {

        let jsonFields = require('../configurations/new-field.json');
        this.fieldsBuilder(jsonFields);
    },

    /**
    * Action when cancel button is clicked
    */
    deleteChoiceform(){
        let choiceForm = document.querySelector('.form_field_choice');
        let parent = document.querySelector('.admin-form');
        parent.removeChild(choiceForm);
    },

    /**
     * Sort the field sets in Json configuration file and build the field and add them in DOM.
     * @param json
     * @param {boolean } emptySelectValue
     */
    fieldsBuilder(json, emptySelectValue) {

        let keys = Object.keys(json);

        for (let field of keys) {
            switch (field) {
                case 'fieldset':
                case 'legend':

                    this.setSimpleField(field, json[field], emptySelectValue);
                    break;

                case 'fields':
                case 'select':
                case 'buttons':
                    this.setArrayField(field, json[field], emptySelectValue);
                    break;
            }
        }
    },

    /**
     * Build simple field
     * @param type
     * @param data
     * @param {boolean} emptySelectValue
     */
    setSimpleField(type, data, emptySelectValue) {

        let inDom = document.createElement(type);

        if (data.id) {
            inDom.setAttribute('id', data.id);
        }

        if (data.class !== []) {
            for (let i of data.class) {
                inDom.classList.add(i);
            }
        }

        if (data.content) {

            inDom.innerHTML = emptySelectValue ? '' : data.content;
        }

        if (data.group) {
            let target = document.getElementsByClassName(data.group);
            target[0].appendChild(inDom);
        } else {
            console.error(`Error : can\'t insert element ${type} in  DOM`);
        }
    },

    /**
     * Set field collection (in array)
     * @param type
     * @param data
     * @param {boolean} emptySelectValue
     */
    setArrayField(type, data, emptySelectValue) {

        let obj;
        let inDom;
        let previewImage = null;
        for (obj of data) {
            for (let field in obj) {
                if (obj.hasOwnProperty(field)) {

                    inDom = document.createElement(field);

                    if (obj[field].id) {
                        inDom.setAttribute('id', obj[field].id);
                    }
                    if (obj[field].for) {
                        inDom.setAttribute('for', obj[field].for);
                    }
                    if (obj[field].name) {
                        inDom.setAttribute('name', obj[field].name);
                    }
                    if (obj[field].type) {
                        inDom.setAttribute('type', obj[field].type);
                    }
                    if (obj[field].value) {
                        switch(field) {
                            case 'textarea':

                                inDom.innerHTML = emptySelectValue ? '' : obj[field].value;
                                break;

                            case 'input':

                                    inDom.setAttribute('value', obj[field].value);
                                break;

                            default:
                                let value =  emptySelectValue ? '' : obj[field].value;
                                inDom.setAttribute('value', value);
                        }
                    }
                    if (obj[field].checked) {
                        inDom.setAttribute('checked', obj[field].checked);
                    }
                    if (obj[field].placeholder) {
                        inDom.setAttribute('placeholder', obj[field].placeholder);
                    }
                    if (obj[field].content) {
                        inDom.innerHTML = obj[field].content;
                    }
                    if (obj[field].class !== []) {
                        for (let i of obj[field].class) {
                            inDom.classList.add(i);
                        }
                    }
                    if (obj[field].url) {
                        // add preview if url is not true (empty)
                        previewImage = document.createElement('img');
                        previewImage.setAttribute('src', obj[field].url);
                        inDom.innerHTML = obj[field].url;
                    }
                    if (obj[field].path) {
                        inDom.innerHTML = obj[field].path;
                    }
                    if (obj[field].option){
                        this.addSelectOptions(obj, inDom,  emptySelectValue);
                    }
                    if (obj[field].group) {
                        let target = document.getElementsByClassName(obj[field].group);
                        target[0].appendChild(inDom);
                        if(previewImage !== null) {
                            target[0].appendChild(previewImage);
                        }
                    } else {
                        console.error(`Error : can't insert element ${field} in  DOM`);
                    }
                    if (field === 'label' && obj[field].labelDisplay) {
                        inDom.innerHTML = obj[field].labelDisplay;

                    }
                    if(obj[field].eventListener){
                        this.addElementListener(obj[field].eventListener, inDom);
                    }
                }
            }
        }
    },

    /**
     * Build dynamically the field selector wich help to add field in form.
     * @param parent
     * @param inDom
     */
    addSelectOptions(parent, inDom) {

        for (let child in parent) {

            if (parent.hasOwnProperty(child)) {
                if (parent[child].id) {
                    inDom.setAttribute('id', parent[child].id);
                }
                if (parent[child].name) {
                    inDom.setAttribute('name', parent[child].name);
                }
                if (parent[child].defaultField) {
                    let defaultField = document.createElement('option');
                    defaultField.setAttribute('value', parent[child].value);
                    defaultField.setAttribute('selected', 'selected');
                    defaultField.innerHTML = parent[child].defaultField;
                    inDom.appendChild(defaultField);
                }
                if (parent[child].value) {
                    inDom.setAttribute('value', parent[child].value);
                }

                if (parent[child].class !== []) {
                    for (let i of parent[child].class) {
                        inDom.classList.add(i);
                    }
                }
                if (parent[child].checked) {
                    inDom.setAttribute('checked', parent[child].checked);
                }
                if (parent[child].option) {
                    let json;
                    // select init form
                    if (parent[child].option === 'fields-list' ) {
                        // From configuration file init form
                        let path = parent[child].option;
                        json = require(`../configurations/${path}.json`);
                        for (let item in json) {

                            if (json.hasOwnProperty(item)) {

                                let option = document.createElement('option');
                                option.setAttribute('value', item);
                                option.innerHTML = item;
                                inDom.appendChild(option);
                            }
                        }
                    }
                    // from config file when we create a content type or update
                    else if (Array.isArray(parent[child].option)) {
                        // From select form
                        for (let item of parent[child].option[0]) {
                            let option = document.createElement('option');

                            if (parent[child].value === item.id) {
                                option.setAttribute('selected', 'selected');
                            }
                            option.setAttribute('name', item.name);
                            option.setAttribute('value', item.id);
                            option.innerHTML = item.name;
                            inDom.appendChild(option);
                        }
                    }
                }

                if (parent[child].group) {
                    let target = document.getElementsByClassName(parent[child].group);
                    target[0].appendChild(inDom);
                } else {
                    console.error(`Error : can't insert element ${parent} in  DOM`);
                }

            }
        }
    },

    /**
     * Get new fields selected in little form and render all the field needed for building a new field
     * Insert collection if field in DOM
     */
    newFieldSelected(field){

        let json = require(`../configurations/fieldsConfigurations/${field}.json`);
        let toDom = [];
        let rank = this.counter();

        for(let item in json) {

            if (json.hasOwnProperty(item)){

                this.buildField(item, json, toDom, rank);
            }
        }

        let parent = this.newFieldGroupContainer(field, rank);
        toDom.forEach(elt => {
            parent.appendChild(elt);
        });

        this.addDeleteGroupButton(parent, rank);

        document.getElementsByClassName(json.group)[0].appendChild(parent);
    },

    /**
     * Build group of necessary fields for build a new field in add content form
     * @param type
     * @param datas
     * @param toDom
     * @param rank
     * @returns {number | * | boolean}
     */
    buildField(type, datas, toDom, rank){

        let wrapper = this.fieldWrapper();
        let newInput;
        let newLabel;
        let imagePreview = null;
        switch(type){
            case 'labelDisplay':
            case 'type':
            case 'name':
            case 'for':
            case 'id':
            case 'class':
            case 'value':
            case 'placeholder':
            case 'fileUrl':
            case 'filePath':

                newLabel = document.createElement('label');
                newLabel.setAttribute('for', `${type}_${rank}`);
                newLabel.innerHTML = Tools.camelCaseToString(type);

                newInput = document.createElement('input');
                newInput.setAttribute('name', `${type}_${rank}`);

                if (type === 'type') {
                    newInput.setAttribute('value', this.getInputType(datas));
                }
                newInput.setAttribute('placeholder', Tools.camelCaseToString(type));

                wrapper.appendChild(newLabel);
                wrapper.appendChild(newInput);
                break;

            case 'labelRef':

                newLabel = document.createElement('label');
                newLabel.setAttribute('for', `${type}_${rank}`);
                newLabel.innerHTML = Tools.camelCaseToString('Entité référence');

                newInput = document.createElement('select');
                newInput.setAttribute('name', `${type}_${rank}`);

                // Default field
                let defaultField = document.createElement('option');
                defaultField.setAttribute('value', '');
                defaultField.innerHTML = datas.defaultField;
                newInput.appendChild(defaultField);

                let jsonOptions = require(`../configurations/custom/taxonomy/taxonomy_list.json`);
                let option;
                for(let elt in jsonOptions){
                    option = document.createElement('option');
                    option.setAttribute('value', `${elt}_${jsonOptions[elt]}`);
                    option.innerHTML = Tools.ucFirst(jsonOptions[elt]);
                    newInput.appendChild(option);
                }

                wrapper.appendChild(newLabel);
                wrapper.appendChild(newInput);

                break;
            case 'idRef' :
                newInput = document.createElement('input');
                newInput.setAttribute('name', `${type}_${rank}`);
                newInput.setAttribute('type', 'hidden');

                wrapper.appendChild(newInput);

                break;

            case 'fieldType':
            case 'group':

                newInput = document.createElement('input');
                newInput.setAttribute('name', `${type}_${rank}`);
                newInput.setAttribute('value', `${datas[type]}`);
                newInput.setAttribute('type', 'hidden');

                wrapper.appendChild(newInput);
            break;
        }

        return toDom.push(wrapper);
    },

    /**
     * Build new field wrapper
     * @param wrapClass
     * @returns {HTMLDivElement}
     */
    fieldWrapper(wrapClass) {
        let wrapper;

        if (Tools.empty(wrapClass)) {

            wrapper = document.createElement('div');
            wrapper.classList.add('wrap_newField');

        } else {
            wrapper = document.createElement('div');
            wrapper.classList.add(wrapClass);
        }
        return wrapper;
    },

    /**
     * Add fieldset an legend for each new field group
     * @param fieldType
     * @returns {HTMLFieldSetElement}
     */
    newFieldGroupContainer(fieldType, rank) {
        let group = document.createElement('fieldset');
        let legend = document.createElement('legend');
        group.setAttribute('id', `group-${rank}`);
        group.classList.add('new-field-group');
        legend.innerHTML = `Nouveau champ type ${fieldType} ${rank}`;
        group.appendChild(legend);
        return group;
    },

    /**
     * Add button in group which help to delete any group
     * @param parent
     * @param count
     */
    addDeleteGroupButton(parent, count){
        let btnDelete = document.createElement('button');
        btnDelete.classList.add('btn_delete');
        btnDelete.setAttribute('data-count', count);
        btnDelete.innerHTML = 'Supprimer ce group';
        parent.appendChild(btnDelete);
        btnDelete.addEventListener('click', ListenersCallback.deleteGroupButton);
    },

    /**
     * Count each new field
     *
     * @returns {number}
     */
    counter(){
        let groupNumber = document.getElementsByClassName('new-field-group').length;

        if(groupNumber === 0){
            this.data.countNewfield = 0;
        }
        return parseInt(++this.data.countNewfield);
    },

    /**
     * Add event on button dynamically
     * @param elt
     * @param inDom
     */
    addElementListener(elt, inDom){

        if (typeof ListenersCallback[elt.callback] === "function") {

            let callback = ListenersCallback[elt.callback];
            inDom.addEventListener(elt.type, callback);
        }
    },

    /**
     * Get content type from css class
     * @param form
     * @returns {string}
     */
    getConfigurationFile(form){
        let contentType = '';
        var regex = RegExp(this.regex.getClass);
        form[0].classList.forEach( function (elt){
            if(regex.test(elt)){
                let chunks = elt.split('-');
                contentType = chunks[1];
            }
        });

        return contentType;
    },
    /**
     * @TODO fonction à écrire dans le cas où il n'y a pas de contenu
     * afficher l'erreur dans le DOM => flash message
     */
    showError(){},

    /**
     * Return input type
     * @param datas {Object}
     * @returns {string}
     */
    getInputType(datas) {
        return  datas.fieldType === 'input' ? datas.type : '';
    }
};

/* Class could be import from any other file like this :
  import {FormBuilderManager} from "../formBuilderManager";
*/
export {FormBuilderManager};

/**
 * Run init function of app
 * when the document is ready
 */
$(document).ready(function () {
    FormBuilderManager.init();
});
