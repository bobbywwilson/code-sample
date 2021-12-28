<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bracket Order | Login</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.1/js/materialize.js"></script>

    <script src="{{ asset(elixir('js/app-login.js')) }}"></script>

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

    <link rel="stylesheet" href="{{ asset(elixir('css/app-desktop.css')) }}">
    <link rel="stylesheet" href="{{ asset(elixir('css/mobile-all.css')) }}">

</head>
<body>
<div class="header-menu">
    <nav id="top-nav">
        <div class="row header-menu-buttons">
            <div class="col s4 m4 left-align" id="nav-avatar"></div>
            <div class="col s4 m4 center-align" id="logo-image">
                <span class="logo-image uppercase" id="logo-image-span">Bracket Order</span>
            </div>
            <div class="col s4 m4 right-align" id="nav-menu-i">
                <a href="/"><i data-target="slide-out" class="right sidenav-trigger fas fa-bars black-contrast-text" id="menu-open-login"></i></a>
                <a href="/"><i data-target="slide-out" class="right sidenav-trigger fas fa-times black-contrast-text close-nav hide" id="menu-close-login"></i></a>
            </div>
        </div>
    </nav>
</div>

<main>
    <ul id="slide-out" class="sidenav">
        <li><a><i class="fas fa-home"></i>Home</a></li>
        <li class="sidenav-text-indent"><a>About</a></li>
        <li><a><i class="fas fa-file-invoice-dollar"></i>Create a Trading Strategy</a></li>
        <li><a><i class="fas fa-brain"></i>Bracket Order Methodology</a></li>
        <li><a><i class="far fa-compass"></i>Bracket Order Accuracy</a></li>

        <li>
            <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i>Login</a>
        </li>

        <li>
            <a href="{{ route('register') }}"><i class="fas fa-user-plus"></i>Subscribe</a>
        </li>
    </ul>
    @yield('content')
</main>

<footer class="page-footer">

    <div class="footer-copyright">
        <div class="container">
            Copyright <i class="far fa-copyright"></i> {{ config('app.copyright') }} Bracket Order. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
