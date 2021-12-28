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

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
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

    // Highcharts plugin for displaying value information in the legend
    // Author: Torstein Honsi
    // License: MIT license
    // Version: 1.0.3 (2018-07-24)
    (function (H) {
        H.Series.prototype.point = {}; // The active point
        H.Chart.prototype.callbacks.push(function (chart) {
            $(chart.container).bind('touchmove', function () {
                let legendOptions = chart.legend.options,
                    hoverPoints = chart.hoverPoints;

                if (hoverPoints) {
                    H.each(hoverPoints, function (point) {
                        point.series.point = point;
                        if(point.series.name == "Volume") {
                            let volume_value = point.series.point.y;

                            if(typeof volume_value == "number" && volume_value != "") {
                                $('.volume-value').html(formatNumber(volume_value));
                            }
                        }
                        
                        let macd_value = point.series.point;
                        if(typeof macd_value.MACD == "number" && macd_value.MACD != "") {
                            $('.macd-value').html(formatNumber(macd_value.MACD.toFixed(2)));
                            $('.macd-signal').html(formatNumber(macd_value.signal.toFixed(2)));
                            $('.macd-divergence').html(formatNumber(macd_value.y.toFixed(2)));
                        }

                        let ohlc = point.series.point;
                        if(typeof ohlc.open == "number" && ohlc.open != "") {
                            $('#open-price').html(formatNumber(ohlc.open.toFixed(2)));
                            $('#high-price').html(formatNumber(ohlc.high.toFixed(2)));
                            $('#low-price').html(formatNumber(ohlc.low.toFixed(2)));
                            $('.close-price').html(formatNumber(ohlc.close.toFixed(2)));
                        }

                        let bb_value = point.series.point;
                        if(typeof bb_value.top == "number" && bb_value.top != "") {
                            $('#upper-bb').html(formatNumber(bb_value.top.toFixed(2)));
                            $('#middle-bb').html(formatNumber(bb_value.middle.toFixed(2)));
                            $('#lower-bb').html(formatNumber(bb_value.bottom.toFixed(2)));
                        }
                    });
                }
            });

            $(chart.container).bind('touchstart', function () {
                let legendOptions = chart.legend.options,
                    hoverPoints = chart.hoverPoints;

                if (hoverPoints) {
                    H.each(hoverPoints, function (point) {
                        point.series.point = point;
                        if(point.series.name == "Volume") {
                            let volume_value = point.series.point.y;

                            if(typeof volume_value == "number" && volume_value != "") {
                                $('.volume-value').html(formatNumber(volume_value));
                            }
                        }
                        
                        let macd_value = point.series.point;
                        if(typeof macd_value.MACD == "number" && macd_value.MACD != "") {
                            $('.macd-value').html(formatNumber(macd_value.MACD.toFixed(2)));
                            $('.macd-signal').html(formatNumber(macd_value.signal.toFixed(2)));
                            $('.macd-divergence').html(formatNumber(macd_value.y.toFixed(2)));
                        }

                        let ohlc = point.series.point;
                        if(typeof macd_value.open == "number" && ohlc.open != "") {
                            $('#open-price').html(formatNumber(ohlc.open.toFixed(2)));
                            $('#high-price').html(formatNumber(ohlc.high.toFixed(2)));
                            $('#low-price').html(formatNumber(ohlc.low.toFixed(2)));
                            $('.close-price').html(formatNumber(ohlc.close.toFixed(2)));
                        }

                        let bb_value = point.series.point;
                        if(typeof bb_value.top == "number" && bb_value.top != "") {
                            $('#upper-bb').html(formatNumber(bb_value.top.toFixed(2)));
                            $('#middle-bb').html(formatNumber(bb_value.middle.toFixed(2)));
                            $('#lower-bb').html(formatNumber(bb_value.bottom.toFixed(2)));
                        }
                    });
                }
            });
        });
    }(Highcharts));

    (function(H) {
    H.wrap(H.seriesTypes.bb.prototype, 'drawGraph', function(p) {
        // Draw lines:
        p.apply(this, Array.prototype.slice.call(arguments, 1));


        if (this.options.fillColor) {
            // Draw fill:
            var topPath = this.graphtopLine.attr('d').split(' '),
                bottomPath = this.graphbottomLine.attr('d').split(' '),
                bottomPathLength = bottomPath.length,
                path;

            bottomPath[0] = 'L';
            path = topPath;

            for (var i = bottomPathLength - 1; i >= 0; i -= 3) {
                path.push(bottomPath[i - 2], bottomPath[i - 1], bottomPath[i]);
            }

            if (!this.fillShape) {
                this.fillShape = this.chart.renderer.path(path)
                .attr({
                    fill: this.options.fillColor
                })
                .add(this.group);
            }

            this.fillShape.animate({
                d: path
            });
        }
    });
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
                volume = [],
                currentPriceLine = [],
                dataLength = data.length,
                groupingUnits = [
                    [
                        'millisecond', // unit name
                        [1, 2, 5, 10, 20, 25, 50, 100, 200, 500] // allowed multiples
                    ], [
                        'second',
                        [1, 2, 5, 10, 15, 30]
                    ], [
                        'minute',
                        [1, 2, 5, 10, 15, 30]
                    ], [
                        'hour',
                        [1, 2, 3, 4, 6, 8, 12]
                    ], [
                        'day',
                        [1]
                    ], [
                        'week',
                        [1]
                    ], [
                        'month',
                        [1, 3, 6]
                    ], [
                        'year',
                        null
                    ]
                ];
                let month = new Array();
                    month[0] = "01";
                    month[1] = "02";
                    month[2] = "03";
                    month[3] = "04";
                    month[4] = "05";
                    month[5] = "06";
                    month[6] = "07";
                    month[7] = "08";
                    month[8] = "09";
                    month[9] = "10";
                    month[10] = "11";
                    month[11] = "12";

                let day = new Array();
                    day[1] = "01";
                    day[2] = "02";
                    day[3] = "03";
                    day[4] = "04";
                    day[5] = "05";
                    day[6] = "06";
                    day[7] = "07";
                    day[8] = "08";
                    day[9] = "09";
                    day[10] = "10";
                    day[11] = "11";
                    day[12] = "12";
                    day[13] = "13";
                    day[14] = "14";
                    day[15] = "15";
                    day[16] = "16";
                    day[17] = "17";
                    day[18] = "18";
                    day[19] = "19";
                    day[20] = "20";
                    day[21] = "21";
                    day[22] = "22";
                    day[23] = "23";
                    day[24] = "24";
                    day[25] = "25";
                    day[26] = "26";
                    day[27] = "27";
                    day[28] = "28";
                    day[29] = "29";
                    day[30] = "30";
                    day[31] = "31";
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

                volume.push([
                    data[i][0], // the date
                    data[i][5] // the volume
                ]);

                currentPriceLine.push([
                    data[i][4] // close
                ]);
            }

            let removeLast = currentPriceLine.pop();
            let changeDirection = removeLast[0] - currentPriceLine[currentPriceLine.length - 1][0];

            Highcharts.stockChart('chart', {
                
                
                chart: {
                    backgroundColor: 'rgb(14, 17, 17)',
                    style: {
                        fontFamily: 'sans-serif'
                    },
                    marginTop: 20,
                    marginBottom: 0,
                    marginRight: 30,
                    marginLeft: 45,
                    // events: {
                    //     dataLoad: drawLabel,
                    //     redraw: drawLabel
                    // }
                },
                exporting: {
                    enabled: false
                },
                // scroll charts
                rangeSelector: {
                    inputEnabled: false,
                    selected: 2,
            
                    buttons: [{
                        type: 'month',
                        count: 1,
                        text: '1m'
                    }, {
                        type: 'month',
                        count: 3,
                        text: '3m'
                    }, {
                        type: 'month',
                        count: 6,
                        text: '6m'
                    }, {
                        type: 'ytd',
                        text: 'YTD'
                    }, {
                        type: 'year',
                        count: 1,
                        text: '1y',
                        dataGrouping: {
                            forced: true,
                            units: [['day', [1]]]
                        }
                    }],
                    buttonTheme: {
                        fill: '#000000',
                        stroke: '#000000',
                        style: {
                            color: '#707073'
                        },
                        width: 40,
                        // height: 15,
                        padding: 10,
                        states: {
                            hover: {
                                fill: '#000000',
                                stroke: '#000000',
                                style: {
                                    color: '#707073'
                                }
                            },
                            select: {
                                fill: '#00000',
                                stroke: '#000000',
                                style: {
                                    color: '#ffffff'
                                }
                            }
                        }
                    },
                    x: -37,
                    y: -43,
                },

                navigator: {
                    enabled: false
                },

                xAxis: [{
                    lineWidth: 1,
                    offset: 25,
                    lineColor: '#212121',
                    crosshair: true,
                    tickWidth: 0,
                    gridLineWidth: 0,
                    events: {
                        afterSetExtremes: function() {
                            let series_prices = this.series[0],
                            prices = series_prices.points,
                            start_price_date = prices[0].x,
                            start_price = prices[0].y,
                            end_price_date = prices[prices.length - 1].x,
                            end_price = prices[prices.length - 1].y;
                            open_price = prices[prices.length - 1].close;
                            high_price = prices[prices.length - 1].high;
                            low_price = prices[prices.length - 1].low;
                            close_price = prices[prices.length - 1].close;
                            change = close_price - prices[prices.length - 2].close;
                            percent_change = ((close_price - prices[prices.length - 2].close)/prices[prices.length - 2].close) * 100;
                            trade_time = moment(prices[prices.length - 1].x).add(16, 'h').format("h:mm:ss");

                            $('#open-price').html(formatNumber(open_price.toFixed(2)));
                            $('#high-price').html(formatNumber(high_price.toFixed(2)));
                            $('#low-price').html(formatNumber(low_price.toFixed(2)));
                            $('.close-price').html(formatNumber(close_price.toFixed(2)));
                            $('.last-price').html(formatNumber(close_price.toFixed(2)));
                            $('.change').html(formatNumber(change.toFixed(2)));
                            $('.percent-change').html(formatNumber(percent_change.toFixed(2)) + "%");
                            $('.trade-time').html(trade_time);

                            let bollinger_bands = this.series[1].points[this.series[1].points.length - 1];
                            
                            let time_period = '';
                            let time_period_frequency = '';
                            let closing_prices = [];
                            let min_max_series = [];

                            for (let i = 0; i < prices.length; i++) {
                                closing_prices[prices[i].category] = parseFloat(prices[i].close);
                            }

                            function getMinMax(obj, callback, context) {
                                let tuples = [];

                                for (let key in obj) tuples.push([key, obj[key]]);

                                tuples.sort(function(a, b) {
                                    return a[1] < b[1] ? 1 : a[1] > b[1] ? -1 : 0
                                });

                                let length = tuples.length;
                                while (length--) callback.call(context, tuples[length][0], tuples[length][1]);
                            }
                            
                            getMinMax(closing_prices, function(key, value) {
                                min_max_series.push({ key, value });
                            });

                            min_max = {
                                max_price_date: min_max_series[min_max_series.length - 1].key,
                                max_price_value: min_max_series[min_max_series.length - 1].value,
                                min_price_date: min_max_series[0].key,
                                min_price_value: min_max_series[0].value
                            };

                            (function () {
                                time_period = jQuery.timeago(start_price_date);
                                if (time_period == 'about a month ago' || time_period == '1 month ago') {
                                    time_period = '1M';
                                    time_period_frequency = '1D'
                                } else if (time_period == 'about 3 months ago' || time_period == '3 months ago') {
                                    time_period = '3M';
                                    time_period_frequency = '1D'
                                } else if (time_period == 'about 6 months ago' || time_period == '6 months ago') {
                                    time_period = '6M';
                                    time_period_frequency = '1D'
                                } else if (time_period == 'about a year ago' || time_period == '12 months ago') {
                                    time_period = '1Y';
                                    time_period_frequency = '1W'
                                } else {
                                    time_period = 'YTD';
                                    time_period_frequency = '1D'
                                }
                            }());

                            let sd = new Date(start_price_date);
                            let bd = new Date(end_price_date);
                            let hsd = new Date(parseInt(min_max.max_price_date));
                            let hbd = new Date(parseInt(min_max.min_price_date));

                            let full_date = month[sd.getMonth()] + '/' + day[sd.getDate()] + '/' + sd.getFullYear().toString().substr(-2) + " - " + month[bd.getMonth()] + '/' + day[bd.getDate()] + '/' + bd.getFullYear().toString().substr(-2);
                            let high_price_date = month[hsd.getMonth()] + '/' + day[hsd.getDate()] + '/' + hsd.getFullYear().toString().substr(-2);
                            let low_price_date = month[hbd.getMonth()] + '/' + day[hbd.getDate()] + '/' + hbd.getFullYear().toString().substr(-2);

                            $('#period').html(time_period);
                            $('#period-frequency').html(time_period_frequency);
                            $('#start-date').html(full_date);
                            $('#start-price').html(formatNumber(start_price.toFixed(2)));
                            $('#price-change').html(formatNumber((end_price - start_price).toFixed(2) + " (" + (((end_price - start_price)/start_price) * 100).toFixed(2)) + "%)");
                            $('#high-date').html(high_price_date);
                            $('#high-price-period').html(formatNumber(min_max.max_price_value.toFixed(2)));
                            $('#low-date').html(low_price_date);
                            $('#low-price-period').html(formatNumber(min_max.min_price_value.toFixed(2)));
                            $('#upper-bb').html(formatNumber(bollinger_bands.top.toFixed(2)));
                            $('#middle-bb').html(formatNumber(bollinger_bands.middle.toFixed(2)));
                            $('#lower-bb').html(formatNumber(bollinger_bands.bottom.toFixed(2)));
                        }
                    },
                    labels: {
                        formatter: function() {
                            return;
                        }
                    }
                }],

                yAxis: [{
                    height: '200',
                    // endOnTick: true,
                    showLastLabel: true,
                    showFirstLabel: true,
                    // startOnTick: false,
                    lineWidth: 1,
                    lineColor: '#212121',
                    crosshair: true,
                    labels: {
                        x: 30,
                        y: 3,
                        formatter: function() {                                        
                            let values = [];
                            let last = this.chart.series[0].yData[this.chart.series[0].yData.length - 1][3];
                            let labels = [];
                            let labels_flatten = [];
                            
                            return this.value;
                        }
                    },
                    resize: {
                        enabled: false
                    },
                    maxPadding: 0.28,
                    gridLineWidth: 1,
                    gridLineColor: '#212121',
                    offset: 0
                }, {
                    top: '290',
                    height: '50',
                    lineWidth: 1,
                    lineColor: '#212121',
                    labels: {
                        x: 30,
                        y: 3,
                        style: {
                            color: '#707073',
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    gridLineWidth: 0,
                    gridLineColor: '#212121',
                    visible: true
                }, {
                    top: '374',
                    height: '80',
                    lineWidth: 1,
                    lineColor: '#212121',
                    labels: {
                        x: 30,
                        y: 3,
                        style: {
                            color: '#707073',
                            fontFamily: 'sans-serif',
                            textShadow: false
                        }
                    },
                    gridLineWidth: 0
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
                        showInNavigator: true,
                        fillColor: 'rgba(13, 71, 161, .5)'
                    }
                },
                credits: {
                    enabled: false
                },
                labels: {
                    style: {
                        color: '#707073'
                    }
                },

                series: [{
                    id: ticker_symbol.trim(),
                    type: 'candlestick',
                    name: series_name.toUpperCase(),
                    data: ohlc,
                    // lastVisiblePrice: {
                    //     enabled: true,
                    //     label: {
                    //         enabled: true
                    //     }
                    // }
                    // id: ticker_symbol.trim(),
                    // name: series_name.toUpperCase(),
                    // data: ohlc,
                    // type: 'area',
                    // threshold: null,
                    // lineColor: 'rgb(13, 71, 161)',
                    // fillColor: 'rgba(13, 71, 161, .3)',
                    // zIndex: 2
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
                            lineColor: '#ef9a9a'
                        }
                    },
                    bottomLine: {
                        styles: {
                            lineWidth: 2,
                            lineColor: '#43a047'
                        }
                    },
                    lineWidth: 2,
                    color: '#707073',
                    // fillColor: 'rgba(13, 71, 161, .3)',
                    // fillColor: 'rgba(33, 33, 33, 0.9)'
                }, {
                    type: 'column',
                    name: 'Volume',
                    data: volume,
                    yAxis: 1,
                    visible: true
                }, {
                    type: 'macd',
                    name: 'MACD',
                    yAxis: 2,
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
                tooltip: {
                    enabledIndicators: true,
                    valueDecimals: 2,
                    xDateFormat: '%B %d, %Y %l:%M %p',
                    shared: true,
                    borderWidth: 0,
                    positioner: function () {
                        return { x: 210, y: 10 };
                    },
                    formatter: function() {
                        let date = new Date (this.x);
                        return "<b>Date</b> " + month[date.getMonth()] + "/" + day[date.getDate()] + "/" + date.getFullYear();
                    }
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
                                // offset: 550
                            }]
                        }
                    }, {
                        condition: {
                            maxWidth: 667,
                            minWidth: 320,
                        },
                        chartOptions: {
                            
                            chart: {
                                marginLeft: 3,
                                marginTop: 50,
                                marginBottom: 0
                            },
                        }
                    }]
                },
            }, function (chart) {
                $('.highcharts-range-selector-buttons text:first').css({ 'display': 'none' });
                $('#last-trade-label').css({ 'color': '#c00' });
             
                $(document).on('click', '.highcharts-range-input', function(e) {
                    e.preventDefault();
                });
                let volume_value = this.series[2].points[this.series[2].points.length - 1].y;
                let macd_value = this.series[3].points[this.series[3].points.length - 1].MACD;
                let signal_value = this.series[3].points[this.series[3].points.length - 1].signal;
                let divergence_value = this.series[3].points[this.series[3].points.length - 1].y;

                let ohlc_chart = this.series[0].points[this.series[0].points.length - 1];
                
                $('.macd-value').html(macd_value.toFixed(2));

                if ($(window).width() <= 667){
                    // if($("#bracketorder_symbol").val() === "") {
                    //     chart.renderer.text(ticker_symbol.toUpperCase(), 5, 60)
                    //         .attr({
                    //             rotation: 0
                    //         })
                    //         .css({
                    //             color: '#707073',
                    //             fontSize: '12px'
                    //         })
                    //         .add();
                    // } else {
                    //     chart.renderer.text($("#bracketorder_symbol").val().toUpperCase(), 5, 60)
                    //         .attr({
                    //             rotation: 0
                    //         })
                    //         .css({
                    //             color: '#707073',
                    //             fontSize: '12px'
                    //         })
                    //         .add();
                    // }

                    chart.renderer.text('<i class="fas fa-square white-indicator"></i> AMZN US Equity <span class="white-indicator spacer close-price">' + formatNumber(ohlc_chart.y.toFixed(2)) + '</span>', 3, 80, true)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#707073',
                            fontSize: '12px'
                        })
                        .add();
            
                    chart.renderer.text('<i class="fas fa-square blue-indicator"></i> Volume <span class="white-indicator volume-value spacer" id="volume">' + formatNumber(volume_value) + '</span>', 3, 280, true)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#707073',
                            fontSize: '12px'
                        })
                        .add();

                    chart.renderer.text('<i class="fas fa-square green-indicator"></i> MACD <span class="white-indicator macd-value spacer">' + macd_value.toFixed(2) + '</span>', 3, 362, true)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#707073',
                            fontSize: '12px'
                        })
                        .add();

                    chart.renderer.text('<i class="fas fa-square grey-indicator spacer"></i> Signal <span class="white-indicator macd-signal spacer">' + signal_value.toFixed(2) + '</span>', 100, 362, true)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#707073',
                            fontSize: '12px'
                        })
                        .add();

                    chart.renderer.text('<i class="fas fa-square blue-indicator spacer"></i> Divergence <span class="white-indicator macd-divergence spacer">'  + divergence_value.toFixed(2) + '</span>', 200, 362, true)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#707073',
                            fontSize: '12px'
                        })
                        .add();

                } else {
                    // if($("#bracketorder_symbol").val() === "") {
                    //     chart.renderer.text(ticker_symbol.toUpperCase(), 5, 55)
                    //         .attr({
                    //             rotation: 0
                    //         })
                    //         .css({
                    //             color: '#707073',
                    //             fontSize: '12px'
                    //         })
                    //         .add();
                    // } else {
                    //     chart.renderer.text($("#bracketorder_symbol").val().toUpperCase(), 5, 55)
                    //         .attr({
                    //             rotation: 0
                    //         })
                    //         .css({
                    //             color: '#707073',
                    //             fontSize: '12px'
                    //         })
                    //         .add();
                    // }

                    chart.renderer.text('<i class="fas fa-square white-indicator"></i> AMZN US Equity <span class="white-indicator spacer close-price">' + formatNumber(ohlc_chart.y.toFixed(2)) + '</span>', 3, 80, true)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#707073',
                            fontSize: '12px'
                        })
                        .add();
            
                    chart.renderer.text('<i class="fas fa-square blue-indicator"></i> Volume <span class="white-indicator volume-value spacer" id="volume">' + formatNumber(volume_value) + '</span>', 3, 280, true)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#707073',
                            fontSize: '12px'
                        })
                        .add();

                    chart.renderer.text('<i class="fas fa-square green-indicator"></i> MACD <span class="white-indicator macd-value spacer">' + macd_value.toFixed(2) + '</span>', 3, 362, true)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#707073',
                            fontSize: '12px'
                        })
                        .add();

                    chart.renderer.text('<i class="fas fa-square grey-indicator spacer"></i> Signal <span class="swhite-indicator macd-signal spacer">' + signal_value.toFixed(2) + '</span>', 100, 362, true)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#707073',
                            fontSize: '12px'
                        })
                        .add();

                    chart.renderer.text('<i class="fas fa-square blue-indicator spacer"></i> Divergence <span class="white-indicator macd-divergence spacer">'  + divergence_value.toFixed(2) + '</span>', 200, 362, true)
                        .attr({
                            rotation: 0
                        })
                        .css({
                            color: '#707073',
                            fontSize: '12px'
                        })
                        .add();
                }

                $.ajax({
                    url: '/account/dashboard/get-indicator',
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
