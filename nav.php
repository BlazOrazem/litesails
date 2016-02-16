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
            <a class="navbar-brand" href="index.php">Lite Sails</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Wind <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Choose area</li>
                        <li><a href="index.php?map=kvarner" class="aladin-map" data-map="kvarner">Istra & Kvarner</a>
                        </li>
                        <li><a href="index.php?map=zadar" class="aladin-map" data-map="zadar">Zadar</a></li>
                        <li><a href="index.php?map=split" class="aladin-map" data-map="split">Split</a></li>
                        <li><a href="index.php?map=dubrovnik" class="aladin-map" data-map="dubrovnik">Dubrovnik</a></li>
                    </ul>
                </li>
                <li>
                    <a href="weather.php">Weather</a>
                </li>
                <li>
                    <a href="sea.php">Sea</a>
                </li>
            </ul>
        </div>
    </div>
</nav>