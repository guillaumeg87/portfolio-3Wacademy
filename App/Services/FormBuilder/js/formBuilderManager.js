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
        $formBuilderBlock: document.getElementsByClassName('formbuilder')
    },

    data: {
        countNewfield : 0
    },

    /**
     * Initialize formbuilder
     */
    init() {
        this.log('form', 'init');
        if (this.selectors.$formBuilderBlock.length > 0) {
            let json = require('../configurations/init-builder.json');
            this.fieldsBuilder(json);
        }
    },
    /**
     * Event on button 'Add new field' and add fields wich help us to add a new custom field in form
     * @param
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
     */
    fieldsBuilder(json) {

        let keys = Object.keys(json);

        for (let field of keys) {
            switch (field) {
                case 'fieldset':
                case 'legend':

                    this.setSimpleField(field, json[field]);
                    break;

                case 'fields':
                case 'select':
                case 'buttons':
                    this.setArrayField(field, json[field]);
                    break;
            }
        }
    },

    /**
     * Build simple field
     * @param type
     * @param data
     */
    setSimpleField(type, data) {

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
            inDom.innerHTML = data.content;
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
     */
    setArrayField(type, data) {

        let obj;
        let inDom;

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
                        inDom.setAttribute('value', obj[field].value);
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
                    if (obj[field].group) {
                        let target = document.getElementsByClassName(obj[field].group);
                        target[0].appendChild(inDom);
                    } else {
                        console.error(`Error : can't insert element ${field} in  DOM`);
                    }
                    if(obj[field].eventListener){
                        this.addElementListener(obj[field].eventListener, inDom);
                    }
                }

            }
        }
        if (type === 'select'){
            this.addSelectOptions(obj, inDom);
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

                if (parent[child].options) {
                    let path = parent[child].options;
                    let json = require(`../configurations/${path}.json`);

                    for (let item in json) {

                        if (json.hasOwnProperty(item)) {

                                let option = document.createElement('option');
                                option.setAttribute('value', item);
                                option.innerHTML = item;
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

        switch(type){
            case 'labelDisplay':
            case 'type':
            case 'name':
            case 'for':
            case 'id':
            case 'class':
            case 'value':
            case 'placeholder':

                newLabel = document.createElement('label');
                newLabel.setAttribute('for', `${type}_${rank}`);
                newLabel.innerHTML = Tools.camelCaseToString(type);

                newInput = document.createElement('input');
                newInput.setAttribute('name', `${type}_${rank}`);
                newInput.setAttribute('type', 'text');
                newInput.setAttribute('placeholder', Tools.camelCaseToString(type));

                wrapper.appendChild(newLabel);
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
