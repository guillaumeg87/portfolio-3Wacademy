/**
 * FormBuilderManager
 *
 * @namespace FormBuilderManager
 */
const Tools = {
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

    /**
     * Return string with First letter Upper case
     * Exemple = entry hello => return Hello
     *
     * @param label
     * @returns {string|*}
     */
    ucFirst(label){
        this.log('tool', label);
        if (label.length > 0) {
            return label[0].toUpperCase() + label.substring(1);
        } else {
            return label;
        }
    },
    /**
     * Return camelCase string in String Displayable
     * Exemple = entry camelCase => return Camel case
     * @param label
     * @returns {string|*}
     */
    camelCaseToString(label){
        if (label.length > 0) {
            let array = label.split(/(?=[A-Z])/);

            let str = '';
            if (array.length === 1){

                return this.ucFirst(label);
            }

            for(let i = 0; i < array.length; i++){

                if(i === 0){
                    str += this.ucFirst(array[i]) + ' ';
                }else{
                    str += array[i].toLowerCase() + (array[i] === array.length - 1 ? '' : ' ');
                }
            }

            return str;
        } else {
            return label;
        }

    },
    /**
     * Test if variable is empty or not
     * @param isTested
     * @returns {boolean}
     */
    empty(isTested){

        if (isTested === null || isTested === undefined || isTested === '' || isTested === []) {
            return true;
        }else{
            return false;
        }
    }
};

export {Tools};

