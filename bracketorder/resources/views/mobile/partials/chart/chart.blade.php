<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bracket Order | Account</title>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    {{-- <script src="https://code.highcharts.com/stock/modules/drag-panes.js"></script> --}}
    <script src="https://code.highcharts.com/stock/indicators/indicators.js"></script>
    <script src="https://code.highcharts.com/stock/indicators/bollinger-bands.js"></script>
    <script src="https://code.highcharts.com/stock/indicators/ema.js"></script>
    <script src="https://code.highcharts.com/stock/indicators/macd.src.js"></script>
    <script src="https://code.highcharts.com/stock/indicators/rsi.js"></script>
    <script src="https://code.highcharts.com/stock/indicators/stochastic.js"></script>
    {{-- <script src="https://code.highcharts.com/stock/modules/price-indicator.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data-2012-2022.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> --}}
    
     <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script src="{{ asset(elixir('js/orientationchange.js')) }}"></script>

    {{-- <script src="{{ asset(elixir('js/mobile/app.js')) }}"></script> --}}

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-xVVam1KS4+Qt2OrFa+VdRUoXygyKIuNWUUUBZYv+n27STsJ7oDOHJgfF0bNKLMJF" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{{ asset(elixir('css/mobile/materialize.css')) }}"> --}}
    
    <script src="{{ asset(elixir('js/timeago.js')) }}"></script>

    {{-- <link rel="stylesheet" href="{{ asset(elixir('css/mobile/all.css')) }}"> --}}

    <script>
        (function () {

            let series_name;
            let ticker_symbol;

            if ($('#bracket-quote-input').val()) {
                ticker_symbol = $('#bracket-quote-input').val();
            } else {
                ticker_symbol = "amzn.us";
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

            $('#bracket-symbol').html(stock_code[0].toUpperCase() + " " + "US Equity");

            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            }

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
                        volume = [],
                        bb = [],
                        macd = [],
                        currentPriceLine = [],
                        dataLength = data.length;
        
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

                        volume.push([
                            data[i][0], // the date
                            data[i][5] // the volume
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

                        currentPriceLine.push([
                            data[i][4] // close
                        ]);
                    }

                    i = 0;
                    for (i; i < 5; i += 1) {
                        ohlc.push([
                            ohlc[ohlc.length - 1][0] += 1000 * 60 * 60 * 24 * 1, // the date
                            // null
                            null, // open
                            null, // high
                            null, // low
                            null // close
                        ]);
                    }

                    Highcharts.stockChart('chart', {
                        chart: {
                            backgroundColor: 'rgb(14, 17, 17)',
                            style: {
                                fontFamily: 'sans-serif'
                            },
                            marginRight: 15
                        },

                        rangeSelector: {
                            selected: 4,

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
                                text: '1y'
                            }],
                            buttonTheme: {
                                fill: '#000000',
                                stroke: '#000000',
                                style: {
                                    color: '#707073'
                                },
                                width: 30,
                                height: 15,
                                padding: 7.5,
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
                            // y: -43,
                        },

                        xAxis: [{
                            showLastLabel: false,
                            showFirstLabel: true,
                            lineWidth: 1,
                            offset: 0,
                            lineColor: '#212121',
                            crosshair: true,
                            tickWidth: 0,
                            gridLineWidth: 0,
                            events: {
                                afterSetExtremes: function() {
                                    let series_prices = this.series[0],
                                    prices = series_prices.points,
                                    start_price_date = prices[0].x,
                                    end_price_date = prices[prices.length - 1].x;

                                    (function () {
                                        time_period = jQuery.timeago(start_price_date);
                                        if (time_period == 'about a month ago' || time_period == '1 month ago') {
                                            time_period = '1M';
                                            time_period_frequency = '1D';

                                            // let pointsToAdd = [
                                            //     [end_price_date += 1000 * 60 * 60 * 24 * 21, null, null, null, null]
                                            // ];

                                            // i = 0;
                                            // for (i; i < 5; i += 1) {
                                            //     redraw_chart(pointsToAdd);
                                            // }

                                            // chart.redraw();
                                        } else if (time_period == 'about 3 months ago' || time_period == '3 months ago') {
                                            time_period = '3M';
                                            time_period_frequency = '1D'
                                        } else if (time_period == 'about 6 months ago' || time_period == '6 months ago') {
                                            time_period = '6M';
                                            time_period_frequency = '1W'
                                        } else if (time_period == 'about a year ago' || time_period == '12 months ago') {
                                            time_period = '1Y';
                                            time_period_frequency = '1W'
                                        } else {
                                            time_period = 'YTD';
                                            time_period_frequency = '1W'
                                        }
                                    }());
                                }
                            },
                        }],

                        yAxis: [{
                            // height: '200',
                            // showLastLabel: true,
                            // showFirstLabel: true,
                            lineWidth: 0,
                            lineColor: '#212121',
                            crosshair: true,
                            labels: {
                                // x: 20,
                                // y: 3,
                                formatter: function() {                                        
                                    let values = [];
                                    let last = this.chart.series[0].yData[this.chart.series[0].yData.length - 1][3];
                                    let labels = [];
                                    let labels_flatten = [];
                                    
                                    return this.value;
                                }
                            },
                            resize: {
                                enabled: true
                            },
                            gridLineWidth: 0,
                            gridLineColor: '#212121'
                        }],
                        
                        plotOptions: {
                            series: {
                                showInLegend: false,
                                connectNulls: false,
                                turboThreshold: 1000000000,
                                marker: {
                                    enabled: false
                                },
                                events: {
                                    legendItemClick: function () {
                                        return false;
                                    }
                                }
                            },
                            candlestick: {
                                color: '#ef9a9a',
                                lineColor: '#b71c1c',
                                upLineColor: '#43a047',
                                upColor: '#c8e6c9',
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
                            dataGrouping: {
                                units: [
                                    [
                                        'week', // unit name
                                        [1] // allowed multiples
                                    ], [
                                        'month',
                                        [1, 3, 6]
                                    ]
                                ]
                            }
                        }]
                    }, function (chart) {
                        $('.highcharts-range-selector-buttons text:first').css({ 'display': 'none' });

                        $(document).on('click', '.highcharts-range-input', function(e) {
                            e.preventDefault();
                        });
                    });
                }
            });
        }());
    </script>

</head>
<body>
    <div class='container' style='padding: 50px;'>
        <div id='chart'></div>
    </div>
</body>
</html>