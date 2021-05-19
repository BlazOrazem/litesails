<?php
    function isPage($name = 'index') {
        echo strpos($_SERVER['REQUEST_URI'], $name) ? 'active' : '';
    }
?>

<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand navbar-image" href="/">
                <img src="/images/favicon.png">
                Lite Sails
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown <?= isPage('index') ?>">
                    <a href="#"
                       class="dropdown-toggle"
                       data-toggle="dropdown"
                       role="button"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Wind forecast <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Select an area</li>
                        <li><a href="/?map=adriatic" class="wind-map" data-map="adriatic">Adriatic</a></li>
                        <li><a href="/?map=north-adriatic" class="wind-map" data-map="north-adriatic">North Adriatic</a></li>
                        <li><a href="/?map=middle-adriatic" class="wind-map" data-map="middle-adriatic">Middle Adriatic</a></li>
                        <li><a href="/?map=south-adriatic" class="wind-map" data-map="south-adriatic">South Adriatic</a></li>
                    </ul>
                </li>
                <li class="<?= isPage('weather') ?>">
                    <a href="/weather">Weather forecast</a>
                </li>
                <li class="<?= isPage('sea') ?>">
                    <a href="/sea">Sea forecast</a>
                </li>
                <li class="<?= isPage('winds') ?>">
                    <a href="/winds">Adriatic winds</a>
                </li>
                <li class="<?= isPage('knots') ?>">
                    <a href="https://www.animatedknots.com/boating-knots" target="_blank">Nautical knots</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
