<?php
    $pageTitle       = 'Nautical Tools — Distance and Wind Speed Converters | Lite Sails';
    $pageDescription = 'Handy tools for sailors: convert kilometers to nautical miles, and wind speed between km/h, m/s and knots — instantly as you type.';

    include('header.php');
    include('nav.php');
?>

<div id="js-content" class="container" data-area="tools">

    <h1 class="page-title text-center jumbotron">Tools</h1>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Distance &mdash; kilometers &#8660; nautical miles</h2>
                </div>
                <div class="panel-body">
                    <p class="text-muted">Type into either field &mdash; the other one converts instantly.</p>

                    <div class="row converter">
                        <div class="col-sm-5">
                            <label for="js-conv-km">Kilometers</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="js-conv-km"
                                       inputmode="decimal" autocomplete="off" placeholder="0">
                                <span class="input-group-addon">km</span>
                            </div>
                        </div>
                        <div class="col-sm-2 converter__equals" aria-hidden="true">=</div>
                        <div class="col-sm-5">
                            <label for="js-conv-nm">Nautical miles</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="js-conv-nm"
                                       inputmode="decimal" autocomplete="off" placeholder="0">
                                <span class="input-group-addon">NM</span>
                            </div>
                        </div>
                    </div>

                    <p class="help-block converter__note">
                        One nautical mile is exactly <strong>1.852 km</strong> &mdash; the length of one minute of
                        latitude, which is why charts and sailors measure distance in it.
                    </p>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Wind speed &mdash; km/h &#8660; m/s &#8660; knots</h2>
                </div>
                <div class="panel-body">
                    <p class="text-muted">Type into any field &mdash; the other two convert instantly.</p>

                    <div class="row converter">
                        <div class="col-sm-4">
                            <label for="js-wind-kmh">Kilometers per hour</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="js-wind-kmh"
                                       inputmode="decimal" autocomplete="off" placeholder="0">
                                <span class="input-group-addon">km/h</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="js-wind-ms">Meters per second</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="js-wind-ms"
                                       inputmode="decimal" autocomplete="off" placeholder="0">
                                <span class="input-group-addon">m/s</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="js-wind-kn">Knots</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="js-wind-kn"
                                       inputmode="decimal" autocomplete="off" placeholder="0">
                                <span class="input-group-addon">kn</span>
                            </div>
                        </div>
                    </div>

                    <p class="help-block converter__note">
                        A knot is one nautical mile per hour, i.e. exactly <strong>1.852 km/h</strong>.
                        Croatian forecasts (meteo.hr) publish wind in <strong>m/s</strong>, while charts and
                        boat instruments read in knots &mdash; a handy rule of thumb is
                        <strong>1 m/s &asymp; 2 knots</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include('footer.php'); ?>
