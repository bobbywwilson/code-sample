<!DOCTYPE html>
<html lang="en">
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

    <script src="{{ asset(elixir('js/mobile/app.js')) }}"></script>

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-xVVam1KS4+Qt2OrFa+VdRUoXygyKIuNWUUUBZYv+n27STsJ7oDOHJgfF0bNKLMJF" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{{ asset(elixir('css/mobile/materialize.css')) }}"> --}}
    
    <script src="{{ asset(elixir('js/timeago.js')) }}"></script>

    <link rel="stylesheet" href="{{ asset(elixir('css/mobile/all.css')) }}">

</head>

<body>
    <nav id="navbar">
        <div class="row">
            <div class="col s2 left-align no-padding">
                <i data-target="slide-out-menu" class="sidenav-trigger fal fa-bars black-contrast-text" id="menu-open-mobile"></i>
                <i class="fal fa-angle-left black-contrast-text hide" id="menu-close-mobile"></i>
            </div>
            <div class="col s8 center-align">
                <span class="logo-image uppercase">Bracket Order</span>
            </div>
            <div class="col s2 right-align padding-right">
                <i data-target="slide-out-search" class="sidenav-trigger fal fa-search nav-search" id="search-open-mobile"></i>
            </div>
        </div>
    </nav>

    <main>
        <div class="sidenav slide-out-menu" id="slide-out-menu">
            @include('mobile.partials.side-navs.menu')
        </div>
        <div class="sidenav slide-out-search" id="slide-out-search">
            @include('mobile.partials.side-navs.search')
        </div>
        @yield('content')
    </main>

    <footer class="page-footer">
        <div class="footer-copyright">
            <div class="center-align container">
                Copyright <i class="far fa-copyright"></i> {{ config('app.copyright') }} bracketorder.com. All rights reserved.
            </div>
        </div>
    </footer>

    <div class="modal" id="modal"><!-- Place at bottom of page --></div>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url: 'https://bracketorder.com/bracketorder-api/api/symbols',
                success: function(response) {
                    let symbolsArray = response;
                    let symbols = {};
                    for (let i = 0; i < symbolsArray.length; i++) {
                        symbols[symbolsArray[i].text] = null;
                    }
                    $('input.autocomplete').autocomplete({
                        data: symbols,
                        onAutocomplete: function(text) {
                            $('#bracketorder-form').submit();
                        },
                        limit: 10,
                    });
                }
            });
        });

        $(document).on('click', '.fal.fa-search', function(e) {
            if($('#bracket-quote-input').val() === "") {
                $('input.autocomplete').val('').focus();
                $('input.autocomplete').val('').get(0).setSelectionRange(0,0);
            }
        });
    </script>        
</body>
</html>