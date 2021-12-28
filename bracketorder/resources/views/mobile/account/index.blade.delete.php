<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bracket Order | Account</title>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    {{--<script src="https://code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.js" id="jquery-mobile"></script>--}}

    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/indicators/indicators.js"></script>
    <script src="https://code.highcharts.com/stock/indicators/bollinger-bands.js"></script>
    <script src="https://code.highcharts.com/stock/indicators/ema.js"></script>
    <script src="https://code.highcharts.com/stock/indicators/macd.src.js"></script>
    <script src="https://code.highcharts.com/stock/indicators/rsi.js"></script>
    <script src="https://code.highcharts.com/stock/indicators/stochastic.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data-2012-2022.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">

    {{--<link rel="stylesheet" href="{{ asset(elixir('css/app-desktop.css')) }}">--}}
    {{--<link rel="stylesheet" href="{{ asset(elixir('css/mobile-all.css')) }}">--}}

    <style>
        body {
            font-family: sans-serif;
            background-color: rgba(0, 0, 0, 1);
        }
        main {
            background-color: rgba(0, 0, 0, 1);
            position: relative;
            top: 35px;
            margin-bottom: 56px;
            scroll-behavior: unset;
            overflow: -moz-scrollbars-none;
            -ms-overflow-style: none;
        }
        main::-webkit-scrollbar {
            width: 0 !important;
        }
        nav {
            color: #fff;
            background-color: rgb(14, 17, 17);
            width: 100%;
            height: 40px;
            line-height: 56px;
            position: fixed;
            top: 0;
            transition: top 0.5s;
            z-index: 9;
        }
        nav .row , nav .col {
            height: 40px;
        }
        nav .sidenav-trigger {
            float: left;
            position: relative;
            z-index: 1;
            height: 24px;
            margin: 5px 10px;
            font-size: 20px;
            position: relative;
            top: 5px;
            left 0;
        }
        nav .nav-search {
            height: 24px;
            margin: 5px 10px;
            font-size: 20px;
            position: relative;
            bottom: 5px;
            left: 3px;
        }
        .logo-image {
            font-size: 15px;
            font-weight: 700;
            position: relative;
            top: -7px;
        }
        .card {
            border-radius: 0;
            background-color: rgb(14, 17, 17);
            color: #ffffff;
            /* color: #fff;
            background-color: rgba(19, 19, 19, 1);
            width: 100%;
            height: 40px;
            line-height: 56px;
            position: relative;
            top: 41px;
            transition: top 0.5s;
            z-index: 9; */
            /* margin: .5rem -10px 1rem -10px !important; */
        }
        .card i {
            /* height: 24px;
            margin: 5px 10px;
            font-size: 15px;
            position: relative;
            left: 5px;
            top: 10px;
            float: right; */
        }
        .card .card-content {
            padding: 10px 10px;
        }
        .card-image {
            position: relative;
            padding: 5px 0;
            border-bottom: 1px solid rgba(160, 160, 160, 0.2);
            height: 40px;
        }
        .card .card-action {
            padding: 20px 24px;
        }
        .page-footer {
            color: #fff;
            background-color: rgb(14, 17, 17);
            padding: 0;
        }
        #chart {
            height: 750px;
            padding: 0;
        }
        #chart-card {
            /* color: #ffffff;
            padding: 10px 10px; */
        }

        .highcharts-scrollbar {
            display: none;
        }
        .page-footer .footer-copyright {
            font-size: 95%;
            padding: 10px 15px;
            background-color: rgb(14, 17, 17);
            color: rgba(255, 255, 255, 1);
        }
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            color: rgba(255, 255, 255, 1);
            background-color: #000;
            padding: 10px 0;
            overflow: hidden !important;
            border-top: 1px solid rgb(14, 17, 17);
        }
        
        h5 {
            font-size: 1.25em;
            font-weight: bolder;
            margin-left: 10px;
            margin-top: 3px;
        }
        h6 {
            position: relative;
            left: 3px;
            margin: 0;
            font-size: 15px;
            font-weight: 400;
            font-family: 'Open Sans', sans-serif;
        }
        .red-indicator {
            color: #b71c1c;
        }
        .green-indicator {
            color: #b71c1c;
        }
        .grey-indicator {
            color: #bdbdbd;
            font-size: 85%;
            line-height: 1.70em;
        }
        .yellow-indicator {
            color: #f57f17;
        }
        .margin-bottom-15 {
            margin-bottom: 15px;
        }
        .margin-bottom-10 {
            margin-bottom: 10px;
        }
        .no-padding {
            padding-left: 0;
            padding-right: 0;
        }
        .no-padding-top {
            padding-top: 0 !important;
        }
        .no-padding-bottom {
            padding-bottom: 0 !important;
        }
        .no-padding-right {
            padding-right: 0 !important;
        }
        .no-padding-left {
            padding-left: 0 !important;
        }
      


        #menu-news-row-story > p {
            /* text-indent: 25px; */
        }
        .big-first::first-letter {
            display: block;
            float: left;
            margin-top: -13px;
            padding-right: 6px;
            font-size: 50px;
            font-weight: bolder;
        }
        #menu-news-row-story > h6 {
            margin: 15px 0 30px;
        }
        .content-description {
            font-size: 12px;
            color: #86888b;
            position: relative;
            bottom: 1px;
        }
        td, th {
            padding-left: 1px;
            padding-right: 1px;
        }
        .sidenav img {
            width: 100%;
            border-radius: 3px;
        }
        .carousel img {
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: auto;
            z-index: -1;
            border-radius: 3px 3px 0 0;
        }

        * {
            box-sizing: border-box;
        }

        
        .carousel {
            height: auto;
        }

        .news-carousel-cell {
            background-color: #ffffff;
            border-radius: 3px 3px 0 0 !important;
        }

        .technicals-carousel-cell {
            /* background-color: #fafafa; */
            width: 90% !important;
            height: 145px !important;
            border: 1px solid #eeeeee;
        }

        .carousel-cell {
            width: 90%;
            height: 250px;
            margin-right: 10px;
            border-radius: 3px;
        }

        /* cell number */
        /* .carousel-cell:before {
            display: block;
            text-align: center;
            line-height: 200px;
            font-size: 80px;
            color: white;
        } */

        .news-details {
            position: relative;
            top: 62%;
            height: 95px;
            background-image: linear-gradient(rgba(33, 33, 33, .4), rgb(33, 33, 33) 20%);
            padding-top: 15px;
            border-bottom-left-radius: 3px;
            border-bottom-right-radius: 3px;
        }
        .news-details-sidenav {
            position: relative;
            margin-top: -25px;
            height: 95px;
            background-image: linear-gradient(rgba(33, 33, 33, .4), rgb(33, 33, 33) 20%);
            padding-top: 15px;
            border-bottom-left-radius: 3px;
            border-bottom-right-radius: 3px;
        }
        .news-details h5, .news-details-sidenav h5 {
            position: relative;
            top: 5px;
            font-size: 14px;
            font-weight: bolder;
            line-height: 1.3;
            color: #ffffff;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            width: 94%;
            overflow: hidden;
        }

        .news-details-white-text {
            color: #ffffff;
        }

        .news-details .content-description, .news-details-sidenav .content-description {
            left: 5px;
            bottom: 0;
        }

        .initial-float-i {
            position: absolute;
            bottom: 10px;
            right: 0 !important;
        }

        .news-details-i {
            float: right;
            color: #ffffff;
        }

        .position-bottom {
            position: absolute;
            bottom: 10px;
        }

        
        .container {
            margin: 0 auto;
            max-width: 1280px;
            width: 100%;
        }
        .initial-float {
            float: initial !important;
        }
        
        .logo-image-small {
            font-size: 15px;
            font-weight: 700;
        }
        .uppercase {
            text-transform: uppercase;
        }
        
        
        #navbar-menu {
            color: #fff;
            background-color: #000000;
            width: 100%;
            height: 56px;
            line-height: 56px;
            position: fixed;
            z-index: 9;
        }
        #navbar-scroll {
            height: 56px;
            transition: hide 0.5s;
        }
        #navbar-scroll-row {
            width: 98%;
        }
        #bracket-quote-input {
            width: 100%;
            height: 45px;
            /*border: 1px solid rgba(160, 160, 160, 0.2);*/
            border: 1px solid #000000;
            -webkit-appearance: none;
            border-radius: 3px;
        }
        #bracket-quote-input-scroll {
            width: 100%;
            height: 35px;
            /*border: 1px solid rgba(160, 160, 160, 0.2);*/
            border: 1px solid #000000;
            -webkit-appearance: none;
            border-radius: 3px;
        }
        #search-icon-scroll {
            top: 11px !important;
        }
        .btn-floating.halfway-fab {
            position: absolute;
            right: 10px;
            bottom: -20px;
        }
        

        .no-margin-bottom {
            margin-bottom: 0;
        }
        .mobile-card-table td, th {
            width: 33.33%;
        }
        

        #i-profile {
            position: relative;
            bottom: 12px;
            left: 10px;
        }
        
        
        .padding-right {
            padding-right: 5px !important;
        }
        
        input[type="text"] {
            width: 100%;
            border: 2px solid #aaa;
            border-radius: 3px;
            margin: 8px 0;
            outline: none;
            padding: 8px;
            box-sizing: border-box;
            transition: 0.3s;
        }
        /*input[type="text"]:focus {
          border-color: dodgerBlue;
          box-shadow: 0 0 8px 0 dodgerBlue;
        }*/
        .inputWithIcon input[type="text"] {
            padding-left: 45px;
        }
        .inputWithIcon {
            position: relative;
            width: 100%;
        }
        .inputWithIcon i {
            position: absolute;
            left: 20px;
            top: 15px;
            padding: 9px 8px;
            color: #aaa;
            transition: 0.3s;
            font-size: 20px;
        }
        /*Color of underline*/
        .no-padding-left-right {
            padding-left: 0;
            padding-right: 0;
        }
        
        

        /*This is already in the responsive css*/

        
        .no-border-bottom {
            border-bottom: 0;
        }

        span.badge.new  {
            float: left;
            margin-left: 10px;
            width: 110px;
        }

        #news {
            padding-right: 0;
        }

        #technicals {
            padding-right: 0;
        }

        /*** Styles added to fix the issue with zoom in on iphone ***/
        /* iPhone < 5: */
        @media screen and (device-aspect-ratio: 2/3) {
            select, textarea, input[type="text"], input[type="password"],
            input[type="datetime"], input[type="datetime-local"],
            input[type="date"], input[type="month"], input[type="time"],
            input[type="week"], input[type="number"], input[type="email"],
            input[type="url"]{ font-size: 16px; }
        }

        /* iPhone 5, 5C, 5S, iPod Touch 5g */
        @media screen and (device-aspect-ratio: 40/71) {
            select, textarea, input[type="text"], input[type="password"],
            input[type="datetime"], input[type="datetime-local"],
            input[type="date"], input[type="month"], input[type="time"],
            input[type="week"], input[type="number"], input[type="email"],
            input[type="url"]{ font-size: 16px; }
        }

        /* iPhone 6, iPhone 6s, iPhone 7 portrait/landscape */
        @media screen and (device-aspect-ratio: 375/667) {
            select, textarea, input[type="text"], input[type="password"],
            input[type="datetime"], input[type="datetime-local"],
            input[type="date"], input[type="month"], input[type="time"],
            input[type="week"], input[type="number"], input[type="email"],
            input[type="url"]{ font-size: 16px; }
        }

        /* iPhone 6 Plus, iPhone 6s Plus, iPhone 7 Plus portrait/landscape */
        @media screen and (device-aspect-ratio: 9/16) {
            select, textarea, input[type="text"], input[type="password"],
            input[type="datetime"], input[type="datetime-local"],
            input[type="date"], input[type="month"], input[type="time"],
            input[type="week"], input[type="number"], input[type="email"],
            input[type="url"]{ font-size: 16px; }
        }
        /* iPhone 8, iPhone X portrait/landscape */
        @media screen and (device-aspect-ratio: 414/736) {
            select, textarea, input[type="text"], input[type="password"],
            input[type="datetime"], input[type="datetime-local"],
            input[type="date"], input[type="month"], input[type="time"],
            input[type="week"], input[type="number"], input[type="email"],
            input[type="url"]{ font-size: 16px; }
        }

        /* iPhone 8, iPhone X portrait/landscape */
        @media screen and (device-aspect-ratio: 9/19.5) {
            select, textarea, input[type="text"], input[type="password"],
            input[type="datetime"], input[type="datetime-local"],
            input[type="date"], input[type="month"], input[type="time"],
            input[type="week"], input[type="number"], input[type="email"],
            input[type="url"]{ font-size: 16px; }
        }

        .padding-right-only {
            padding: 0 0 0 5px !important;
        }

        .margin-top-spacing {
            position: relative;
            top: 5px;
        }

        .border {
            border: 1px solid red;
        }

        .flex-container {
            display: flex;
            width: 100%;
            justify-content: space-evenly;
        }

        .justify-content-none {
            justify-content: normal !important;
        }

        .flex-container > div {
            margin: 5px;
            padding: 5px 0 0;
            font-size: 11.5px;
            width: 33%;
            border: 0 solid #212121;
            border-radius: 3px;
        }

        .equal-spacing {
            width: 50% !important;
        }

        .flex-container > div p {
            padding-left: 5px;
            padding-bottom: 5px;
        }

        .indicator-name.border-top-only {
            padding-top: 5px;
            background-color: #ffffff;
            border: 1px solid #bdbdbd;
            border-top-left-radius: 2px;
            border-top-right-radius: 2px;
            border-bottom: 0;
            color: #000000;
        }

        .indicator-value.border-top-only {
            padding-top: 5px;
            background-color: #212121;
            border: 1px solid #212121;
            border-top: 0;
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
            color: #ffffff;
        }

        .margin-left-spacing {
            margin-left: 10px !important;
        }

        .margin-right-spacing {
            margin-right: 10px !important;
        }
        .sidenav {
            width: 100%;
        }
        .menu-close-mobile {
            position: relative;
            z-index: 1;
            height: 24px;
            margin: 15px 10px;
            font-size: 18px;
            width: 50%;
        }
        #menu-icons {
            
        }
        .menu-icon-font-size {
            font-size: 40px;
        }
        .menu-icon-link, .menu-icon-link:active, .menu-icon-link:visited, .menu-icon-link:hover {
            color: #000;
        }
        .green-indicator {
            color: #00e676;
        }
        #menu-user-row {
            position: relative;
            top: 62px;
            border: 1px solid #eeeeee;
            border-radius: 3px;
            background-color: #fafafa;
            padding: 0 10px;
            /* margin-left: 5px;
            margin-right: 5px; */
        }
        #menu-news-row {
            position: relative;
            top: 62px;
            border: 0 solid #eeeeee;
            border-radius: 3px;
            background-color: #fff;
            padding: 10px 0 100px !important;
            margin-left: 5px;
            margin-right: 5px;
        }
        #menu-news-row-story {
            position: relative;
            top: 10px;
            border: 1px solid #eeeeee;
            border-radius: 3px;
            background-color: #fafafa;
            padding-top: 10px;
            padding-bottom: 50px !important;
        }
        #menu-icon-row {
            position: relative;
            top: 55px;
            border: 1px solid #eeeeee;
            border-radius: 3px;
            background-color: #fafafa;
            padding: 15px 0;
            /* margin-left: 5px;
            margin-right: 5px; */
        }
        .small-text {
            font-size: 14px;
            position: relative;
            right: 7px;
            bottom: 2px
        }
        #menu-open-mobile-logo {
            font-size: 18px;
            font-weight: bolder;
            position: relative;
            bottom: 21px;
        }
        #menu-open-mobile-logo-scroll {
            font-size: 18px;
            font-weight: bolder;
            position: relative;
            bottom: 21px;
        }
        #i-menu {
            position: relative;
            top: 5px;
            line-height: 0;
            height: 20px;
        }
        .menu-brackets {
            height: 10px;
        }
        #menu-open-mobile-logo-menu {
            font-size: 13px;
            font-weight: bolder;
            position: relative;
            bottom: 2px;
        }
        .border-radius {
            border-radius: 3px;
        }
        /*#symbol-lookup {*/
            /*width: 100%;*/
            /*height: 0;*/
            /*overflow: hidden;*/
            /*-webkit-transition: all 0.2s linear;*/
            /*-moz-transition: all 0.2s linear;*/
            /*-o-transition: all 0.2s linear;*/
            /*transition: all 0.2s linear;*/
            /*!*margin-top:331px;*!*/
        /*}*/
        /*.scroll-input:hover, #symbol-lookup {*/
            /*margin-top: 0;*/
            /*height: 500px;*/
        /*}*/
    </style>

    <script>
        $(document).ready(function() {
        
            $('.slide-out-menu').sidenav({
                draggable: false,
                preventScrolling: true,
                edge: 'right'
            });
        });
    </script>
</head>

<body>
    <nav id="navbar">
        <div class="row">
            <div class="col s2 left-align no-padding">
                <i class="fas fa-search nav-search"></i>
            </div>
            <div class="col s8 center-align">
                <span class="logo-image uppercase">Bracket Order</span>
            </div>
            <div class="col s2 right-align padding-right">
                {{-- <a href="/"><span data-target="slide-out" class="right sidenav-trigger black-contrast-text" id="menu-open-mobile-logo"><i class="material-icons"><span class="menu-brackets">[</span><span id="i-menu">more_horiz</span><span class="menu-brackets">]</span></i></span></a> --}}
                <a href="/"><i data-target="slide-out" class="right sidenav-trigger fas fa-bars black-contrast-text" id="menu-open-mobile"></i></a>
            </div>
        </div>
    </nav>

    {{-- <div class="" id="symbol-lookup"></div> --}}

    <main>
    
        <div class="container">
            <div class="card">
                
                <div class="card-content" id="chart-card">
                    <div class="col s12 margin-bottom-15">
                        <h6>AAPL US Equity</h6>
                    </div>
                    <div class="row">
                        
                        <div class="col s12 no-padding-left" id="chart"></div>
                    </div>
                </div>

                {{-- <div class="card-action bracket-profile">
                    <span class="grey-text text-darken-4"><i class="material-icons right" id="i-profile">more_horiz</i></span>
                </div> --}}
            </div>
        </div>

    </main>

    

<script>
    $(document).ready(function() {

        let prevScrollpos = window.pageYOffset;

        window.onscroll = function() {
            let currentScrollPos = window.pageYOffset;
            if (prevScrollpos < 70) {
                $("#navbar").css("top", "0px");
                $("#navbar-scroll").addClass("hide").slideUp();
                $(".no-scroll-input").removeClass("hide").removeAttr("disabled");
                $(".scroll-input").removeClass("hide").attr("disabled", "disabled");
            } else {
                $("#navbar").css("top", "-56px");
                $("#navbar-scroll").removeClass("hide").slideDown();
                $(".scroll-input").removeClass("hide").removeAttr("disabled");
                $(".no-scroll-input").addClass("hide").attr("disabled", "disabled");
            }
            prevScrollpos = currentScrollPos;
        };

        Highcharts.theme = {
            colors: ['#2b908f', '#90ee7e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066',
                '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
            chart: {
                backgroundColor: 'rgb(14, 17, 17)',
                style: {
                    fontFamily: 'sans-serif'
                },
                marginRight: 30,
                marginLeft: 0
            },

            // scroll charts
            rangeSelector: {
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
                x: -36
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
                                selected: 1,
                                buttonTheme: { // styles for the buttons
                                    width: 42,
                                    height: 15,
                                    padding: 10
                                },
                                x: -40,
                                y: -43
                            },
                            yAxis: {
                                lineWidth: 1,
                                labels: {
                                    x: 30,
                                    y: 3
                                }
                            },
                            chart: {
                                marginLeft: 3,
                                marginTop: 60
                            },
                        }
                    }]
                },

            navigator: {
                enabled: false
            }
        };

        // Apply the theme
        Highcharts.setOptions(Highcharts.theme);

        (function () {

            let ticker_symbol;

            if ($('#bracketorder_symbol').val()) {
                ticker_symbol = $('#bracketorder_symbol').val();
            } else {
                ticker_symbol = "aapl.us";
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
                        bb = [],
                        macd = [],
                        rsi = [],
                        stochastic = [],
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

                        currentPriceLine.push([
                            data[i][4] // close
                        ]);
                    }
                    console.log(currentPriceLine[currentPriceLine.length - 1] + 20);
                    let removeLast = currentPriceLine.pop();
                    let changeDirection = removeLast[0] - currentPriceLine[currentPriceLine.length - 1][0];

                    Highcharts.stockChart('chart', {
                        xAxis: {
                            lineWidth: 1,
                            offset: 60,
                            lineColor: 'rgba(160, 160, 160, 0.2)',
                            crosshair: true,
                            tickWidth: 0,
                            gridLineWidth: 0
                        },
                        yAxis: [{
                            height: 200,
                            endOnTick: true,
                            showLastLabel: true,
                            showFirstLabel: true,
                            startOnTick: false,
                            lineWidth: 2,
                            lineColor: 'rgba(160, 160, 160, 0.2)',
                            crosshair: true,
                            labels: {
                                x: 30,
                                y: 3
                            },
                            resize: {
                                enabled: true
                            },
                            gridLineWidth: 2,
                            gridLineColor: 'rgba(160, 160, 160, 0.2)'
                        }, {
                            top: 300,
                            height: 100,
                            lineWidth: 3,
                            lineColor: '#212121',
                            labels: {
                                x: 20,
                                y: 3,
                                style: {
                                    color: '#707073',
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
                                
                            }
                        },
                        legend: {
                            
                        },
                        credits: {
                            enabled: false
                        },
                        tooltip: {
                            enabledIndicators: true,
                            valueDecimals: 2,
                            xDateFormat: '%B %d, %Y %l:%M %p',
                            shared: true
                        },
                        labels: {
                            style: {
                                color: '#707073'
                            }
                        },
            
                        rangeSelector: {
                            selected: 1
                        },

                        series: [{
                            id: ticker_symbol.trim(),
                            name: series_name.toUpperCase(),
                            data: ohlc,
                            type: 'area',
                            threshold: null,
                            lineColor: 'rgb(13, 71, 161)',
                            fillColor: 'rgba(13, 71, 161, .5)'
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

                    }, function (chart) {
                        $('.highcharts-range-selector-buttons text:first').css('display', 'none');
                        $('.highcharts-input-group').css('display', 'none');
                        $('.highcharts-range-selector-group').css({'positon': 'relative', 'left': '150px'});

                        if ($(window).width() <= 667){

                            chart.renderer.text('MACD (12, 26)', 5, 285)
                                .attr({
                                    rotation: 0
                                })
                                .css({
                                    color: '#707073',
                                    fontSize: '12px'
                                })
                                .add();
                        } else {
                            
                            chart.renderer.text('MACD (12, 26)', 5, 305)
                                .attr({
                                    rotation: 0
                                })
                                .css({
                                    color: '#707073',
                                    fontSize: '12px'
                                })
                                .add();
                        }
                    });
                }
            });
        }());

    });
</script>
</body>
</html>