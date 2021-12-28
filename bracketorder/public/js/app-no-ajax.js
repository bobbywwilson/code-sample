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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 34);
/******/ })
/************************************************************************/
/******/ ({

/***/ 34:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(35);


/***/ }),

/***/ 35:
/***/ (function(module, exports) {


$(document).ready(function () {
    $('.sidenav').sidenav({
        draggable: false,
        preventScrolling: true
    });
});

$(document).ready(function () {
    $('.collapsible').collapsible();
});

$(document).ready(function () {
    $('.market-data').click(function () {
        console.log('show');
        if ($('#market-data-open').hasClass('active')) {
            $('.market-data-chevron-up').addClass('hide');
            $('.market-data-chevron-down').removeClass('hide');
        }

        if ($('#market-data-open').hasClass('')) {
            $('.market-data-chevron-up').removeClass('hide');
            $('.market-data-chevron-down').addClass('hide');
        }
    });

    $('.news-sections').click(function () {
        console.log('show');
        if ($('#news-sections-open').hasClass('active')) {
            $('.news-sections-chevron-up').addClass('hide');
            $('.news-sections-chevron-down').removeClass('hide');
        }

        if ($('#news-sections-open').hasClass('')) {
            $('.news-sections-chevron-up').removeClass('hide');
            $('.news-sections-chevron-down').addClass('hide');
        }
    });
});

$(document).ready(function () {
    $('.fa-bars').click(function () {
        console.log('sidenav open');
        $('.fa-bars').addClass('hide');
        $('.fa-times').removeClass('hide');
    });

    $('#slide-out').click(function () {
        console.log('has focus');
        $('.fa-bars').addClass('hide');
        $('.fa-times').removeClass('hide');
    });

    $('.fa-times').click(function () {
        console.log('fa-times clicked');
        $('.fa-bars').removeClass('hide');
        $('.fa-times').addClass('hide');
    });
});

$(document).mouseup(function (e) {
    var lose_focus = $("#slide-out");

    if (!lose_focus.is(e.target) && lose_focus.has(e.target).length === 0) {
        $('.fa-bars').removeClass('hide');
        $('.fa-times').addClass('hide');
    }
});

$(document).ready(function () {
    $('#business-news-table').DataTable({
        "pageLength": 3,
        "searching": false,
        "columnDefs": [{
            "targets": [0],
            "orderData": [0]
        }],
        "order": [[0, "dsc"]]
    });

    $('#technology-news-table').DataTable({
        "pageLength": 3,
        "searching": false,
        "columnDefs": [{
            "targets": [0],
            "orderData": [0]
        }],
        "order": [[0, "dsc"]]
    });

    $('#top-news-table').DataTable({
        "pageLength": 3,
        "searching": false,
        "columnDefs": [{
            "targets": [0],
            "orderData": [0]
        }],
        "order": [[0, "dsc"]]
    });

    $('#us-news-table').DataTable({
        "pageLength": 3,
        "searching": false,
        "columnDefs": [{
            "targets": [0],
            "orderData": [0]
        }],
        "order": [[3, "dsc"]]
    });

    $('#world-news-table').DataTable({
        "pageLength": 3,
        "searching": false,
        "columnDefs": [{
            "targets": [0],
            "orderData": [0]
        }],
        "order": [[0, "dsc"]]
    });
});

/***/ })

/******/ });