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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ 6:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(7);


/***/ }),

/***/ 7:
/***/ (function(module, exports) {

(function () {

    var ticker_symbol = void 0;

    if ($('#bracketorder_symbol').val()) {
        ticker_symbol = $('#bracketorder_symbol').val();
    } else {
        ticker_symbol = "gspc.indx";
    }

    var stock_code = ticker_symbol.split('.');
    var autoload = ticker_symbol.split(' - ');

    if (stock_code[1] === "indx" || stock_code[1] === "us") {
        series_name = stock_code[0];
    } else if ("1" in autoload) {

        series_name = autoload[0];
        ticker_symbol = autoload[0];
    } else {
        series_name = ticker_symbol;
    }

    Highcharts.wrap(Highcharts.RangeSelector.prototype, 'drawInput', function (proceed, name) {
        proceed.call(this, name);
        this[name + 'DateBox'].on('click', function () {
            rangeSelector.showInput(name);
            rangeSelector[name + 'Input'].focus();
        });
    });

    $.ajax({
        url: 'https://bracketorder.com/bracketorder-api/api/charts?ticker_symbol=' + ticker_symbol.trim(),
        contentType: 'application/json; charset=utf-8',
        type: "GET",
        success: function success(data) {
            Highcharts.setOptions({
                lang: {
                    decimalPoint: '.',
                    thousandsSep: ','
                },
                time: {
                    timezoneOffset: 4 * 60
                }
            });

            // split the data set into ohlc and volume
            var ohlc = [],
                sma21 = [],
                sma63 = [],
                sma200 = [],
                bb = [],
                currentPriceLine = [],
                dataLength = data.length,
                i = 0;

            for (i; i < dataLength; i += 1) {
                ohlc.push([data[i][0], // the date
                data[i][1], // open
                data[i][2], // high
                data[i][3], // low
                data[i][4] // close
                ]);

                sma21.push([data[i][0], // the date
                data[i][1], // open
                data[i][2], // high
                data[i][3], // low
                data[i][4] // close
                ]);

                sma63.push([data[i][0], // the date
                data[i][1], // open
                data[i][2], // high
                data[i][3], // low
                data[i][4] // close
                ]);

                sma200.push([data[i][0], // the date
                data[i][1], // open
                data[i][2], // high
                data[i][3], // low
                data[i][4] // close
                ]);

                currentPriceLine.push([data[i][4] // close
                ]);
            }

            var removeLast = currentPriceLine.pop();
            var changeDirection = removeLast[0] - currentPriceLine[currentPriceLine.length - 1][0];

            Highcharts.stockChart('chart', {
                chart: {
                    alignTicks: false,
                    marginTop: 0,
                    marginRight: 5,
                    marginLeft: 5,
                    backgroundColor: '#ffffff'
                },

                rangeSelector: {
                    inputEnabled: false,
                    inputTheme: { // styles for the buttons
                        style: {
                            color: '#000000',
                            fontWeight: 300,
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    selected: 1,
                    buttonTheme: { // styles for the buttons
                        width: 50,
                        height: 15,
                        padding: 5
                    },
                    x: -42
                },

                navigator: {
                    enabled: true
                },

                xAxis: [{
                    crosshair: true,
                    lineWidth: 3,
                    offset: 60,
                    lineColor: '#212121',
                    labels: {
                        style: {
                            color: '#000000',
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    allowOverlapX: false,
                    gridLineWidth: 1,
                    gridLineColor: 'rgba(160, 160, 160, 0.2)',
                    type: 'datetime',
                    tickInterval: 5,
                    endOnTick: true,
                    showLastLabel: true,
                    startOnTick: true
                }],

                yAxis: [{
                    crosshair: true,
                    height: 585,
                    lineWidth: 3,
                    lineColor: '#212121',
                    resize: {
                        enabled: true
                    },
                    gridLineColor: 'rgba(160, 160, 160, 0.2)',
                    labels: {
                        x: -10,
                        y: -5,
                        style: {
                            color: '#000000',
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    plotBands: {
                        from: ohlc[ohlc.length - 1][4],
                        to: ohlc[ohlc.length - 1][4],
                        width: 1,
                        color: changeDirection > 0 ? '#ef9a9a' : '#c8e6c9',
                        label: {
                            x: 0,
                            y: -10,
                            style: {
                                color: '#000000',
                                fontFamily: 'sans-serif',
                                fontSize: 12
                            }
                        }
                    }
                }],

                plotOptions: {
                    series: {
                        showInLegend: true,
                        turboThreshold: 1000000000,
                        marker: {
                            enabled: false
                        },
                        events: {
                            legendItemClick: function legendItemClick() {
                                return false;
                            }
                        },
                        dataGrouping: {
                            enabled: true,
                            forced: true,
                            units: [['day', [1]], ['week', [1]], ['month', [1, 3, 6]]]
                        }
                    },
                    candlestick: {
                        color: '#c8e6c9',
                        lineColor: '#43a047',
                        upLineColor: '#b71c1c',
                        upColor: '#ef9a9a',
                        showInNavigator: true
                    }
                },

                series: [{
                    id: ticker_symbol.trim(),
                    type: 'candlestick',
                    name: series_name.toUpperCase(),
                    data: ohlc
                }, {
                    type: 'bb',
                    name: 'Bollinger Bands',
                    data: bb,
                    params: {
                        index: 3,
                        period: 20,
                        standardDeviation: 1.9495
                    },
                    turboThreshold: 100000,
                    linkedTo: ticker_symbol.trim(),
                    topLine: {
                        styles: {
                            lineWidth: 2,
                            lineColor: '#616161'
                        }
                    },
                    bottomLine: {
                        styles: {
                            lineWidth: 2,
                            lineColor: '#616161'
                        }
                    },
                    lineWidth: 2,
                    color: '#616161'
                }],

                credits: {
                    enabled: false
                },
                tooltip: {
                    enabledIndicators: true,
                    valueDecimals: 2,
                    xDateFormat: '%B %d, %Y %l:%M %p',
                    shared: true
                },

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 1280,
                            minWidth: 1025
                        },
                        chartOptions: {
                            legend: {
                                itemDistance: 150
                            }
                        }
                    }, {
                        condition: {
                            maxWidth: 768,
                            minWidth: 768
                        },
                        chartOptions: {
                            xAxis: [{
                                offset: -15
                            }]
                        }
                    }, {
                        condition: {
                            maxWidth: 667,
                            minWidth: 320
                        },
                        chartOptions: {
                            rangeSelector: {
                                inputEnabled: false,
                                inputTheme: { // styles for the buttons
                                    style: {
                                        color: '#000000',
                                        fontWeight: 300,
                                        fontFamily: 'sans-serif',
                                        textShadow: false
                                    }
                                },
                                selected: 1,
                                buttonTheme: { // styles for the buttons
                                    width: 20,
                                    height: 15,
                                    padding: 10
                                },
                                x: -36
                            },
                            yAxis: {
                                lineWidth: 0,
                                labels: {
                                    x: 0
                                }
                            },
                            chart: {
                                alignTicks: false,
                                marginTop: 0,
                                marginRight: 0,
                                marginLeft: 0,
                                backgroundColor: '#ffffff'
                            }
                        }
                    }]
                },

                exporting: {
                    enabled: false
                }
            }, function (chart) {
                $('.highcharts-range-selector-buttons text:first').css('display', 'none');

                if ($(window).width() <= 667) {
                    if ($("#bracketorder_symbol").val() === "") {
                        chart.renderer.text(ticker_symbol.toUpperCase(), 5, 60).attr({
                            rotation: 0
                        }).css({
                            color: '#000000',
                            fontSize: '12px'
                        }).add();
                    } else {
                        chart.renderer.text($("#bracketorder_symbol").val(), 5, 60).attr({
                            rotation: 0
                        }).css({
                            color: '#000000',
                            fontSize: '12px'
                        }).add();
                    }
                } else {
                    if ($("#bracketorder_symbol").val() === "") {
                        chart.renderer.text(ticker_symbol.toUpperCase(), 5, 55).attr({
                            rotation: 0
                        }).css({
                            color: '#000000',
                            fontSize: '12px'
                        }).add();
                    } else {
                        chart.renderer.text($("#bracketorder_symbol").val(), 5, 55).attr({
                            rotation: 0
                        }).css({
                            color: '#000000',
                            fontSize: '12px'
                        }).add();
                    }
                }

                $.ajax({
                    url: '/account/get-indicator',
                    type: "GET",
                    success: function success(data) {
                        $data = $(data);

                        if (data['smas'] != null) {
                            if (data['smas']['sma_number_1'] === "sma-1") {
                                chart.addSeries({
                                    type: 'sma',
                                    linkedTo: ticker_symbol.trim(),
                                    data: sma21,
                                    params: {
                                        index: 3,
                                        period: data['smas']['periods_1']
                                    },
                                    color: data['smas']['color_1'],
                                    showInNavigator: false
                                });
                                $(this).attr('disabled', true);
                            }

                            if (data['smas']['sma_number_2'] === "sma-2") {
                                chart.addSeries({
                                    type: 'sma',
                                    linkedTo: ticker_symbol.trim(),
                                    data: sma63,
                                    params: {
                                        index: 3,
                                        period: data['smas']['periods_2']
                                    },
                                    color: data['smas']['color_2'],
                                    showInNavigator: false
                                });
                                $(this).attr('disabled', true);
                            }

                            if (data['smas']['sma_number_3'] === "sma-3") {
                                chart.addSeries({
                                    type: 'sma',
                                    linkedTo: ticker_symbol.trim(),
                                    data: sma200,
                                    params: {
                                        index: 3,
                                        period: data['smas']['periods_3']
                                    },
                                    color: data['smas']['color_3'],
                                    showInNavigator: false
                                });
                                $(this).attr('disabled', true);
                            }
                        }
                    }
                });
            });
        }
    });
})();

/***/ })

/******/ });