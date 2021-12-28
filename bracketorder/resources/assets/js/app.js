
let series_name;
let ticker_symbol;

$(document).on('click', '#ellipse-menu-bracket', function(e) {
    $(".normal-height").addClass('card-height');
});

$(document).on('click', '#news-tab', function(e) {
    // $("#chart").css('height', '930px');
});

$(document).on('click', '#more-info-x-bracket', function(e) {
    $(".normal-height").removeClass('card-height');
});

$(document).on('click', '#ellipse-menu-chart', function(e) {
    $("#sma-color-1-button").removeClass('ui-selectmenu-button ui-corner-all ui-shadow ui-button ui-button-inherit');
    $("#sma-color-2-button").removeClass('ui-selectmenu-button ui-corner-all ui-shadow ui-button ui-button-inherit');
    $("#sma-color-3-button").removeClass('ui-selectmenu-button ui-corner-all ui-shadow ui-button ui-button-inherit');
    $("#indicators-button").removeClass('ui-selectmenu-button ui-corner-all ui-shadow ui-button ui-button-inherit');
});

$(document).on('click', '#more-info-x-chart', function(e) {
    $(".normal-height-chart").removeClass('card-height-indicators');
});

$(document).ready(function() {

    let $body = $("body");
    let user_id = $('#user_id_bracket').val();
    ticker_symbol = 'gspc.indx';

    if ($(window).width() > 667){
        $('#bracketorder_symbol').unwrap();
    }

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
        type: 'GET',
        success: function (data) {
            $data = $(data);

            if (data['study'] === "bollinger_bands") {
                $.getScript("./js/bollinger-bands-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "macd") {
                $.getScript("./js/macd-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if (data['study'] === "rsi") {
                $.getScript("./js/rsi-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "stochastic_fast") {
                $.getScript("./js/stochastic-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "bollinger_bands,macd,rsi,stochastic_fast") {
                $.getScript("./js/bmrs-chart.js", function() {
                    $('#chart').css('height', '837px');
                });
            } else if(data['study'] === "bollinger_bands,macd,rsi") {
                $.getScript("./js/bmr-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "bollinger_bands,macd") {
                $.getScript("./js/bm-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "bollinger_bands,rsi,stochastic_fast") {
                $.getScript("./js/brs-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "bollinger_bands,stochastic_fast") {
                $.getScript("./js/bs-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "bollinger_bands,rsi") {
                $.getScript("./js/br-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "macd,rsi,stochastic_fast") {
                $.getScript("./js/mrs-chart.js", function() {
                    $('#chart').css('height', '837px');
                });
            } else if(data['study'] === "macd,rsi") {
                $.getScript("./js/mr-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "macd,stochastic_fast") {
                $.getScript("./js/ms-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "rsi,stochastic_fast") {
                $.getScript("./js/rs-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if (data['study'] === "default_chart") {
                $.getScript("./js/bmrs-chart.js", function() {
                    $('#chart').css('height', '837px');
                });
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

    $.ajax({
        url: '/account/stock-news?ticker_symbol=' + ticker_symbol.split('.').shift().trim(),
        type: "GET", // not POST, laravel won't allow it
        success: function (data) {
            $data = $(data);
            $('#news-tables').html($data);
        }
    });

    $(window).resize(function(){

    });

    $('.tabs').tabs();

    $('select').formSelect();

    $('.collapsible').collapsible();

    $('.sidenav').sidenav({
        draggable: false,
        preventScrolling: true
    });

    $('#slide-out').sidenav({
        draggable: false,
        preventScrolling: true
    });

    $('#slide-out-login').sidenav({
        draggable: false,
        preventScrolling: true
    });

    $('#slide-out-desktop').sidenav({
        draggable: false,
        preventScrolling: true
    }).removeClass('hide');

    $("#bracketorder_symbol").keyup(function(){
        if($("#bracketorder_symbol").val() === "") {
            $('#go-button').removeClass('hide');
            $('#clear-button').addClass('hide');
        }
    });

    $('#periods-sma-1').click(function() {
        $('#periods-sma-1-label').addClass('active');
    });
    $('#periods-sma-2').click(function() {
        $('#periods-sma-2-label').addClass('active');
    });
    $('#periods-sma-3').click(function() {
        $('#periods-sma-3-label').addClass('active');
    });

    $('#clear-button').click(function() {
        $('#bracketorder_symbol').val("").focus();
        $('#go-button').removeClass('hide');
        $('#clear-button').addClass('hide');
        // $('#bracketorder_symbol_label').removeClass('active');
    });

    $('.market-data').click(function() {
        if($('#market-data-open').hasClass('active')) {
            $('.market-data-chevron-up').addClass('hide');
            $('.market-data-chevron-down').removeClass('hide');
        }

        if($('#market-data-open').hasClass('')) {
            $('.market-data-chevron-up').removeClass('hide');
            $('.market-data-chevron-down').addClass('hide');
        }
    });

    $('.news-sections').click(function() {
        if($('#news-sections-open').hasClass('active')) {
            $('.news-sections-chevron-up').addClass('hide');
            $('.news-sections-chevron-down').removeClass('hide');
        }

        if ($('#news-sections-open').hasClass('')) {
            $('.news-sections-chevron-up').removeClass('hide');
            $('.news-sections-chevron-down').addClass('hide');
        }
    });

    $('#edit-start, #edit-start-desktop').click(function() {
        $('.delete-action').removeClass('hide');
        $('.delete-buttons .delete-action').removeClass('hide');
        $('#edit-done').removeClass('hide');
        $('#edit-start').addClass('hide');
        $('#edit-done-desktop').removeClass('hide');
        $('#edit-start-desktop').addClass('hide');
    });

    $('#edit-done, #edit-done-desktop').click(function() {
        $('.delete-action').addClass('hide');
        $('.delete-buttons .delete-action').addClass('hide');
        $('#edit-done').addClass('hide');
        $('#edit-start').removeClass('hide');
        $('#edit-done-desktop').addClass('hide');
        $('#edit-start-desktop').removeClass('hide');
    });

    $('.fa-bars').click(function() {
        $('.fa-bars').addClass('hide');
        $('.close-nav').removeClass('hide');
        $(document.body).css('position','fixed');
    });

    $('#slide-out').click(function() {
        $('.fa-bars').addClass('hide');
        $('.close-nav').removeClass('hide');
        $(document.body).css('position','fixed');
    });

    $('.close-nav').click(function() {
        $('.fa-bars').removeClass('hide');
        $('.close-nav').addClass('hide');
        $(document.body).css('position','relative');
    });

    $('.close-news').click(function() {
        $('.fa-bars').addClass('hide');
        $('.close-nav').removeClass('hide');
        $(document.body).css('position','fixed');
    });

    $("#bracketorder_symbol").change(function() {
        $('#go-button').removeClass('hide');
        $('#clear-button').addClass('hide');
    });
});

$(document).on('click', '#menu-open-mobile', function(e) {
    $('body').css('position', 'relative');
});

$(document).on('submit', '#bracketorder-form', function(e) {
    e.preventDefault();
    ticker_symbol = $('#bracketorder_symbol').val();
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

    $.ajax({
        url: '/account/get-indicator',
        type: 'GET',
        success: function (data) {
            $data = $(data);

            if (data['study'] === "bollinger_bands") {
                $.getScript("./js/bollinger-bands-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "macd") {
                $.getScript("./js/macd-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if (data['study'] === "rsi") {
                $.getScript("./js/rsi-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "stochastic_fast") {
                $.getScript("./js/stochastic-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "bollinger_bands,macd,rsi,stochastic_fast") {
                $.getScript("./js/bmrs-chart.js", function() {
                    $('#chart').css('height', '837px');
                });
            } else if(data['study'] === "bollinger_bands,macd,rsi") {
                $.getScript("./js/bmr-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "bollinger_bands,macd") {
                $.getScript("./js/bm-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "bollinger_bands,rsi,stochastic_fast") {
                $.getScript("./js/brs-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "bollinger_bands,stochastic_fast") {
                $.getScript("./js/bs-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "bollinger_bands,rsi") {
                $.getScript("./js/br-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "macd,rsi,stochastic_fast") {
                $.getScript("./js/mrs-chart.js", function() {
                    $('#chart').css('height', '837px');
                });
            } else if(data['study'] === "macd,rsi") {
                $.getScript("./js/mr-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "macd,stochastic_fast") {
                $.getScript("./js/ms-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(data['study'] === "rsi,stochastic_fast") {
                $.getScript("./js/rs-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if (data['study'] === "default_chart") {
                $.getScript("./js/bmrs-chart.js", function() {
                    $('#chart').css('height', '837px');
                });
            }
        }
    });

    $.ajax({
        url: '/account/profile?ticker_symbol=' + ticker_symbol.trim(),
        type: "GET",
        success: function (data) {
            $data = $(data);
            $('#profile').html($data);
        }
    });

    if (stock_code[1] === "indx") {
        $.ajax({
            url: '/account/market-technicals?ticker_symbol=' + ticker_symbol.trim(),
            type: "GET",
            success: function (data) {
                $data = $(data);
                $('#technical-tables').html($data);
            }
        });
    } else {
        $.ajax({
            url: '/account/technicals?ticker_symbol=' + ticker_symbol.trim(),
            type: "GET",
            success: function (data) {
                $data = $(data);
                $('#technical-tables').html($data);
            }
        });
    }

    $.ajax({
        url: '/account/bracketorder?ticker_symbol=' + ticker_symbol.trim(),
        type: "GET",
        success: function (data) {
            $data = $(data);
            $('#bracketorder-quote').html($data);
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
        url: '/account/stock-quote?ticker_symbol=' + ticker_symbol.trim(),
        type: "GET",
        success: function (data) {
            $data = $(data);
            $('#chart-quote').html($data);
        }
    });

    $.ajax({
        url: '/account/stock-news?ticker_symbol=' + ticker_symbol.trim(),
        type: "GET", // not POST, laravel won't allow it
        success: function (data) {
            $data = $(data);
            $('#news-tables').html($data);
        }
    });

    $('.bracket-profile').removeClass('hide');

    if(ticker_symbol !== "") {
        $('#go-button').addClass('hide');
        $('#clear-button').removeClass('hide');
    }
});

$(document).on('click', '#save-watchlist, #save-watchlist-i', function(e) {
    e.preventDefault();
    let sector = $('#sector').val();
    let user_id = $('#user_id').val();
    ticker_symbol = $('#watchlist_ticker_symbol').val();

    $.ajax({
        url: '/account/add-to-watchlist?sector=' + sector.trim() + "&user_id=" + user_id.trim() + "&ticker_symbol=" + ticker_symbol.trim(),
        type: "GET",
        success: function (data) {
            $data = $(data);

            setTimeout(function() {
                let user_id = $('#user_id_bracket').val();
                $.ajax({
                    url: '/account/watchlist?user_id=' + user_id.trim(),
                    type: "GET",
                    success: function (data) {
                        $data = $(data);
                        $('#watchlist-tables').html($data);
                    }
                });
            }, 1000);
        }
    });
});

$(document).on('click', '#save-chart', function(e) {
    e.preventDefault();
    let indicators = $('select#indicators').val();

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

    let sma_1 = $('#sma-1').val();
    let sma_2 = $('#sma-2').val();
    let sma_3 = $('#sma-3').val();

    let sma_periods_1 = $('#periods-sma-1').val();
    let sma_periods_2 = $('#periods-sma-2').val();
    let sma_periods_3 = $('#periods-sma-3').val();

    let sma_color_1 = $('#sma-color-1').val();
    let sma_color_2 = $('#sma-color-2').val();
    let sma_color_3 = $('#sma-color-3').val();

    $.ajax({
        url: '/account/save-chart?indicator=' + indicators + "&sma_1=" + sma_1 + "&sma_2=" + sma_2 + "&sma_3=" + sma_3 + "&sma_periods_1=" + sma_periods_1  + "&sma_periods_2=" + sma_periods_2 + "&sma_periods_3=" + sma_periods_3 + "&sma_color_1=" + sma_color_1 + "&sma_color_2=" + sma_color_2  + "&sma_color_3=" + sma_color_3,
        type: "GET",
        success: function (data) {
            $data = $(data);

            if (indicators[0] === "bollinger_bands" && indicators.length === 1) {
                $.getScript("./js/bollinger-bands-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(indicators[0] === "macd" && indicators.length === 1) {
                $.getScript("./js/macd-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if (indicators[0] === "rsi" && indicators.length === 1) {
                $.getScript("./js/rsi-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(indicators[0] === "stochastic_fast" && indicators.length === 1) {
                $.getScript("./js/stochastic-chart.js", function() {
                    $('#chart').css('height', '750px');
                    // $('.chart-adjustments').css('height', '740px');
                });
            } else if(indicators[0] === "bollinger_bands" && indicators[1] === "macd" && indicators[2] === "rsi" && indicators[3] === "stochastic_fast"  && indicators.length === 4) {
                $.getScript("./js/bmrs-chart.js", function() {
                    $('#chart').css('height', '837px');
                });
            } else if(indicators[0] === "bollinger_bands" && indicators[1] === "macd" && indicators[2] === "rsi"  && indicators.length === 3) {
                $.getScript("./js/bmr-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(indicators[0] === "bollinger_bands" && indicators[1] === "macd" && indicators.length === 2) {
                $.getScript("./js/bm-chart.js", function() {
                    $('#chart').css('height', '750px');
                    // $('.chart-adjustments').css('height', '740px');
                });
            } else if(indicators[0] === "bollinger_bands" && indicators[1] === "rsi" && indicators[2] === "stochastic_fast"  && indicators.length === 3) {
                $.getScript("./js/brs-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(indicators[0] === "bollinger_bands" && indicators[1] === "stochastic_fast"  && indicators.length === 2) {
                $.getScript("./js/bs-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(indicators[0] === "bollinger_bands" && indicators[1] === "rsi"  && indicators.length === 2) {
                $.getScript("./js/br-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(indicators[0] === "macd" && indicators[1] === "rsi" && indicators[2] === "stochastic_fast" && indicators.length === 3) {
                $.getScript("./js/mrs-chart.js", function() {
                    $('#chart').css('height', '837px');
                });
            } else if(indicators[0] === "macd" && indicators[1] === "rsi" && indicators.length === 2) {
                $.getScript("./js/mr-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(indicators[0] === "macd" && indicators[1] === "stochastic_fast" && indicators.length === 2) {
                $.getScript("./js/ms-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(indicators[0] === "rsi" && indicators[1] === "stochastic_fast" && indicators.length === 2) {
                $.getScript("./js/rs-chart.js", function() {
                    $('#chart').css('height', '750px');
                });
            } else if(indicators[0] === "" || indicators[0] === "default_chart") {
                $.getScript("./js/bmrs-chart.js", function() {
                    $('#chart').css('height', '837px');
                });
            }

            $(".card-reveal").css('display', 'none');
        }
    });
});

$(document).mouseup(function(e){
    let lose_focus = $("#slide-out");

    let lose_focus_news = $(".close-news");

    let lose_focus_sma_1 = $('#periods-sma-1');

    let lose_focus_sma_2 = $('#periods-sma-2');

    let lose_focus_sma_3 = $('#periods-sma-3');

    if (!lose_focus.is(e.target) && lose_focus.has(e.target).length === 0) {
        $('#periods-sma-1-label').removeClass('active');
    }

    if (!lose_focus_news.is(e.target) && lose_focus_news.has(e.target).length === 0) {
        $('.fa-bars').removeClass('hide');
        $('.close-nav').addClass('hide');
        $(document.body).css('position','relative');
    }

    if (!lose_focus_sma_1.is(e.target) && lose_focus_sma_1.has(e.target).length === 0) {
        let is_empty = $('#periods-sma-1').hasClass('validate valid');
        if (is_empty) {
            $('#periods-sma-1-label').addClass('active');
        } else {
            $('#periods-sma-1-label').removeClass('active');
        }
    }

    if (!lose_focus_sma_2.is(e.target) && lose_focus_sma_2.has(e.target).length === 0) {
        let is_empty = $('#periods-sma-2').hasClass('validate valid');
        if (is_empty) {
            $('#periods-sma-2-label').addClass('active');
        } else {
            $('#periods-sma-2-label').removeClass('active');
        }
    }

    if (!lose_focus_sma_3.is(e.target) && lose_focus_sma_3.has(e.target).length === 0) {
        let is_empty = $('#periods-sma-3').hasClass('validate valid');
        if (is_empty) {
            $('#periods-sma-3-label').addClass('active');
        } else {
            $('#periods-sma-3-label').removeClass('active');
        }
    }
});
