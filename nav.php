<?php
    function isPage($name = 'index') {
        echo str_contains($_SERVER['REQUEST_URI'], $name) ? 'active' : '';
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
                <img src="/images/favicon.svg" alt="Lite Sails">
                Lite Sails
            </a>
            <button type="button" id="js-theme-toggle" class="theme-toggle" aria-label="Toggle dark mode" title="Toggle dark mode">
                <svg class="theme-toggle__moon" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                <svg class="theme-toggle__sun" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"></path></svg>
            </button>
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
                    <a href="https://www.animatedknots.com/boating-knots" target="_blank" rel="noopener noreferrer">Nautical knots</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
