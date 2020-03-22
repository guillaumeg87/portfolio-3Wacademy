/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./App/Assets/js/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./App/Assets/js/index.js":
/*!********************************!*\
  !*** ./App/Assets/js/index.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("__webpack_require__(/*! ../scss/main.scss */ \"./App/Assets/scss/main.scss\");\n/****************/\n\n/*     TOOLS    */\n\n/****************/\n\n\n__webpack_require__(/*! ./tools/tools */ \"./App/Assets/js/tools/tools.js\");\n/****************/\n\n/* FORM BUILDER */\n\n/****************/\n// formbuilder\n\n\n__webpack_require__(/*! ../../Services/FormBuilder/js/formBuilderManager.js */ \"./App/Services/FormBuilder/js/formBuilderManager.js\");\n\n__webpack_require__(/*! ../../Services/FormBuilder/js/EventsCallback/ListenersCallback.js */ \"./App/Services/FormBuilder/js/EventsCallback/ListenersCallback.js\");\n\n//# sourceURL=webpack:///./App/Assets/js/index.js?");

/***/ }),

/***/ "./App/Assets/js/tools/tools.js":
/*!**************************************!*\
  !*** ./App/Assets/js/tools/tools.js ***!
  \**************************************/
/*! exports provided: Tools */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"Tools\", function() { return Tools; });\n/**\n * FormBuilderManager\n *\n * @namespace FormBuilderManager\n */\nvar Tools = {\n  debug: false,\n\n  /**\n   * Log something in console\n   *\n   * @param {string} context\n   * @param {*} message\n   */\n  log: function log(context, message) {\n    if (this.debug) {\n      console.log(context + ': ' + message);\n    }\n  },\n\n  /**\n   * Return string with First letter Upper case\n   * Exemple = entry hello => return Hello\n   *\n   * @param label\n   * @returns {string|*}\n   */\n  ucFirst: function ucFirst(label) {\n    this.log('tool', label);\n\n    if (label.length > 0) {\n      return label[0].toUpperCase() + label.substring(1);\n    } else {\n      return label;\n    }\n  },\n\n  /**\n   * Return camelCase string in String Displayable\n   * Exemple = entry camelCase => return Camel case\n   * @param label\n   * @returns {string|*}\n   */\n  camelCaseToString: function camelCaseToString(label) {\n    if (label.length > 0) {\n      var array = label.split(/(?=[A-Z])/);\n      var str = '';\n\n      if (array.length === 1) {\n        return this.ucFirst(label);\n      }\n\n      for (var i = 0; i < array.length; i++) {\n        if (i === 0) {\n          str += this.ucFirst(array[i]) + ' ';\n        } else {\n          str += array[i].toLowerCase() + (array[i] === array.length - 1 ? '' : ' ');\n        }\n      }\n\n      return str;\n    } else {\n      return label;\n    }\n  },\n\n  /**\n   * Test if variable is empty or not\n   * @param isTested\n   * @returns {boolean}\n   */\n  empty: function empty(isTested) {\n    if (isTested === null || isTested === undefined || isTested === '' || isTested === []) {\n      return true;\n    } else {\n      return false;\n    }\n  }\n};\n\n\n//# sourceURL=webpack:///./App/Assets/js/tools/tools.js?");

/***/ }),

/***/ "./App/Assets/scss/main.scss":
/*!***********************************!*\
  !*** ./App/Assets/scss/main.scss ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// extracted by mini-css-extract-plugin\n    if(false) { var cssReload; }\n  \n\n//# sourceURL=webpack:///./App/Assets/scss/main.scss?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations sync recursive ^\\.\\/.*\\.json$":
/*!*********************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations sync ^\.\/.*\.json$ ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var map = {\n\t\"./config-base.json\": \"./App/Services/FormBuilder/configurations/config-base.json\",\n\t\"./config-model.json\": \"./App/Services/FormBuilder/configurations/config-model.json\",\n\t\"./custom/content/content_list.json\": \"./App/Services/FormBuilder/configurations/custom/content/content_list.json\",\n\t\"./custom/langage_taxonomy.json\": \"./App/Services/FormBuilder/configurations/custom/langage_taxonomy.json\",\n\t\"./custom/settings/settings_list.json\": \"./App/Services/FormBuilder/configurations/custom/settings/settings_list.json\",\n\t\"./custom/taxonomy/taxonomy_list.json\": \"./App/Services/FormBuilder/configurations/custom/taxonomy/taxonomy_list.json\",\n\t\"./custom/temp/user_settings.json\": \"./App/Services/FormBuilder/configurations/custom/temp/user_settings.json\",\n\t\"./custom/user_settings.json\": \"./App/Services/FormBuilder/configurations/custom/user_settings.json\",\n\t\"./fields-list.json\": \"./App/Services/FormBuilder/configurations/fields-list.json\",\n\t\"./fieldsConfigurations/checkbox.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/checkbox.json\",\n\t\"./fieldsConfigurations/entity-reference.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/entity-reference.json\",\n\t\"./fieldsConfigurations/file.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/file.json\",\n\t\"./fieldsConfigurations/input.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/input.json\",\n\t\"./fieldsConfigurations/radio.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/radio.json\",\n\t\"./fieldsConfigurations/select.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/select.json\",\n\t\"./fieldsConfigurations/text.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/text.json\",\n\t\"./fieldsConfigurations/textarea.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/textarea.json\",\n\t\"./init-builder.json\": \"./App/Services/FormBuilder/configurations/init-builder.json\",\n\t\"./new-field.json\": \"./App/Services/FormBuilder/configurations/new-field.json\"\n};\n\n\nfunction webpackContext(req) {\n\tvar id = webpackContextResolve(req);\n\treturn __webpack_require__(id);\n}\nfunction webpackContextResolve(req) {\n\tif(!__webpack_require__.o(map, req)) {\n\t\tvar e = new Error(\"Cannot find module '\" + req + \"'\");\n\t\te.code = 'MODULE_NOT_FOUND';\n\t\tthrow e;\n\t}\n\treturn map[req];\n}\nwebpackContext.keys = function webpackContextKeys() {\n\treturn Object.keys(map);\n};\nwebpackContext.resolve = webpackContextResolve;\nmodule.exports = webpackContext;\nwebpackContext.id = \"./App/Services/FormBuilder/configurations sync recursive ^\\\\.\\\\/.*\\\\.json$\";\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations_sync_^\\.\\/.*\\.json$?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/config-base.json":
/*!******************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/config-base.json ***!
  \******************************************************************/
/*! exports provided: fieldset, legend, fields, buttons, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldset\\\":{\\\"id\\\":\\\"\\\",\\\"class\\\":[]},\\\"legend\\\":{\\\"content\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[]},\\\"fields\\\":[{\\\"label\\\":{\\\"content\\\":\\\"\\\",\\\"for\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[]},\\\"input\\\":{\\\"type\\\":\\\"\\\",\\\"name\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"value\\\":\\\"\\\",\\\"placeholder\\\":\\\"\\\"}}],\\\"buttons\\\":[{\\\"button\\\":{\\\"type\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"value\\\":\\\"\\\"}}]}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/config-base.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/config-model.json":
/*!*******************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/config-model.json ***!
  \*******************************************************************/
/*! exports provided: fieldset, legend, fields, buttons, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldset\\\":{\\\"id\\\":\\\"\\\",\\\"class\\\":[]},\\\"legend\\\":{\\\"content\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[]},\\\"fields\\\":[],\\\"buttons\\\":[]}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/config-model.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/custom/content/content_list.json":
/*!**********************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/custom/content/content_list.json ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"[]\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/custom/content/content_list.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/custom/langage_taxonomy.json":
/*!******************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/custom/langage_taxonomy.json ***!
  \******************************************************************************/
/*! exports provided: fieldset, legend, fields, buttons, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldset\\\":{\\\"id\\\":\\\"\\\",\\\"class\\\":[\\\"admin-form\\\"],\\\"group\\\":\\\"formbuilder-load\\\"},\\\"legend\\\":{\\\"content\\\":\\\"Nouveau langage\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"},\\\"fields\\\":[{\\\"label\\\":{\\\"labelDisplay\\\":\\\"Nom\\\",\\\"value\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\",\\\"for\\\":\\\"name\\\"},\\\"input\\\":{\\\"labelDisplay\\\":\\\"Nom\\\",\\\"type\\\":\\\"text\\\",\\\"name\\\":\\\"name\\\",\\\"value\\\":\\\"\\\",\\\"placeholder\\\":\\\"PHP\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"labelDisplay\\\":\\\"Documentation\\\",\\\"value\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\",\\\"for\\\":\\\"doumentation\\\"},\\\"input\\\":{\\\"labelDisplay\\\":\\\"Documentation\\\",\\\"type\\\":\\\"text\\\",\\\"name\\\":\\\"doumentation\\\",\\\"value\\\":\\\"\\\",\\\"placeholder\\\":\\\"https://www.php.net\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"labelDisplay\\\":\\\"Logo\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\",\\\"for\\\":\\\"logo\\\"},\\\"input\\\":{\\\"labelDisplay\\\":\\\"Logo\\\",\\\"path\\\":\\\"\\\",\\\"url\\\":\\\"\\\",\\\"type\\\":\\\"file\\\",\\\"name\\\":\\\"logo\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\"}}],\\\"buttons\\\":[{\\\"button\\\":{\\\"type\\\":\\\"submit\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[\\\"form-btn-submit\\\"],\\\"content\\\":\\\"validez\\\",\\\"group\\\":\\\"formbuilder-load\\\"}}]}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/custom/langage_taxonomy.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/custom/settings/settings_list.json":
/*!************************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/custom/settings/settings_list.json ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"[]\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/custom/settings/settings_list.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/custom/taxonomy/taxonomy_list.json":
/*!************************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/custom/taxonomy/taxonomy_list.json ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/custom/taxonomy/taxonomy_list.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/custom/temp sync recursive ^\\.\\/.*\\.json$":
/*!*********************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/custom/temp sync ^\.\/.*\.json$ ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var map = {\n\t\"./user_settings.json\": \"./App/Services/FormBuilder/configurations/custom/temp/user_settings.json\"\n};\n\n\nfunction webpackContext(req) {\n\tvar id = webpackContextResolve(req);\n\treturn __webpack_require__(id);\n}\nfunction webpackContextResolve(req) {\n\tif(!__webpack_require__.o(map, req)) {\n\t\tvar e = new Error(\"Cannot find module '\" + req + \"'\");\n\t\te.code = 'MODULE_NOT_FOUND';\n\t\tthrow e;\n\t}\n\treturn map[req];\n}\nwebpackContext.keys = function webpackContextKeys() {\n\treturn Object.keys(map);\n};\nwebpackContext.resolve = webpackContextResolve;\nmodule.exports = webpackContext;\nwebpackContext.id = \"./App/Services/FormBuilder/configurations/custom/temp sync recursive ^\\\\.\\\\/.*\\\\.json$\";\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/custom/temp_sync_^\\.\\/.*\\.json$?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/custom/temp/user_settings.json":
/*!********************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/custom/temp/user_settings.json ***!
  \********************************************************************************/
/*! exports provided: fieldset, legend, fields, buttons, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldset\\\":{\\\"id\\\":\\\"\\\",\\\"class\\\":[\\\"admin-form\\\"],\\\"group\\\":\\\"formbuilder-load\\\"},\\\"legend\\\":{\\\"content\\\":\\\"Nouveau utilisateur\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"},\\\"fields\\\":[{\\\"label\\\":{\\\"labelDisplay\\\":\\\"Login\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\",\\\"for\\\":\\\"login\\\"},\\\"input\\\":{\\\"labelDisplay\\\":\\\"Login\\\",\\\"type\\\":\\\"text\\\",\\\"name\\\":\\\"login\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"gge\\\",\\\"placeholder\\\":\\\"Login\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"labelDisplay\\\":\\\"Mot de passe\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\",\\\"for\\\":\\\"password\\\"},\\\"input\\\":{\\\"labelDisplay\\\":\\\"Mot de passe\\\",\\\"type\\\":\\\"password\\\",\\\"name\\\":\\\"password\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"c77cab1ee6c708b3ab9630803bfc670098bd5bbb\\\",\\\"placeholder\\\":\\\"Mot de passe\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"labelDisplay\\\":\\\"Email\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\",\\\"for\\\":\\\"email\\\"},\\\"input\\\":{\\\"labelDisplay\\\":\\\"Email\\\",\\\"type\\\":\\\"text\\\",\\\"name\\\":\\\"email\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"gguillaumemail@gmail.com\\\",\\\"placeholder\\\":\\\"Email\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"labelDisplay\\\":\\\"Super Admin\\\",\\\"value\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\",\\\"for\\\":\\\"isSuperAdmin\\\"},\\\"input\\\":{\\\"labelDisplay\\\":\\\"Super Admin\\\",\\\"type\\\":\\\"checkbox\\\",\\\"name\\\":\\\"isSuperAdmin\\\",\\\"value\\\":true,\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"input\\\":{\\\"type\\\":\\\"hidden\\\",\\\"name\\\":\\\"id\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"1\\\",\\\"group\\\":\\\"admin-form\\\"}}],\\\"buttons\\\":[{\\\"button\\\":{\\\"type\\\":\\\"submit\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[\\\"form-btn-submit\\\"],\\\"content\\\":\\\"validez\\\",\\\"group\\\":\\\"formbuilder-load\\\"}}]}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/custom/temp/user_settings.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/custom/user_settings.json":
/*!***************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/custom/user_settings.json ***!
  \***************************************************************************/
/*! exports provided: fieldset, legend, fields, buttons, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldset\\\":{\\\"id\\\":\\\"\\\",\\\"class\\\":[\\\"admin-form\\\"],\\\"group\\\":\\\"formbuilder-load\\\"},\\\"legend\\\":{\\\"content\\\":\\\"Nouveau utilisateur\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"},\\\"fields\\\":[{\\\"label\\\":{\\\"labelDisplay\\\":\\\"Login\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\",\\\"for\\\":\\\"login\\\"},\\\"input\\\":{\\\"labelDisplay\\\":\\\"Login\\\",\\\"type\\\":\\\"text\\\",\\\"name\\\":\\\"login\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"\\\",\\\"placeholder\\\":\\\"Login\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"labelDisplay\\\":\\\"Mot de passe\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\",\\\"for\\\":\\\"password\\\"},\\\"input\\\":{\\\"labelDisplay\\\":\\\"Mot de passe\\\",\\\"type\\\":\\\"password\\\",\\\"name\\\":\\\"password\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"\\\",\\\"placeholder\\\":\\\"Mot de passe\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"labelDisplay\\\":\\\"Email\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\",\\\"for\\\":\\\"email\\\"},\\\"input\\\":{\\\"labelDisplay\\\":\\\"Email\\\",\\\"type\\\":\\\"text\\\",\\\"name\\\":\\\"email\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"value\\\":\\\"\\\",\\\"placeholder\\\":\\\"Email\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"labelDisplay\\\":\\\"Super Admin\\\",\\\"value\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\",\\\"for\\\":\\\"isSuperAdmin\\\"},\\\"input\\\":{\\\"labelDisplay\\\":\\\"Super Admin\\\",\\\"type\\\":\\\"checkbox\\\",\\\"name\\\":\\\"isSuperAdmin\\\",\\\"value\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\"}}],\\\"buttons\\\":[{\\\"button\\\":{\\\"type\\\":\\\"submit\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[\\\"form-btn-submit\\\"],\\\"content\\\":\\\"validez\\\",\\\"group\\\":\\\"formbuilder-load\\\"}}]}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/custom/user_settings.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/fields-list.json":
/*!******************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/fields-list.json ***!
  \******************************************************************/
/*! exports provided: text, select, checkbox, radio, textarea, file, entity-reference, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"text\\\":\\\"\\\",\\\"select\\\":\\\"\\\",\\\"checkbox\\\":\\\"\\\",\\\"radio\\\":\\\"\\\",\\\"textarea\\\":\\\"\\\",\\\"file\\\":\\\"\\\",\\\"entity-reference\\\":\\\"\\\"}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/fields-list.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/fieldsConfigurations sync recursive ^\\.\\/.*\\.json$":
/*!******************************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/fieldsConfigurations sync ^\.\/.*\.json$ ***!
  \******************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var map = {\n\t\"./checkbox.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/checkbox.json\",\n\t\"./entity-reference.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/entity-reference.json\",\n\t\"./file.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/file.json\",\n\t\"./input.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/input.json\",\n\t\"./radio.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/radio.json\",\n\t\"./select.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/select.json\",\n\t\"./text.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/text.json\",\n\t\"./textarea.json\": \"./App/Services/FormBuilder/configurations/fieldsConfigurations/textarea.json\"\n};\n\n\nfunction webpackContext(req) {\n\tvar id = webpackContextResolve(req);\n\treturn __webpack_require__(id);\n}\nfunction webpackContextResolve(req) {\n\tif(!__webpack_require__.o(map, req)) {\n\t\tvar e = new Error(\"Cannot find module '\" + req + \"'\");\n\t\te.code = 'MODULE_NOT_FOUND';\n\t\tthrow e;\n\t}\n\treturn map[req];\n}\nwebpackContext.keys = function webpackContextKeys() {\n\treturn Object.keys(map);\n};\nwebpackContext.resolve = webpackContextResolve;\nmodule.exports = webpackContext;\nwebpackContext.id = \"./App/Services/FormBuilder/configurations/fieldsConfigurations sync recursive ^\\\\.\\\\/.*\\\\.json$\";\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/fieldsConfigurations_sync_^\\.\\/.*\\.json$?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/fieldsConfigurations/checkbox.json":
/*!************************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/fieldsConfigurations/checkbox.json ***!
  \************************************************************************************/
/*! exports provided: fieldType, labelDisplay, type, name, value, checked, id, class, group, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldType\\\":\\\"input\\\",\\\"labelDisplay\\\":\\\"\\\",\\\"type\\\":\\\"checkbox\\\",\\\"name\\\":\\\"\\\",\\\"value\\\":false,\\\"checked\\\":false,\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/fieldsConfigurations/checkbox.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/fieldsConfigurations/entity-reference.json":
/*!********************************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/fieldsConfigurations/entity-reference.json ***!
  \********************************************************************************************/
/*! exports provided: fieldType, labelDisplay, defaultField, name, id, class, labelRef, idRef, option, group, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldType\\\":\\\"entityReference\\\",\\\"labelDisplay\\\":\\\"entity reference\\\",\\\"defaultField\\\":\\\"-- Choisissez une options --\\\",\\\"name\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"labelRef\\\":\\\"\\\",\\\"idRef\\\":\\\"\\\",\\\"option\\\":[],\\\"group\\\":\\\"admin-form\\\"}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/fieldsConfigurations/entity-reference.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/fieldsConfigurations/file.json":
/*!********************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/fieldsConfigurations/file.json ***!
  \********************************************************************************/
/*! exports provided: fieldType, labelDisplay, type, name, id, class, group, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldType\\\":\\\"input\\\",\\\"labelDisplay\\\":\\\"\\\",\\\"type\\\":\\\"file\\\",\\\"name\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/fieldsConfigurations/file.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/fieldsConfigurations/input.json":
/*!*********************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/fieldsConfigurations/input.json ***!
  \*********************************************************************************/
/*! exports provided: fieldType, labelDisplay, type, name, id, class, value, placeholder, group, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldType\\\":\\\"input\\\",\\\"labelDisplay\\\":\\\"\\\",\\\"type\\\":\\\"\\\",\\\"name\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"value\\\":\\\"\\\",\\\"placeholder\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\"}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/fieldsConfigurations/input.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/fieldsConfigurations/radio.json":
/*!*********************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/fieldsConfigurations/radio.json ***!
  \*********************************************************************************/
/*! exports provided: fieldType, labelDisplay, type, value, checked, name, id, class, group, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldType\\\":\\\"radio\\\",\\\"labelDisplay\\\":\\\"\\\",\\\"type\\\":\\\"radio\\\",\\\"value\\\":\\\"\\\",\\\"checked\\\":false,\\\"name\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":\\\"\\\",\\\"group\\\":\\\"admin-form\\\"}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/fieldsConfigurations/radio.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/fieldsConfigurations/select.json":
/*!**********************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/fieldsConfigurations/select.json ***!
  \**********************************************************************************/
/*! exports provided: fieldType, labelDisplay, name, id, class, defaultField, labelRef, idRef, option, group, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldType\\\":\\\"select\\\",\\\"labelDisplay\\\":\\\"\\\",\\\"name\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"defaultField\\\":\\\"-- Choisissez une options --\\\",\\\"labelRef\\\":\\\"\\\",\\\"idRef\\\":\\\"\\\",\\\"option\\\":[],\\\"group\\\":\\\"admin-form\\\"}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/fieldsConfigurations/select.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/fieldsConfigurations/text.json":
/*!********************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/fieldsConfigurations/text.json ***!
  \********************************************************************************/
/*! exports provided: fieldType, labelDisplay, type, name, value, placeholder, id, class, group, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldType\\\":\\\"input\\\",\\\"labelDisplay\\\":\\\"\\\",\\\"type\\\":\\\"text\\\",\\\"name\\\":\\\"\\\",\\\"value\\\":\\\"\\\",\\\"placeholder\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/fieldsConfigurations/text.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/fieldsConfigurations/textarea.json":
/*!************************************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/fieldsConfigurations/textarea.json ***!
  \************************************************************************************/
/*! exports provided: fieldType, labelDisplay, name, id, class, value, placeholder, rows, cols, group, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldType\\\":\\\"textarea\\\",\\\"labelDisplay\\\":\\\"\\\",\\\"name\\\":\\\"\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"value\\\":\\\"\\\",\\\"placeholder\\\":\\\"\\\",\\\"rows\\\":5,\\\"cols\\\":80,\\\"group\\\":\\\"admin-form\\\"}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/fieldsConfigurations/textarea.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/init-builder.json":
/*!*******************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/init-builder.json ***!
  \*******************************************************************/
/*! exports provided: fieldset, legend, fields, buttons, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldset\\\":{\\\"id\\\":\\\"\\\",\\\"class\\\":[\\\"admin-form\\\"],\\\"group\\\":\\\"formbuilder\\\"},\\\"legend\\\":{\\\"content\\\":\\\"Choisissez le nom du contenu à créer\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"},\\\"fields\\\":[{\\\"label\\\":{\\\"content\\\":\\\"Nom à afficher\\\",\\\"for\\\":\\\"contentDisplayName\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"},\\\"input\\\":{\\\"type\\\":\\\"text\\\",\\\"name\\\":\\\"contentDisplayName\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"value\\\":\\\"\\\",\\\"placeholder\\\":\\\"Nom du contenu à afficher\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"content\\\":\\\"Nom technique\\\",\\\"for\\\":\\\"contentTechnicalName\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"},\\\"input\\\":{\\\"type\\\":\\\"text\\\",\\\"name\\\":\\\"contentTechnicalName\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"value\\\":\\\"\\\",\\\"placeholder\\\":\\\"Nom technique du contenu\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"content\\\":\\\"Contenu\\\",\\\"for\\\":\\\"option_type\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"},\\\"input\\\":{\\\"type\\\":\\\"radio\\\",\\\"name\\\":\\\"option_type\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"value\\\":\\\"content\\\",\\\"checked\\\":\\\"checked\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"content\\\":\\\"Taxonomy\\\",\\\"for\\\":\\\"option_type\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"},\\\"input\\\":{\\\"type\\\":\\\"radio\\\",\\\"name\\\":\\\"option_type\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"value\\\":\\\"taxonomy\\\",\\\"group\\\":\\\"admin-form\\\"}},{\\\"label\\\":{\\\"content\\\":\\\"Settings\\\",\\\"for\\\":\\\"option_type\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"admin-form\\\"},\\\"input\\\":{\\\"type\\\":\\\"radio\\\",\\\"name\\\":\\\"option_type\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"value\\\":\\\"settings\\\",\\\"group\\\":\\\"admin-form\\\"}}],\\\"buttons\\\":[{\\\"button\\\":{\\\"type\\\":\\\"submit\\\",\\\"id\\\":\\\" \\\",\\\"class\\\":[\\\"addNewField\\\"],\\\"content\\\":\\\"Ajouter un nouveau champ\\\",\\\"group\\\":\\\"admin-form\\\",\\\"eventListener\\\":{\\\"type\\\":\\\"click\\\",\\\"callback\\\":\\\"callback_form_addNewField_click_btn\\\"}}},{\\\"button\\\":{\\\"type\\\":\\\"submit\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[\\\"form-btn-submit\\\"],\\\"content\\\":\\\"Valider\\\",\\\"group\\\":\\\"formbuilder\\\"}}]}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/init-builder.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/configurations/new-field.json":
/*!****************************************************************!*\
  !*** ./App/Services/FormBuilder/configurations/new-field.json ***!
  \****************************************************************/
/*! exports provided: fieldset, select, buttons, default */
/***/ (function(module) {

eval("module.exports = JSON.parse(\"{\\\"fieldset\\\":{\\\"id\\\":\\\"\\\",\\\"class\\\":[\\\"form_field_choice\\\"],\\\"group\\\":\\\"admin-form\\\"},\\\"select\\\":[{\\\"label\\\":{\\\"content\\\":\\\"Choisissez un champ\\\",\\\"for\\\":\\\"chooseField\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[],\\\"group\\\":\\\"form_field_choice\\\"},\\\"select\\\":{\\\"name\\\":\\\"chooseField\\\",\\\"id\\\":\\\"chooseField\\\",\\\"class\\\":[],\\\"defaultField\\\":\\\"-- Choisissez un champ --\\\",\\\"option\\\":\\\"fields-list\\\",\\\"group\\\":\\\"form_field_choice\\\"}}],\\\"buttons\\\":[{\\\"a\\\":{\\\"type\\\":\\\"submit\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[\\\"create-field\\\"],\\\"content\\\":\\\"Créer ce champ\\\",\\\"group\\\":\\\"form_field_choice\\\",\\\"eventListener\\\":{\\\"type\\\":\\\"click\\\",\\\"callback\\\":\\\"callback_select_newField_click_btn\\\"}}},{\\\"a\\\":{\\\"type\\\":\\\"reset\\\",\\\"id\\\":\\\"\\\",\\\"class\\\":[\\\"cancel\\\"],\\\"content\\\":\\\"Annuler\\\",\\\"group\\\":\\\"form_field_choice\\\",\\\"eventListener\\\":{\\\"type\\\":\\\"click\\\",\\\"callback\\\":\\\"callback_disabled_addNewField_click_btn\\\"}}}]}\");\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/configurations/new-field.json?");

/***/ }),

/***/ "./App/Services/FormBuilder/js/EventsCallback/ListenersCallback.js":
/*!*************************************************************************!*\
  !*** ./App/Services/FormBuilder/js/EventsCallback/ListenersCallback.js ***!
  \*************************************************************************/
/*! exports provided: ListenersCallback */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"ListenersCallback\", function() { return ListenersCallback; });\n/* harmony import */ var _formBuilderManager__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../formBuilderManager */ \"./App/Services/FormBuilder/js/formBuilderManager.js\");\n\n\n\n/**\n * ListenersCallback\n *\n * @namespace ListenersCallback\n */\n\nvar ListenersCallback = {\n  /* CALLBACKS */\n  callback_form_addNewField_click_btn: function callback_form_addNewField_click_btn(event) {\n    event.preventDefault();\n    _formBuilderManager__WEBPACK_IMPORTED_MODULE_0__[\"FormBuilderManager\"].addNewField(event);\n    event.target.classList.add('disabled');\n    event.target.setAttribute('disabled', '');\n  },\n  callback_disabled_addNewField_click_btn: function callback_disabled_addNewField_click_btn(event) {\n    event.preventDefault();\n    _formBuilderManager__WEBPACK_IMPORTED_MODULE_0__[\"FormBuilderManager\"].deleteChoiceform();\n    var addFieldButton = document.querySelector('.addNewField');\n    addFieldButton.classList.remove('disabled');\n    addFieldButton.removeAttribute('disabled');\n  },\n  callback_select_newField_click_btn: function callback_select_newField_click_btn(event) {\n    event.preventDefault();\n    var selectValue = document.querySelector('#chooseField');\n\n    if (selectValue.value) {\n      _formBuilderManager__WEBPACK_IMPORTED_MODULE_0__[\"FormBuilderManager\"].newFieldSelected(selectValue.value);\n    }\n\n    document.querySelector('.admin-form').removeChild(document.querySelector('.form_field_choice'));\n    var addFieldButton = document.querySelector('.addNewField');\n    addFieldButton.classList.remove('disabled');\n    addFieldButton.removeAttribute('disabled');\n  },\n\n  /**\n   * Delete group field\n   * @param event\n   */\n  deleteGroupButton: function deleteGroupButton(event) {\n    event.preventDefault();\n    var rank = event.target.dataset.count;\n    document.querySelector('.admin-form').removeChild(document.getElementById(\"group-\".concat(rank)));\n  },\n\n  /**\n   * Set checkbox attribute not checked => avoid not existing value after submison form\n   * @param event\n   */\n  callback_isChecked_chkbx: function callback_isChecked_chkbx(event) {\n    var value = event.target.getAttribute('checked') === 'true';\n\n    if (value === true) {\n      event.target.setAttribute('checked', false);\n    } else {\n      event.target.setAttribute('checked', true);\n    }\n  }\n};\n\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/js/EventsCallback/ListenersCallback.js?");

/***/ }),

/***/ "./App/Services/FormBuilder/js/formBuilderManager.js":
/*!***********************************************************!*\
  !*** ./App/Services/FormBuilder/js/formBuilderManager.js ***!
  \***********************************************************/
/*! exports provided: FormBuilderManager */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* WEBPACK VAR INJECTION */(function($) {/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"FormBuilderManager\", function() { return FormBuilderManager; });\n/* harmony import */ var _EventsCallback_ListenersCallback__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EventsCallback/ListenersCallback */ \"./App/Services/FormBuilder/js/EventsCallback/ListenersCallback.js\");\n/* harmony import */ var _Assets_js_tools_tools__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../Assets/js/tools/tools */ \"./App/Assets/js/tools/tools.js\");\n\n\n\n\n/**\n * FormBuilderManager\n *\n * @namespace FormBuilderManager\n */\n\nvar FormBuilderManager = {\n  debug: false,\n\n  /**\n   * Log something in console\n   *\n   * @param {string} context\n   * @param {*} message\n   */\n  log: function log(context, message) {\n    if (this.debug) {\n      console.log(context + ': ' + message);\n    }\n  },\n  selectors: {\n    $formBuilder: document.querySelector('.formbuilder'),\n    $formBuilder__buildNewForm: document.getElementsByClassName('form-init'),\n    $formBuilder__loadConfiguration: document.getElementsByClassName('formbuilder-load'),\n    $formBuilder__updateConfiguration: document.getElementsByClassName('update_form'),\n    $formBuilder__settings: document.getElementsByClassName('settings')\n  },\n  data: {\n    countNewfield: 0\n  },\n  regex: {\n    getClass: 'getConf-*',\n    settings: 'settings-*',\n    defaultValue: '^\\\\-{1,}|\\\\-{1,}$'\n  },\n\n  /**\n   * Initialize formbuilder\n   */\n  init: function init() {\n    this.log('form', 'init');\n    var emptySelectValue = true;\n    var contentType = null;\n\n    if (this.selectors.$formBuilder__buildNewForm.length > 0) {\n      var json = __webpack_require__(/*! ../configurations/init-builder.json */ \"./App/Services/FormBuilder/configurations/init-builder.json\");\n\n      this.fieldsBuilder(json, emptySelectValue);\n    }\n\n    if (this.selectors.$formBuilder__loadConfiguration.length > 0 && this.selectors.$formBuilder__updateConfiguration.length === 0 || this.selectors.$formBuilder__loadConfiguration.length > 0 && this.selectors.$formBuilder__updateConfiguration.length > 0) {\n      contentType = this.getConfigurationFile(this.selectors.$formBuilder__loadConfiguration);\n\n      if (contentType === '') {\n        this.showError();\n      } else {\n        emptySelectValue = !this.selectors.$formBuilder__updateConfiguration.length > 0;\n\n        var _json = __webpack_require__(\"./App/Services/FormBuilder/configurations/custom/temp sync recursive ^\\\\.\\\\/.*\\\\.json$\")(\"./\".concat(contentType, \".json\"));\n\n        this.fieldsBuilder(_json, emptySelectValue);\n      }\n    }\n\n    if (this.selectors.$formBuilder__settings.length > 0) {\n      var regex = RegExp(this.regex.settings);\n      this.selectors.$formBuilder.classList.forEach(function (elt) {\n        if (regex.test(elt)) {\n          contentType = elt;\n        }\n      });\n      emptySelectValue = !this.selectors.$formBuilder__updateConfiguration.length > 0;\n\n      var _json2 = __webpack_require__(\"./App/Services/FormBuilder/configurations sync recursive ^\\\\.\\\\/.*\\\\.json$\")(\"./\".concat(contentType, \".json\"));\n\n      this.fieldsBuilder(_json2, emptySelectValue);\n    }\n  },\n\n  /**\n   * Event on button 'Add new field' and add fields wich help us to add a new custom field in form\n   */\n  addNewField: function addNewField() {\n    var jsonFields = __webpack_require__(/*! ../configurations/new-field.json */ \"./App/Services/FormBuilder/configurations/new-field.json\");\n\n    this.fieldsBuilder(jsonFields);\n  },\n\n  /**\n   * Action when cancel button is clicked\n   */\n  deleteChoiceform: function deleteChoiceform() {\n    var choiceForm = document.querySelector('.form_field_choice');\n    var parent = document.querySelector('.admin-form');\n    parent.removeChild(choiceForm);\n  },\n\n  /**\n   * Sort the field sets in Json configuration file and build the field and add them in DOM.\n   * @param json\n   * @param {boolean } emptySelectValue\n   */\n  fieldsBuilder: function fieldsBuilder(json, emptySelectValue) {\n    var keys = Object.keys(json);\n\n    for (var _i = 0, _keys = keys; _i < _keys.length; _i++) {\n      var field = _keys[_i];\n\n      switch (field) {\n        case 'fieldset':\n        case 'legend':\n          this.setSimpleField(field, json[field], emptySelectValue);\n          break;\n\n        case 'fields':\n        case 'select':\n        case 'entityReference':\n        case 'buttons':\n          this.setArrayField(field, json[field], emptySelectValue);\n          break;\n      }\n    }\n  },\n\n  /**\n   * Build simple field\n   * @param type\n   * @param data\n   * @param {boolean} emptySelectValue\n   */\n  setSimpleField: function setSimpleField(type, data, emptySelectValue) {\n    var inDom = document.createElement(type);\n\n    if (data.id) {\n      inDom.setAttribute('id', data.id);\n    }\n\n    if (data[\"class\"] !== []) {\n      var _iteratorNormalCompletion = true;\n      var _didIteratorError = false;\n      var _iteratorError = undefined;\n\n      try {\n        for (var _iterator = data[\"class\"][Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {\n          var i = _step.value;\n          inDom.classList.add(i);\n        }\n      } catch (err) {\n        _didIteratorError = true;\n        _iteratorError = err;\n      } finally {\n        try {\n          if (!_iteratorNormalCompletion && _iterator[\"return\"] != null) {\n            _iterator[\"return\"]();\n          }\n        } finally {\n          if (_didIteratorError) {\n            throw _iteratorError;\n          }\n        }\n      }\n    }\n\n    if (data.content) {\n      inDom.innerHTML = data.content;\n    }\n\n    if (data.group) {\n      var target = document.getElementsByClassName(data.group);\n      target[0].appendChild(inDom);\n    } else {\n      console.error(\"Error : can't insert element \".concat(type, \" in  DOM\"));\n    }\n  },\n\n  /**\n   * Set field collection (in array)\n   * @param type\n   * @param data\n   * @param {boolean} emptySelectValue\n   */\n  setArrayField: function setArrayField(type, data, emptySelectValue) {\n    var obj;\n    var inDom;\n    var target;\n    var wrap;\n    var previewImage = null;\n    var _iteratorNormalCompletion2 = true;\n    var _didIteratorError2 = false;\n    var _iteratorError2 = undefined;\n\n    try {\n      for (var _iterator2 = data[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {\n        obj = _step2.value;\n        wrap = document.createElement('div');\n        wrap.classList.add('admin-form-field');\n\n        for (var field in obj) {\n          if (obj.hasOwnProperty(field)) {\n            if (field === 'entityReference') {\n              inDom = document.createElement('div');\n            } else {\n              inDom = document.createElement(field);\n            }\n\n            if (obj[field][\"for\"]) {\n              inDom.setAttribute('for', obj[field][\"for\"]);\n            }\n\n            if (obj[field].name) {\n              inDom.setAttribute('name', obj[field].name);\n            }\n\n            if (obj[field].type) {\n              if (obj[field].type !== 'submit') {\n                wrap.classList.add(obj[field].type);\n              }\n\n              if (obj[field].type === 'checkbox' && (obj[field].value === true || obj[field].value === 1)) {\n                inDom.setAttribute('checked', 'true');\n              }\n\n              inDom.setAttribute('type', obj[field].type);\n            }\n\n            if (obj[field].value) {\n              switch (field) {\n                case 'textarea':\n                  inDom.innerHTML = emptySelectValue ? '' : obj[field].value;\n                  break;\n\n                case 'input':\n                  inDom.setAttribute('value', obj[field].value);\n                  break;\n\n                default:\n                  var value = emptySelectValue ? '' : obj[field].value;\n\n                  if (inDom.tagName !== 'DIV') {\n                    inDom.setAttribute('value', value);\n                  }\n\n              }\n            }\n\n            if (obj[field].checked) {\n              inDom.setAttribute('checked', obj[field].checked);\n            }\n\n            if (obj[field].placeholder) {\n              inDom.setAttribute('placeholder', obj[field].placeholder);\n            }\n\n            if (obj[field].content) {\n              inDom.innerHTML = obj[field].content;\n            }\n\n            if (obj[field][\"class\"] && obj[field][\"class\"].length !== 0) {\n              var _iteratorNormalCompletion3 = true;\n              var _didIteratorError3 = false;\n              var _iteratorError3 = undefined;\n\n              try {\n                for (var _iterator3 = obj[field][\"class\"][Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {\n                  var i = _step3.value;\n                  inDom.classList.add(i);\n                }\n              } catch (err) {\n                _didIteratorError3 = true;\n                _iteratorError3 = err;\n              } finally {\n                try {\n                  if (!_iteratorNormalCompletion3 && _iterator3[\"return\"] != null) {\n                    _iterator3[\"return\"]();\n                  }\n                } finally {\n                  if (_didIteratorError3) {\n                    throw _iteratorError3;\n                  }\n                }\n              }\n            }\n\n            if (obj[field].url) {\n              // add preview if url is not true (empty)\n              previewImage = document.createElement('img');\n              previewImage.setAttribute('src', obj[field].url);\n              inDom.innerHTML = obj[field].url;\n            }\n\n            if (obj[field].path) {\n              inDom.innerHTML = obj[field].path;\n            }\n\n            if (obj[field].option) {\n              wrap.classList.add('list');\n\n              switch (field) {\n                case 'select':\n                  this.addSelectOptions(obj, inDom, emptySelectValue);\n                  break;\n\n                case 'entityReference':\n                  this.addMultiSelectOptions(obj, inDom);\n                  break;\n              }\n            }\n\n            if (obj[field].group) {\n              target = document.getElementsByClassName(obj[field].group);\n\n              if (obj[field].type === 'submit') {\n                wrap = inDom;\n              } else {\n                wrap.appendChild(inDom);\n              }\n\n              if (previewImage !== null) {\n                target[0].appendChild(previewImage);\n              }\n            } else {\n              console.error(\"Error : can't insert element \".concat(field, \" in  DOM\"));\n            }\n\n            if (field === 'label' && obj[field].labelDisplay) {\n              inDom.innerHTML = obj[field].labelDisplay;\n            }\n\n            if (obj[field].eventListener) {\n              this.addElementListener(obj[field].eventListener, inDom);\n            }\n          }\n        }\n\n        target[0].appendChild(wrap);\n      }\n    } catch (err) {\n      _didIteratorError2 = true;\n      _iteratorError2 = err;\n    } finally {\n      try {\n        if (!_iteratorNormalCompletion2 && _iterator2[\"return\"] != null) {\n          _iterator2[\"return\"]();\n        }\n      } finally {\n        if (_didIteratorError2) {\n          throw _iteratorError2;\n        }\n      }\n    }\n  },\n\n  /**\n   * Build dynamically the field selector wich help to add field in form.\n   * @param parent\n   * @param inDom\n   */\n  addSelectOptions: function addSelectOptions(parent, inDom) {\n    for (var child in parent) {\n      if (parent.hasOwnProperty(child)) {\n        if (parent[child].id) {\n          inDom.setAttribute('id', parent[child].id);\n        }\n\n        if (parent[child].name) {\n          inDom.setAttribute('name', parent[child].name);\n        }\n\n        if (parent[child].defaultField) {\n          var defaultField = document.createElement('option');\n          defaultField.setAttribute('value', parent[child].value);\n          defaultField.setAttribute('selected', 'selected');\n          defaultField.innerHTML = parent[child].defaultField;\n          inDom.appendChild(defaultField);\n        }\n\n        if (parent[child].value) {\n          inDom.setAttribute('value', parent[child].value);\n        }\n\n        if (parent[child][\"class\"] !== []) {\n          var _iteratorNormalCompletion4 = true;\n          var _didIteratorError4 = false;\n          var _iteratorError4 = undefined;\n\n          try {\n            for (var _iterator4 = parent[child][\"class\"][Symbol.iterator](), _step4; !(_iteratorNormalCompletion4 = (_step4 = _iterator4.next()).done); _iteratorNormalCompletion4 = true) {\n              var i = _step4.value;\n              inDom.classList.add(i);\n            }\n          } catch (err) {\n            _didIteratorError4 = true;\n            _iteratorError4 = err;\n          } finally {\n            try {\n              if (!_iteratorNormalCompletion4 && _iterator4[\"return\"] != null) {\n                _iterator4[\"return\"]();\n              }\n            } finally {\n              if (_didIteratorError4) {\n                throw _iteratorError4;\n              }\n            }\n          }\n        }\n\n        if (parent[child].checked) {\n          inDom.setAttribute('checked', parent[child].checked);\n        }\n\n        if (parent[child].option) {\n          var json = void 0; // select init form\n\n          if (parent[child].option === 'fields-list') {\n            // From configuration file init form\n            var path = parent[child].option;\n            json = __webpack_require__(\"./App/Services/FormBuilder/configurations sync recursive ^\\\\.\\\\/.*\\\\.json$\")(\"./\".concat(path, \".json\"));\n\n            for (var item in json) {\n              if (json.hasOwnProperty(item)) {\n                var option = document.createElement('option');\n                option.setAttribute('value', item);\n                option.innerHTML = item;\n                inDom.appendChild(option);\n              }\n            }\n          } // from config file when we create a content type or update\n          else if (Array.isArray(parent[child].option)) {\n              // From select form\n              var _iteratorNormalCompletion5 = true;\n              var _didIteratorError5 = false;\n              var _iteratorError5 = undefined;\n\n              try {\n                for (var _iterator5 = parent[child].option[0][Symbol.iterator](), _step5; !(_iteratorNormalCompletion5 = (_step5 = _iterator5.next()).done); _iteratorNormalCompletion5 = true) {\n                  var _item = _step5.value;\n\n                  var _option = document.createElement('option');\n\n                  if (parent[child].value === _item.id) {\n                    _option.setAttribute('selected', 'selected');\n                  }\n\n                  _option.setAttribute('name', _item.name);\n\n                  _option.setAttribute('value', _item.id);\n\n                  _option.innerHTML = _item.name;\n                  inDom.appendChild(_option);\n                }\n              } catch (err) {\n                _didIteratorError5 = true;\n                _iteratorError5 = err;\n              } finally {\n                try {\n                  if (!_iteratorNormalCompletion5 && _iterator5[\"return\"] != null) {\n                    _iterator5[\"return\"]();\n                  }\n                } finally {\n                  if (_didIteratorError5) {\n                    throw _iteratorError5;\n                  }\n                }\n              }\n            }\n        }\n\n        if (parent[child].group) {\n          var target = document.getElementsByClassName(parent[child].group);\n          target[0].appendChild(inDom);\n        } else {\n          console.error(\"Error : can't insert element \".concat(parent, \" in  DOM\"));\n        }\n      }\n    }\n  },\n\n  /**\n   * Build dynamically the field selector which help to add field in form.\n   * @param parent\n   * @param inDom\n   */\n  addMultiSelectOptions: function addMultiSelectOptions(parent, inDom) {\n    var options = parent.entityReference.option[0];\n    var fieldName = parent.entityReference.name; //Remove default value\n\n    var _iteratorNormalCompletion6 = true;\n    var _didIteratorError6 = false;\n    var _iteratorError6 = undefined;\n\n    try {\n      for (var _iterator6 = options[Symbol.iterator](), _step6; !(_iteratorNormalCompletion6 = (_step6 = _iterator6.next()).done); _iteratorNormalCompletion6 = true) {\n        var child = _step6.value;\n        var regex = RegExp(this.regex.defaultValue);\n\n        if (regex.test(child.name)) {\n          var index = options.indexOf(child);\n          options.splice(index, 1);\n        }\n      }\n    } catch (err) {\n      _didIteratorError6 = true;\n      _iteratorError6 = err;\n    } finally {\n      try {\n        if (!_iteratorNormalCompletion6 && _iterator6[\"return\"] != null) {\n          _iterator6[\"return\"]();\n        }\n      } finally {\n        if (_didIteratorError6) {\n          throw _iteratorError6;\n        }\n      }\n    }\n\n    var _iteratorNormalCompletion7 = true;\n    var _didIteratorError7 = false;\n    var _iteratorError7 = undefined;\n\n    try {\n      for (var _iterator7 = options[Symbol.iterator](), _step7; !(_iteratorNormalCompletion7 = (_step7 = _iterator7.next()).done); _iteratorNormalCompletion7 = true) {\n        var _child = _step7.value;\n        var fieldWrapper = document.createElement('div');\n        fieldWrapper.classList.add('entityRef__wrap');\n        var inDomChildLabel = document.createElement('label');\n        inDomChildLabel.setAttribute('for', _child.name);\n        inDomChildLabel.innerHTML = _child.name;\n        var inDomChildInput = document.createElement('input');\n        inDomChildInput.setAttribute('type', 'checkbox');\n        inDomChildInput.setAttribute('name', _child.name);\n\n        if (_child.id) {\n          inDomChildInput.setAttribute('value', _child.id);\n        }\n\n        if (_child.name) {\n          inDomChildInput.setAttribute('name', \"\".concat(fieldName, \"[]\"));\n        }\n\n        if (_child.checked) {\n          inDomChildInput.setAttribute('checked', _child.checked);\n        }\n\n        fieldWrapper.appendChild(inDomChildLabel);\n        fieldWrapper.appendChild(inDomChildInput);\n        inDom.appendChild(fieldWrapper);\n      }\n    } catch (err) {\n      _didIteratorError7 = true;\n      _iteratorError7 = err;\n    } finally {\n      try {\n        if (!_iteratorNormalCompletion7 && _iterator7[\"return\"] != null) {\n          _iterator7[\"return\"]();\n        }\n      } finally {\n        if (_didIteratorError7) {\n          throw _iteratorError7;\n        }\n      }\n    }\n\n    inDom = this.addDefaultCheckboxValue(inDom, parent);\n  },\n\n  /**\n   * Add default value foir multiselect fields\n   * Needed for submitted fields elseif empty\n   * @param inDom\n   * @param parent\n   * @returns {*}\n   */\n  addDefaultCheckboxValue: function addDefaultCheckboxValue(inDom, parent) {\n    var checkboxType = parent.label[\"for\"];\n    var hiddenField = document.createElement('input');\n    hiddenField.setAttribute('type', 'hidden');\n    hiddenField.setAttribute('name', \"\".concat(checkboxType, \"[]\"));\n    hiddenField.setAttribute('value', \"\");\n    hiddenField.setAttribute('checked', \"true\");\n    inDom.appendChild(hiddenField);\n    return inDom;\n  },\n\n  /**\n   * Get new fields selected in little form and render all the field needed for building a new field\n   * Insert collection if field in DOM\n   */\n  newFieldSelected: function newFieldSelected(field) {\n    var json = __webpack_require__(\"./App/Services/FormBuilder/configurations/fieldsConfigurations sync recursive ^\\\\.\\\\/.*\\\\.json$\")(\"./\".concat(field, \".json\"));\n\n    var toDom = [];\n    var rank = this.counter();\n\n    for (var item in json) {\n      if (json.hasOwnProperty(item)) {\n        this.buildField(item, json, toDom, rank);\n      }\n    }\n\n    var parent = this.newFieldGroupContainer(field, rank);\n    toDom.forEach(function (elt) {\n      parent.appendChild(elt);\n    });\n    this.addDeleteGroupButton(parent, rank);\n    document.getElementsByClassName(json.group)[0].appendChild(parent);\n  },\n\n  /**\n   * Build group of necessary fields for build a new field in add content form\n   * @param type\n   * @param datas\n   * @param toDom\n   * @param rank\n   * @returns {number | * | boolean}\n   */\n  buildField: function buildField(type, datas, toDom, rank) {\n    var wrapper = this.fieldWrapper();\n    var newInput;\n    var newLabel;\n\n    switch (type) {\n      case 'labelDisplay':\n      case 'type':\n      case 'name':\n      case 'for':\n      case 'id':\n      case 'class':\n      case 'value':\n      case 'placeholder':\n      case 'fileUrl':\n      case 'filePath':\n        newLabel = document.createElement('label');\n        newLabel.setAttribute('for', \"\".concat(type, \"_\").concat(rank));\n        newLabel.innerHTML = _Assets_js_tools_tools__WEBPACK_IMPORTED_MODULE_1__[\"Tools\"].camelCaseToString(type);\n        newInput = document.createElement('input');\n        newInput.setAttribute('name', \"\".concat(type, \"_\").concat(rank));\n\n        if (type === 'type') {\n          newInput.setAttribute('value', this.getInputType(datas));\n        }\n\n        newInput.setAttribute('placeholder', _Assets_js_tools_tools__WEBPACK_IMPORTED_MODULE_1__[\"Tools\"].camelCaseToString(type));\n        wrapper.appendChild(newLabel);\n        wrapper.appendChild(newInput);\n        break;\n\n      case 'labelRef':\n        newLabel = document.createElement('label');\n        newLabel.setAttribute('for', \"\".concat(type, \"_\").concat(rank));\n        newLabel.innerHTML = _Assets_js_tools_tools__WEBPACK_IMPORTED_MODULE_1__[\"Tools\"].camelCaseToString('Entité référence');\n        newInput = document.createElement('select');\n        newInput.setAttribute('name', \"\".concat(type, \"_\").concat(rank)); // Default field\n\n        var defaultField = document.createElement('option');\n        defaultField.setAttribute('value', '');\n        defaultField.innerHTML = datas.defaultField;\n        newInput.appendChild(defaultField);\n\n        var jsonOptions = __webpack_require__(/*! ../configurations/custom/taxonomy/taxonomy_list.json */ \"./App/Services/FormBuilder/configurations/custom/taxonomy/taxonomy_list.json\");\n\n        var option;\n\n        for (var elt in jsonOptions) {\n          option = document.createElement('option');\n          option.setAttribute('value', \"\".concat(elt, \"_\").concat(jsonOptions[elt]));\n          option.innerHTML = _Assets_js_tools_tools__WEBPACK_IMPORTED_MODULE_1__[\"Tools\"].ucFirst(jsonOptions[elt]);\n          newInput.appendChild(option);\n        }\n\n        wrapper.appendChild(newLabel);\n        wrapper.appendChild(newInput);\n        break;\n\n      case 'idRef':\n        newInput = document.createElement('input');\n        newInput.setAttribute('name', \"\".concat(type, \"_\").concat(rank));\n        newInput.setAttribute('type', 'hidden');\n        wrapper.appendChild(newInput);\n        break;\n\n      case 'fieldType':\n      case 'group':\n        newInput = document.createElement('input');\n        newInput.setAttribute('name', \"\".concat(type, \"_\").concat(rank));\n        newInput.setAttribute('value', \"\".concat(datas[type]));\n        newInput.setAttribute('type', 'hidden');\n        wrapper.appendChild(newInput);\n        break;\n    }\n\n    return toDom.push(wrapper);\n  },\n\n  /**\n   * Build new field wrapper\n   * @param wrapClass\n   * @returns {HTMLDivElement}\n   */\n  fieldWrapper: function fieldWrapper(wrapClass) {\n    var wrapper;\n\n    if (_Assets_js_tools_tools__WEBPACK_IMPORTED_MODULE_1__[\"Tools\"].empty(wrapClass)) {\n      wrapper = document.createElement('div');\n      wrapper.classList.add('wrap_newField');\n    } else {\n      wrapper = document.createElement('div');\n      wrapper.classList.add(wrapClass);\n    }\n\n    return wrapper;\n  },\n\n  /**\n   * Add fieldset an legend for each new field group\n   * @param fieldType\n   * @returns {HTMLFieldSetElement}\n   */\n  newFieldGroupContainer: function newFieldGroupContainer(fieldType, rank) {\n    var group = document.createElement('fieldset');\n    var legend = document.createElement('legend');\n    group.setAttribute('id', \"group-\".concat(rank));\n    group.classList.add('new-field-group');\n    legend.innerHTML = \"Nouveau champ type \".concat(fieldType, \" \").concat(rank);\n    group.appendChild(legend);\n    return group;\n  },\n\n  /**\n   * Add button in group which help to delete any group\n   * @param parent\n   * @param count\n   */\n  addDeleteGroupButton: function addDeleteGroupButton(parent, count) {\n    var btnDelete = document.createElement('button');\n    btnDelete.classList.add('btn_delete');\n    btnDelete.setAttribute('data-count', count);\n    btnDelete.innerHTML = 'Supprimer ce group';\n    parent.appendChild(btnDelete);\n    btnDelete.addEventListener('click', _EventsCallback_ListenersCallback__WEBPACK_IMPORTED_MODULE_0__[\"ListenersCallback\"].deleteGroupButton);\n  },\n\n  /**\n   * Count each new field\n   *\n   * @returns {number}\n   */\n  counter: function counter() {\n    var groupNumber = document.getElementsByClassName('new-field-group').length;\n\n    if (groupNumber === 0) {\n      this.data.countNewfield = 0;\n    }\n\n    return parseInt(++this.data.countNewfield);\n  },\n\n  /**\n   * Add event on button dynamically\n   * @param elt\n   * @param inDom\n   */\n  addElementListener: function addElementListener(elt, inDom) {\n    if (typeof _EventsCallback_ListenersCallback__WEBPACK_IMPORTED_MODULE_0__[\"ListenersCallback\"][elt.callback] === \"function\") {\n      var callback = _EventsCallback_ListenersCallback__WEBPACK_IMPORTED_MODULE_0__[\"ListenersCallback\"][elt.callback];\n      inDom.addEventListener(elt.type, callback);\n    }\n  },\n  addListListener: function addListListener(elt, inDom) {\n    if (typeof _EventsCallback_ListenersCallback__WEBPACK_IMPORTED_MODULE_0__[\"ListenersCallback\"][elt.callback] === \"function\") {\n      inDom.forEach(function (item) {\n        var callback = _EventsCallback_ListenersCallback__WEBPACK_IMPORTED_MODULE_0__[\"ListenersCallback\"][elt.callback];\n        item.addEventListener(elt.type, callback);\n      });\n    }\n  },\n\n  /**\n   * Get content type from css class\n   * @param form\n   * @returns {string}\n   */\n  getConfigurationFile: function getConfigurationFile(form) {\n    var contentType = '';\n    var regex = RegExp(this.regex.getClass);\n    form[0].classList.forEach(function (elt) {\n      if (regex.test(elt)) {\n        var chunks = elt.split('-');\n        contentType = chunks[1];\n      }\n    });\n    return contentType;\n  },\n\n  /**\n   * @TODO fonction à écrire dans le cas où il n'y a pas de contenu\n   * afficher l'erreur dans le DOM => flash message\n   */\n  showError: function showError() {},\n\n  /**\n   * Return input type\n   * @param datas {Object}\n   * @returns {string}\n   */\n  getInputType: function getInputType(datas) {\n    return datas.fieldType === 'input' ? datas.type : '';\n  }\n};\n/* Class could be import from any other file like this :\n  import {FormBuilderManager} from \"../formBuilderManager\";\n*/\n\n\n/**\n * Run init function of app\n * when the document is ready\n */\n\n$(document).ready(function () {\n  FormBuilderManager.init(); // Checkbox field\n\n  var checkbox_target = document.querySelectorAll('.update_form input[type=\"checkbox\"]'); // improve EVENT here\n\n  if (checkbox_target) {\n    FormBuilderManager.addListListener({\n      callback: 'callback_isChecked_chkbx',\n      type: 'click'\n    }, checkbox_target);\n  }\n});\n/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ \"./node_modules/jquery/dist/jquery.js\")))\n\n//# sourceURL=webpack:///./App/Services/FormBuilder/js/formBuilderManager.js?");

/***/ }),

/***/ "./node_modules/jquery/dist/jquery.js":
/*!********************************************!*\
  !*** ./node_modules/jquery/dist/jquery.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("throw new Error(\"Module build failed: Error: ENOENT: no such file or directory, open '/Users/gge/www/portfolio-3Wacademy/node_modules/jquery/dist/jquery.js'\");\n\n//# sourceURL=webpack:///./node_modules/jquery/dist/jquery.js?");

/***/ })

/******/ });