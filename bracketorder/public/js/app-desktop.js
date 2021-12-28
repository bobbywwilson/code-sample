let series_name;
let ticker_symbol;

function stochastic_fast_chart(ticker_symbol, sma_1, sma_2, sma_3, sma_periods_1, sma_periods_2, sma_periods_3, sma_color_1, sma_color_2, sma_color_3) {

    ticker_symbol = 'dji.indx';

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
        let isArray = H.isArray,
            SMA = H.seriesTypes.sma,
            reduce = H.reduce,
            getArrayExtremes = function (arr, minIndex, maxIndex) {
                return reduce(arr, function (prev, target) {
                    return [
                        Math.min(prev[0], target[minIndex]),
                        Math.max(prev[1], target[maxIndex])
                    ];
                }, [Number.MAX_VALUE, -Number.MAX_VALUE]);
            };
        H.seriesTypes.stochastic.prototype.getValues = function(series, params) {
            let periodK = params.periods[0],
                periodD = params.periods[1],
                xVal = series.xData,
                yVal = series.yData,
                yValLen = yVal ? yVal.length : 0,
                SO = [], // 0- date, 1-%K, 2-%D
                xData = [],
                yData = [],
                slicedY,
                close = 3,
                low = 2,
                high = 1,
                CL, HL, LL, K,
                D = null,
                points,
                extremes,
                i;


// Stochastic requires close value
            if (
                yValLen < periodK ||
                !isArray(yVal[0]) ||
                yVal[0].length !== 4
            ) {
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
                if (i >= (periodK - 1) + (periodD - 1)) {
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
        }
    })(Highcharts);

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
                bb = [],
                macd = [],
                rsi = [],
                stochastic = [],
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

                bb.push([
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

                rsi.push([
                    data[i][0], // the date
                    data[i][1], // open
                    data[i][2], // high
                    data[i][3], // low
                    data[i][4] // close
                ]);

                stochastic.push([
                    data[i][0], // the date
                    data[i][1], // open
                    data[i][2], // high
                    data[i][3], // low
                    data[i][4] // close
                ]);
            }

            Highcharts.stockChart('chart', {
                chart: {
                    marginTop: 100,
                    marginRight: 70,
                    marginLeft: 20,
                    marginBottom: 100,
                    backgroundColor: '#000000',
                },

                rangeSelector: {
                    inputEnabled: false,
                    buttonPosition:{
                        x: -19,
                    },
                    inputTheme: { // styles for the buttons
                        style: {
                            color: '#ffffff',
                            fontWeight: 300,
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    buttonTheme: { // styles for the buttons
                        fill: 'none',
                        stroke: '#ffffff',
                        'stroke-width': 1,
                        r: 1,
                        width: 50,
                        height: 15,
                        padding: 5,
                        style: {
                            color: '#ffffff',
                            fontWeight: 300,
                            fontFamily: 'sans-serif',
                            textShadow: false
                        },
                        states: {
                            hover: {
                                fill: '#ffffff',
                                style: {
                                    color: '#000000'
                                }
                            },
                            select: {
                                fill: '#ffffff',
                                style: {
                                    color: '#000000'
                                }
                            }
                        }
                    },
                    inputBoxBorderColor: '#ffffff',
                    inputBoxWidth: 120,
                    inputBoxHeight: 18,
                    inputStyle: {
                        color: '#ffffff',
                        fontWeight: 300
                    },
                    labelStyle: {
                        color: '#000000',
                        fontWeight: 300
                    },
                    selected: 1,
                    inputPosition: {
                        x: 15
                    }
                },

                navigator: {
                    enabled: false
                },

                xAxis: [{
                    crosshair: true,
                    lineWidth: 3,
                    offset: 30,
                    lineColor: 'rgba(39, 39, 39, .3)',
                    labels: {
                        style: {
                            color: '#ffffff',
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    gridLineWidth: 1,
                    gridLineColor: 'rgba(39, 39, 39, .3)',
                }],

                yAxis: [{
                    crosshair: true,
                    height: 200,
                    lineWidth: 3,
                    lineColor: '#212121',
                    resize: {
                        enabled: true
                    },
                    gridLineColor: 'rgba(39, 39, 39, .3)',
                    labels: {
                        align: 'right',
                        x: 30,
                        y: 3,
                        style: {
                            color: '#ffffff',
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    title: {
                        text: series_name.toUpperCase(),
                        x: 30,
                        y: 5,
                        style: {
                            color: '#ffffff'
                        }
                    }
                }, {
                    top: 360,
                    height: 100,
                    lineWidth: 3,
                    lineColor: '#212121',
                    offset: 0,
                    labels: {
                        formatter: function () {
                            return this.value / 10;
                        },
                        align: 'right',
                        x: 30,
                        y: 3,
                        style: {
                            color: '#ffffff',
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    resize: {
                        enabled: true
                    },
                    gridLineColor: 'rgba(39, 39, 39, .3)',
                    title: {
                        text: 'MACD',
                        x: 30,
                        y: 5,
                        style: {
                            color: '#ffffff'
                        }
                    }
                }, {
                    top: 485,
                    height: 100,
                    lineWidth: 3,
                    lineColor: '#212121',
                    min: 0,
                    max: 100,
                    tickInterval: 50,
                    resize: {
                        enabled: true
                    },
                    gridLineColor: 'rgba(39, 39, 39, .3)',
                    offset: 0,
                    labels: {
                        align: 'right',
                        x: 30,
                        y: 2,
                        style: {
                            color: '#ffffff',
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    title: {
                        text: 'RSI',
                        x: 30,
                        y: 5,
                        style: {
                            color: '#ffffff'
                        }
                    },
                    plotBands: [{
                        from: 70,
                        to: 70,
                        color: '#ef9a9a',
                        width: 3,
                        label: {
// text: "Overbought",
                            style: {
                                color: '#616161',
                                fontFamily: 'sans-serif'
                            }
                        }
                    }, {
                        from: 30,
                        to: 30,
                        color: '#c8e6c9',
                        width: 2,
                        label: {
// text: "Oversold",
                            style: {
                                color: '#616161',
                                fontFamily: 'sans-serif'
                            }
                        }
                    }]
                }, {
                    top: 610,
                    height: 100,
                    lineWidth: 2,
                    lineColor: '#212121',
                    min: 0,
                    max: 100,
                    tickInterval: 50,
                    resize: {
                        enabled: true
                    },
                    gridLineColor: 'rgba(39, 39, 39, .3)',
                    offset: 0,
                    labels: {
                        align: 'right',
                        x: 30,
                        y: 2,
                        style: {
                            color: '#ffffff',
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    title: {
                        text: 'STOCHASTIC',
                        x: 30,
                        y: 5,
                        style: {
                            color: '#ffffff'
                        }
                    },
                    plotBands: [{
                        from: 80,
                        to: 80,
                        color: '#ef9a9a',
                        width: 1,
                        label: {
// text: "Overbought",
                            style: {
                                color: '#616161',
                                fontFamily: 'sans-serif'
                            }
                        }
                    }, {
                        from: 20,
                        to: 20,
                        color: '#c8e6c9',
                        width: 2,
                        label: {
// text: "Oversold",
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
                        color: '#ef9a9a',
                        lineColor: '#b71c1c',
                        upLineColor: '#43a047',
                        upColor: '#c8e6c9',
                        showInNavigator: true
                    }
                },

                series: [{
                    id: ticker_symbol.trim(),
                    type: 'candlestick',
                    name: series_name.toUpperCase(),
                    data: ohlc
                }, {
                    type: 'sma',
                    linkedTo: ticker_symbol.trim(),
                    data: sma21,
                    params: {
                        index: 3,
                        period: 21
                    },
                    color: '#c8e6c9',
                    showInNavigator: false
                }, {
                    type: 'sma',
                    linkedTo: ticker_symbol.trim(),
                    data: sma63,
                    params: {
                        index: 3,
                        period: 63
                    },
                    color: '#ffff8d',
                    showInNavigator: false
                }, {
                    type: 'sma',
                    linkedTo: ticker_symbol.trim(),
                    data: sma200,
                    params: {
                        index: 3,
                        period: 200
                    },
                    color: '#ef9a9a',
                    showInNavigator: false
                }, {
                    type: 'bb',
                    name: 'Bollinger Bands',
                    data: bb,
                    params:{
                        index: 3,
                        period: 20,
                        standardDeviation: 1.9495
                    },
                    turboThreshold: 100000,
                    linkedTo: ticker_symbol.trim(),
                    topLine: {
                        styles: {
                            lineWidth: 2,
                            lineColor: 'green'
                        }
                    },
                    bottomLine: {
                        styles: {
                            lineWidth: 2,
                            lineColor: 'green'
                        }
                    },
                    lineWidth: 2,
                    color: 'green'
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
                        color: '#ef9a9a'
                    }, {
                        color: '#c8e6c9'
                    }],
                    macdLine: {
                        styles: {lineColor: 'green'}
                    },
                    signalLine: {
                        styles: {lineColor: '#616161'}
                    },
                    color: 'green',
                    visible: true
                }, {
                    type: 'rsi',
                    name: 'RSI',
                    yAxis: 2,
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
                }, {
                    type: 'stochastic',
                    name: 'Stochastic',
                    yAxis: 3,
                    data: stochastic,
                    linkedTo: ticker_symbol.trim(),
                    color: 'green',
                    smoothedLine:{
                        styles:{
                            lineColor: '#616161'
                        }
                    },
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
                legend: {
                    enabled: true,
                    floating: true,
                    align: 'left',
                    verticalAlign: 'top',
                    y: 25,
                    x: -20,
                    itemDistance: 40,
                    labelFormat: '<div class="row"><div class="col s3"><span style="color: #ffffff; text-shadow: none;">{name}</span>: <b><span style="color:#1e88e5">{point.y:,.2f}</b></div></div>',
                    borderWidth: 0
                },

                exporting: {
                    enabled: false
                }
            }, function (chart) {
                let series = chart.series;
                $(series).each(function (i, serie) {
                    if (serie.legendSymbol) serie.legendSymbol.destroy();
                    if (serie.legendLine) serie.legendLine.destroy();
                });
            });
        }
    });
}

$(document).ready(function() {

    let $body = $("body");
    let user_id = $('#user_id_bracket').val();
    ticker_symbol = 'gspc.indx';

    $(document).on({
        ajaxStart: function() {
            $body.addClass("loading");
        },
        ajaxStop: function() {
            $body.removeClass("loading");
        }
    });

    $.ajax({
        url: '/account/get-indicator',
        type: "GET",
        success: function (data) {
            $data = $(data);

            if (data['study'] === "bollinger_bands") {
                bollinger_bands_chart(ticker_symbol)
            } else if(data['study'] === "macd") {
                macd_chart(ticker_symbol);
            } else if (data['study'] === "rsi") {
                rsi_chart(ticker_symbol);
            } else if(data['study'] === "stochastic_fast") {
                stochastic_fast_chart(ticker_symbol);
            } else {
                // chart(ticker_symbol);
            }
        }
    });

    $.ajax({
        url: '/account/market-quote',
        type: "GET",
        success: function (data) {
            $data = $(data);
            $('.markets-quote').html($data);
        }
    });

    $.ajax({
        url: '/account/bracketorder?ticker_symbol=' + ticker_symbol.trim(),
        type: "GET",
        success: function (data) {
            $data = $(data);
            $('#bracketorder-quote').html($data);
        }
    });

    $.ajax({
        url: '/account/market-technicals?ticker_symbol=' + ticker_symbol.trim(),
        type: "GET",
        success: function (data) {
            $data = $(data);
            $('#technical-tables').html($data);
        }
    });

    $.ajax({
        url: '/account/watchlist-button?ticker_symbol=' + ticker_symbol.trim(),
        type: "GET",
        success: function (data) {
            $data = $(data);
            $('#add-to-watchlist-technicals').html($data);
        }
    });

    $.ajax({
        url: '/account/watchlist?user_id=' + user_id.trim(),
        type: "GET",
        success: function (data) {
            $data = $(data);
            $('#watchlist-tables').html($data);
        }
    });

    $('.tabs').tabs();

    $('select').formSelect();

    $('.collapsible').collapsible();

    $('.sidenav').sidenav({
        draggable: false,
        preventScrolling: true
    });

    $('#slide-out-login').sidenav({
        draggable: false,
        preventScrolling: true
    });

    $('#slide-out-right-top-news, #slide-out-right-business, #slide-out-right-technology, #slide-out-right-us-news, #slide-out-right-world, #slide-out-right-watchlist').sidenav({
        edge: 'right',
        draggable: false,
        preventScrolling: true
    });

    $("#bracketorder_symbol").keyup(function(){
        if($("#bracketorder_symbol").val() === "") {
            $('#go-button').removeClass('hide');
            $('#clear-button').addClass('hide');
        }
    });

    $('#clear-button').click(function() {
        $('#bracketorder_symbol').val("").focus();
        $('#go-button').removeClass('hide');
        $('#clear-button').addClass('hide');
// $('#bracketorder_symbol_label').removeClass('active');
    });

    $('.highcharts-range-input > tspan').click(function() {
        console.log('clicked');
    });
});
