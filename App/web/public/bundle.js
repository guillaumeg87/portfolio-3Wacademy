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

eval("__webpack_require__(/*! ../scss/main.scss */ \"./App/Assets/scss/main.scss\");\n\nconsole.log('Webpack first step');\n\n//# sourceURL=webpack:///./App/Assets/js/index.js?");

/***/ }),

/***/ "./App/Assets/scss/main.scss":
/*!***********************************!*\
  !*** ./App/Assets/scss/main.scss ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("throw new Error(\"Module build failed (from ./node_modules/mini-css-extract-plugin/dist/loader.js):\\nModuleBuildError: Module build failed (from ./node_modules/sass-loader/lib/loader.js):\\nError: Missing binding /Users/gge/www/portfolio-3Wacademy/node_modules/node-sass/vendor/darwin-x64-72/binding.node\\nNode Sass could not find a binding for your current environment: OS X 64-bit with Node.js 12.x\\n\\nFound bindings for the following environments:\\n  - Linux 64-bit with Node.js 10.x\\n\\nThis usually happens because your environment has changed since running `npm install`.\\nRun `npm rebuild node-sass` to download the binding for your current environment.\\n    at module.exports (/Users/gge/www/portfolio-3Wacademy/node_modules/node-sass/lib/binding.js:15:13)\\n    at Object.<anonymous> (/Users/gge/www/portfolio-3Wacademy/node_modules/node-sass/lib/index.js:14:35)\\n    at Module._compile (/Users/gge/www/portfolio-3Wacademy/node_modules/v8-compile-cache/v8-compile-cache.js:192:30)\\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:788:10)\\n    at Module.load (internal/modules/cjs/loader.js:643:32)\\n    at Function.Module._load (internal/modules/cjs/loader.js:556:12)\\n    at Module.require (internal/modules/cjs/loader.js:683:19)\\n    at require (/Users/gge/www/portfolio-3Wacademy/node_modules/v8-compile-cache/v8-compile-cache.js:161:20)\\n    at Object.sassLoader (/Users/gge/www/portfolio-3Wacademy/node_modules/sass-loader/lib/loader.js:46:72)\\n    at /Users/gge/www/portfolio-3Wacademy/node_modules/webpack/lib/NormalModule.js:313:20\\n    at /Users/gge/www/portfolio-3Wacademy/node_modules/loader-runner/lib/LoaderRunner.js:367:11\\n    at /Users/gge/www/portfolio-3Wacademy/node_modules/loader-runner/lib/LoaderRunner.js:233:18\\n    at runSyncOrAsync (/Users/gge/www/portfolio-3Wacademy/node_modules/loader-runner/lib/LoaderRunner.js:143:3)\\n    at iterateNormalLoaders (/Users/gge/www/portfolio-3Wacademy/node_modules/loader-runner/lib/LoaderRunner.js:232:2)\\n    at iterateNormalLoaders (/Users/gge/www/portfolio-3Wacademy/node_modules/loader-runner/lib/LoaderRunner.js:221:10)\\n    at /Users/gge/www/portfolio-3Wacademy/node_modules/loader-runner/lib/LoaderRunner.js:236:3\\n    at context.callback (/Users/gge/www/portfolio-3Wacademy/node_modules/loader-runner/lib/LoaderRunner.js:111:13)\\n    at /Users/gge/www/portfolio-3Wacademy/node_modules/postcss-loader/src/index.js:197:9\");\n\n//# sourceURL=webpack:///./App/Assets/scss/main.scss?");

/***/ })

/******/ });