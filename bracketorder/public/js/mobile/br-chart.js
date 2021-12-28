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
/******/ 	return __webpack_require__(__webpack_require__.s = 22);
/******/ })
/************************************************************************/
/******/ ({

/***/ 22:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(23);


/***/ }),

/***/ 23:
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

    (function (H) {
        var isArray = H.isArray,
            SMA = H.seriesTypes.sma,
            reduce = H.reduce,
            getArrayExtremes = function getArrayExtremes(arr, minIndex, maxIndex) {
            return reduce(arr, function (prev, target) {
                return [Math.min(prev[0], target[minIndex]), Math.max(prev[1], target[maxIndex])];
            }, [Number.MAX_VALUE, -Number.MAX_VALUE]);
        };
        H.seriesTypes.stochastic.prototype.getValues = function (series, params) {
            var periodK = params.periods[0],
                periodD = params.periods[1],
                xVal = series.xData,
                yVal = series.yData,
                yValLen = yVal ? yVal.length : 0,
                SO = [],
                // 0- date, 1-%K, 2-%D
            xData = [],
                yData = [],
                slicedY = void 0,
                close = 3,
                low = 2,
                high = 1,
                CL = void 0,
                HL = void 0,
                LL = void 0,
                K = void 0,
                D = null,
                points = void 0,
                extremes = void 0,
                i = void 0;

            // Stochastic requires close value
            if (yValLen < periodK || !isArray(yVal[0]) || yVal[0].length !== 4) {
                return false;
            }

            // For a N-period, we start from N-1 point, to calculate Nth point
            // That is why we later need to comprehend slice() elements list
            // with (+1)
            for (i = periodK - 1; i < yValLen; i++) {
                slicedY = yVal.slice(i - periodK + 1, i + 1);

                // Calculate %K
                extremes = getArrayExtremes(slicedY, low, high);
                LL = extremes[0]; // Lowest low in %K periods
                CL = yVal[i][close] - LL;
                HL = extremes[1] - LL;
                K = CL / HL * 100;

                xData.push(xVal[i]);
                yData.push([K, null]);

                // Calculate smoothed %D, which is SMA of %K
                if (i >= periodK - 1 + (periodD - 1)) {
                    points = SMA.prototype.getValues.call(this, {
                        xData: xData.slice(-periodD),
                        yData: yData.slice(-periodD)
                    }, {
                        period: periodD
                    });
                    D = points.yData[0];
                }

                SO.push([xVal[i], K, D]);
                yData[yData.length - 1][1] = D;
            }

            return {
                values: SO,
                xData: xData,
                yData: yData
            };
        };
    })(Highcharts);

    (function (H) {
        var EMA = H.seriesTypes.ema,
            defined = H.defined;

        H.seriesTypes.macd.prototype.getValues = function (series, params) {
            var j = 0,
                MACD = [],
                xMACD = [],
                yMACD = [],
                signalLine = [],
                shortEMA = void 0,
                longEMA = void 0,
                i = void 0;

            if (series.xData.length < params.longPeriod) {
                return false;
            }

            // Calculating the short and long EMA used when calculating the MACD
            shortEMA = EMA.prototype.getValues(series, {
                period: params.shortPeriod,
                index: 3
            });

            longEMA = EMA.prototype.getValues(series, {
                period: params.longPeriod,
                index: 3
            });

            shortEMA = shortEMA.values;
            longEMA = longEMA.values;

            // Subtract each Y value from the EMA's and create the new dataset
            // (MACD)
            for (i = 1; i <= shortEMA.length; i++) {
                if (defined(longEMA[i - 1]) && defined(longEMA[i - 1][1]) && defined(shortEMA[i + params.shortPeriod + 1]) && defined(shortEMA[i + params.shortPeriod + 1][0])) {
                    MACD.push([shortEMA[i + params.shortPeriod + 1][0], 0, null, shortEMA[i + params.shortPeriod + 1][1] - longEMA[i - 1][1]]);
                }
            }

            // Set the Y and X data of the MACD. This is used in calculating the
            // signal line.
            for (i = 0; i < MACD.length; i++) {
                xMACD.push(MACD[i][0]);
                yMACD.push([0, null, MACD[i][3]]);
            }

            // Setting the signalline (Signal Line: X-day EMA of MACD line).
            signalLine = EMA.prototype.getValues({
                xData: xMACD,
                yData: yMACD
            }, {
                period: params.signalPeriod,
                index: 2
            });

            signalLine = signalLine.values;

            // Setting the MACD Histogram. In comparison to the loop with pure
            // MACD this loop uses MACD x value not xData.
            for (i = 0; i < MACD.length; i++) {
                if (MACD[i][0] >= signalLine[0][0]) {
                    // detect the first point

                    MACD[i][2] = signalLine[j][1];
                    yMACD[i] = [0, signalLine[j][1], MACD[i][3]];

                    if (MACD[i][3] === null) {
                        MACD[i][1] = 0;
                        yMACD[i][0] = 0;
                    } else {
                        MACD[i][1] = MACD[i][3] - signalLine[j][1];
                        yMACD[i][0] = MACD[i][3] - signalLine[j][1];
                    }

                    j++;
                }
            }

            return {
                values: MACD,
                xData: xMACD,
                yData: yMACD
            };
        };
    })(Highcharts);

    // Highcharts plugin for displaying value information in the legend
    // Author: Torstein Honsi
    // License: MIT license
    // Version: 1.0.3 (2018-07-24)
    (function (H) {
        H.Series.prototype.point = {}; // The active point
        H.Chart.prototype.callbacks.push(function (chart) {
            $(chart.container).bind('mousemove', function () {
                var legendOptions = chart.legend.options,
                    hoverPoints = chart.hoverPoints;

                // Return when legend is disabled (#4)
                if (legendOptions.enabled === false) {
                    return;
                }

                if (!hoverPoints && chart.hoverPoint) {
                    hoverPoints = [chart.hoverPoint];
                }
                if (hoverPoints) {
                    H.each(hoverPoints, function (point) {
                        point.series.point = point;
                    });
                    H.each(chart.legend.allItems, function (item) {
                        item.legendItem.attr({
                            text: legendOptions.labelFormat ? H.format(legendOptions.labelFormat, item) : legendOptions.labelFormatter.call(item)
                        });
                    });
                    chart.legend.render();
                }
            });
        });
    })(Highcharts);

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
                rsi = [],
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

                rsi.push([data[i][0], // the date
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
                    height: 385,
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
                        },
                        zIndex: 5
                    }
                }, {
                    top: 450,
                    height: 170,
                    lineWidth: 3,
                    lineColor: '#212121',
                    min: 0,
                    max: 100,
                    tickInterval: 50,
                    resize: {
                        enabled: true
                    },
                    gridLineColor: 'rgba(160, 160, 160, 0.2)',
                    labels: {
                        // align: 'left',
                        x: -10,
                        y: -5,
                        style: {
                            color: '#000000',
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    plotBands: [{
                        from: 70,
                        to: 70,
                        color: '#c8e6c9',
                        width: 3,
                        label: {
                            y: -5,
                            style: {
                                color: '#616161',
                                fontFamily: 'sans-serif'
                            }
                        }
                    }, {
                        from: 30,
                        to: 30,
                        color: '#ef9a9a',
                        width: 2,
                        label: {
                            y: -5,
                            style: {
                                color: '#616161',
                                fontFamily: 'sans-serif'
                            }
                        }
                    }]
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
                }, {
                    type: 'rsi',
                    name: 'RSI',
                    yAxis: 1,
                    data: rsi,
                    params: {
                        period: 14,
                        overbought: 70,
                        oversold: 30
                    },
                    lineWidth: 2,
                    linkedTo: ticker_symbol.trim(),
                    color: 'green',
                    visible: true
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
                            yAxis: [{
                                lineWidth: 0,
                                labels: {
                                    x: 0
                                }
                            }, {
                                top: 355,
                                lineWidth: 0,
                                labels: {
                                    x: 0
                                }
                            }],
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

                    chart.renderer.text('RSI (14, 28)', 5, 346).attr({
                        rotation: 0
                    }).css({
                        color: '#000000',
                        fontSize: '12px'
                    }).add();
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

                    chart.renderer.text('RSI (14, 28)', 5, 440).attr({
                        rotation: 0
                    }).css({
                        color: '#000000',
                        fontSize: '12px'
                    }).add();
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