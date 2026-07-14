<?php
    // Whitelist the wind map so $_GET['map'] can't be reflected into the page.
    $maps = ['adriatic', 'north-adriatic', 'middle-adriatic', 'south-adriatic'];
    $map = (isset($_GET['map']) && in_array($_GET['map'], $maps, true)) ? $_GET['map'] : 'adriatic';

    // Real, server-rendered <h1> so crawlers/scrapers see a heading (JS re-sets
    // the same text on load).
    $windTitle = ucwords(str_replace('-', ' ', $map)) . ' wind forecast';

    $pageTitle       = 'Adriatic Wind & Gust Forecast for Sailors | Lite Sails';
    $pageDescription = '72-hour Adriatic wind and gust forecast maps (ALADIN model) for sailors and boaters on the Croatian coast.';

    // Wind-map images load from prognoza.hr via JS — warm the connection early.
    $preconnect = ['https://prognoza.hr'];

    include('header.php');
    include('nav.php');
?>

<div id="js-content" class="container" data-area="wind">

    <div class="row">
        <div class="col-xs-12" id="content">

            <h1 id="js-area" class="page-title text-center jumbotron"><?= htmlspecialchars($windTitle) ?></h1>

            <hr>

            <nav class="text-center">
                <ul class="pagination aladin-hour">
                    <li><a href="#" data-value="03">03</a></li>
                    <li><a href="#" data-value="06">06</a></li>
                    <li><a href="#" data-value="09">09</a></li>
                    <li><a href="#" data-value="12">12</a></li>
                    <li><a href="#" data-value="15">15</a></li>
                    <li><a href="#" data-value="18">18</a></li>
                    <li><a href="#" data-value="21">21</a></li>
                    <li><a href="#" data-value="24">24</a></li>
                    <li><a href="#" data-value="27">27</a></li>
                    <li><a href="#" data-value="30">30</a></li>
                    <li><a href="#" data-value="33">33</a></li>
                    <li><a href="#" data-value="36">36</a></li>
                    <li><a href="#" data-value="39">39</a></li>
                    <li><a href="#" data-value="42">42</a></li>
                    <li><a href="#" data-value="45">45</a></li>
                    <li><a href="#" data-value="48">48</a></li>
                    <li><a href="#" data-value="51">51</a></li>
                    <li><a href="#" data-value="54">54</a></li>
                    <li><a href="#" data-value="57">57</a></li>
                    <li><a href="#" data-value="60">60</a></li>
                    <li><a href="#" data-value="63">63</a></li>
                    <li><a href="#" data-value="66">66</a></li>
                    <li><a href="#" data-value="69">69</a></li>
                    <li><a href="#" data-value="72">72</a></li>
                </ul>
                <p class="animation-controls text-center">
                    <a href="#" class="animation-play btn btn-success">Play animation</a>
                    <a href="#" class="animation-stop btn btn-info" style="display: none;">Stop animation</a>
                </p>
            </nav>

            <ul class="nav nav-tabs nav-justified nav-shadowed" role="tablist">
                <li class="active">
                    <a href="#js-tab-wind" data-toggle="tab">Wind forecast</a>
                </li>
                <li>
                    <a href="#js-tab-gusts" data-toggle="tab">Gusts of wind</a>
                </li>
            </ul>

            <div class="tab-content" data-source="<?= $map ?>">
                <div id="js-tab-wind" class="tab-pane active">
                    <img src="/images/windrose.png" id="js-wind-rose" class="wind-rose img-responsive center-block" alt="Compass rose showing wind directions">
                    <div id="js-wind-forecast-image-frame"></div>
                </div>
                <div id="js-tab-gusts" class="tab-pane">
                    <div id="js-wind-gusts-image-frame"></div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 text-center">
                    <p class="lead">
                        <strong>Wind speed</strong> is expressed in <strong>10 meters per second</strong>. Multiply the
                        prediction <strong>by 2</strong> and calculate the result expressed in <strong>knots</strong>.
                        1 meter per second is 1,94 knots.
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <p class="lead">
                        <strong>Time</strong> is expressed in UTC (Universal Time). Add <strong>2 hours</strong> in
                        the summer or <strong>1 hour</strong> in the winter to calculate the result expressed in local
                        (Adriatic) time.
                    </p>
                </div>
            </div>

        </div>
    </div>

</div>

<?php include('footer.php'); ?>
