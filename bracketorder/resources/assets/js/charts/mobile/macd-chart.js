(function () {

    let ticker_symbol;

    if ($('#bracketorder_symbol').val()) {
        ticker_symbol = $('#bracketorder_symbol').val();
    } else {
        ticker_symbol = "gspc.indx";
    }

    let stock_code = ticker_symbol.split('.');
    let autoload = ticker_symbol.split(' - ');

    if (stock_code[1] === "indx" || stock_code[1] === "us") {
        series_name = stock_code[0]
    } else if("1" in autoload) {

        series_name = autoload[0];
        ticker_symbol = autoload[0];
    } else {
        series_name = ticker_symbol;
    }

    (function(H) {
        let EMA = H.seriesTypes.ema,
            defined = H.defined;

        H.seriesTypes.macd.prototype.getValues = function(series, params) {
            let j = 0,
                MACD = [],
                xMACD = [],
                yMACD = [],
                signalLine = [],
                shortEMA,
                longEMA,
                i;

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
                if (
                    defined(longEMA[i - 1]) &&
                    defined(longEMA[i - 1][1]) &&
                    defined(shortEMA[i + params.shortPeriod + 1]) &&
                    defined(shortEMA[i + params.shortPeriod + 1][0])
                ) {
                    MACD.push([
                        shortEMA[i + params.shortPeriod + 1][0],
                        0,
                        null,
                        shortEMA[i + params.shortPeriod + 1][1] -
                        longEMA[i - 1][1]
                    ]);
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
                if (MACD[i][0] >= signalLine[0][0]) { // detect the first point

                    MACD[i][2] = signalLine[j][1];
                    yMACD[i] = [0, signalLine[j][1], MACD[i][3]];

                    if (MACD[i][3] === null) {
                        MACD[i][1] = 0;
                        yMACD[i][0] = 0;
                    } else {
                        MACD[i][1] = (MACD[i][3] - signalLine[j][1]);
                        yMACD[i][0] = (MACD[i][3] - signalLine[j][1]);
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
        success: function (data) {
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
            let ohlc = [],
                sma21 = [],
                sma63 = [],
                sma200 = [],
                macd = [],
                currentPriceLine = [],
                dataLength = data.length,

                i = 0;

            for (i; i < dataLength; i += 1) {
                ohlc.push([
                    data[i][0], // the date
                    data[i][1], // open
                    data[i][2], // high
                    data[i][3], // low
                    data[i][4] // close
                ]);

                macd.push([
                    data[i][0], // the date
                    data[i][1], // open
                    data[i][2], // high
                    data[i][3], // low
                    data[i][4] // close
                ]);

                sma21.push([
                    data[i][0], // the date
                    data[i][1], // open
                    data[i][2], // high
                    data[i][3], // low
                    data[i][4] // close
                ]);

                sma63.push([
                    data[i][0], // the date
                    data[i][1], // open
                    data[i][2], // high
                    data[i][3], // low
                    data[i][4] // close
                ]);

                sma200.push([
                    data[i][0], // the date
                    data[i][1], // open
                    data[i][2], // high
                    data[i][3], // low
                    data[i][4] // close
                ]);

                currentPriceLine.push([
                    data[i][4] // close
                ]);
            }

            let removeLast = currentPriceLine.pop();
            let changeDirection = removeLast[0] - currentPriceLine[currentPriceLine.length - 1][0];

            Highcharts.stockChart('chart', {
                chart: {
                    alignTicks: false,
                    marginTop: 0,
                    marginRight: 5,
                    marginLeft: 5,
                    backgroundColor: '#ffffff',
                    events: {
                        addSeries: function () {}
                    }
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
                    // offset: -380,
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
                    tickInterval : 5,
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
                    labels: {
                        x: -10,
                        y: -5,
                        style: {
                            color: '#000000',
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    resize: {
                        enabled: true
                    },
                    gridLineColor: 'rgba(160, 160, 160, 0.2)'
                }],

                plotOptions: {
                    series: {
                        showInLegend: true,
                        turboThreshold: 1000000000,
                        marker: {
                            enabled: false
                        },
                        events: {
                            legendItemClick: function () {
                                return false;
                            }
                        },
                        dataGrouping: {
                            enabled: true,
                            forced: true,
                            units: [
                                ['day', [1]],
                                ['week', [1]],
                                ['month', [1, 3, 6]]
                            ]
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
                    type: 'macd',
                    name: 'MACD',
                    yAxis: 1,
                    data: data,
                    opposite: false,
                    lineWidth: 2,
                    linkedTo: ticker_symbol.trim(),
                    params: {
                        index: 3,
                        shortPeriod: 12,
                        longPeriod: 26,
                        signalPeriod: 9,
                        period: 26
                    },
                    zones: [{
                        value: 0,
                        color: '#c8e6c9'
                    }, {
                        color: '#ef9a9a'
                    }],
                    macdLine: {
                        styles: {lineColor: 'green'}
                    },
                    signalLine: {
                        styles: {lineColor: '#616161'}
                    },
                    color: '#ef9a9a',
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
                            minWidth: 1025,
                        },
                        chartOptions: {
                            legend: {
                                itemDistance: 150,
                            }
                        }
                    }, {
                        condition: {
                            maxWidth: 768,
                            minWidth: 768,
                        },
                        chartOptions: {
                            xAxis: [{
                                offset: -15
                            }]
                        }
                    }, {
                        condition: {
                            maxWidth: 667,
                            minWidth: 320,
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
                                backgroundColor: '#ffffff',
                            },
                        }
                    }]
                },

                exporting: {
                    enabled: false
                }
            }, function (chart) {
                $('.highcharts-range-selector-buttons text:first').css('display', 'none');

                if ($(window).width() <= 667){
                    if($("#bracketorder_symbol").val() === "") {
                        chart.renderer.text(ticker_symbol.toUpperCase(), 5, 60)
                            .attr({
                                rotation: 0
                            })
                            .css({
                                color: '#000000',
                                fontSize: '12px'
                            })
                            .add();
                    } else {
                        chart.renderer.text($("#bracketorder_symbol").val(), 5, 60)
                            .attr({
                                rotation: 0
                            })
                            .css({
                                color: '#000000',
                                fontSize: '12px'
                            })
                            .add();
                    }

                    chart.renderer.text('MACD (12, 26)', 5, 346)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#000000',
                            fontSize: '12px'
                        })
                        .add();
                } else {
                    if($("#bracketorder_symbol").val() === "") {
                        chart.renderer.text(ticker_symbol.toUpperCase(), 5, 55)
                            .attr({
                                rotation: 0
                            })
                            .css({
                                color: '#000000',
                                fontSize: '12px'
                            })
                            .add();
                    } else {
                        chart.renderer.text($("#bracketorder_symbol").val(), 5, 55)
                            .attr({
                                rotation: 0
                            })
                            .css({
                                color: '#000000',
                                fontSize: '12px'
                            })
                            .add();
                    }

                    chart.renderer.text('MACD (12, 26)', 5, 440)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#000000',
                            fontSize: '12px'
                        })
                        .add();
                }

                $.ajax({
                    url: '/account/get-indicator',
                    type: "GET",
                    success: function (data) {
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
}());
