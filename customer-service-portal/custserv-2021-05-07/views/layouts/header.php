<!DOCTYPE html>
<html>
<head>
<title><?php echo $page; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="<?php echo constant("ABSOLUTE_PATH") . 'assets/css/style.css'; ?>">
<link rel="stylesheet" href="<?php echo constant("ABSOLUTE_PATH") . 'assets/css/stylesheet.css'; ?>">
<link rel="stylesheet" href="<?php echo constant("ABSOLUTE_PATH") . 'assets/css/responsive.css'; ?>">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" id="main-nav">
        <a class="navbar-brand navbar-logo-position" href="#">
            <img src="<?php echo constant("ABSOLUTE_PATH") . 'assets/images/jdr-logo.png'; ?>" alt="JDR Logo" class="logo-image">
        </a>
        <button class="navbar-toggler" type="button" id="mobile-menu-button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-close close hide" id="close-menu"><i class="fas fa-times"></i></span>
            <span class="navbar-toggler-icon" id="open-menu"></span>
        </button>

        <div class="collapse navbar-collapse" id="main-navbar">
            <ul class="navbar-nav" id="right-nav">
                <li class="nav-item">
                    <a class="nav-link medium-link nav-menu-link" href="#">Customer Lookups</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link medium-link nav-menu-link" href="/logout">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="main-content">