<?php
    $pageTitle       = 'Nautical Tools — Wind Speed, Beaufort, Distance and Boat Length | Lite Sails';
    $pageDescription = 'Handy tools for sailors: convert kilometers to nautical miles, boat length between meters and feet, and wind speed between km/h, m/s and knots — instantly as you type, with the Beaufort force for any speed.';

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
                    <h2 class="panel-title">Boat length &mdash; meters &#8660; feet</h2>
                </div>
                <div class="panel-body">
                    <p class="text-muted">Type into either field &mdash; the other one converts instantly.</p>

                    <div class="row converter">
                        <div class="col-sm-5">
                            <label for="js-len-m">Meters</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="js-len-m"
                                       inputmode="decimal" autocomplete="off" placeholder="0">
                                <span class="input-group-addon">m</span>
                            </div>
                        </div>
                        <div class="col-sm-2 converter__equals" aria-hidden="true">=</div>
                        <div class="col-sm-5">
                            <label for="js-len-ft">Feet</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="js-len-ft"
                                       inputmode="decimal" autocomplete="off" placeholder="0">
                                <span class="input-group-addon">ft</span>
                            </div>
                        </div>
                    </div>

                    <p class="help-block converter__note">
                        One foot is exactly <strong>0.3048 m</strong>. Boats are advertised in feet
                        (a &ldquo;40.1&nbsp;ft&rdquo; hull is 12.22&nbsp;m), while Adriatic berths and
                        price lists are usually quoted per meter of length &mdash; so it pays to know both.
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

                    <div class="beaufort-readout beaufort-readout--empty" id="js-wind-bf" role="status">
                        <span class="beaufort-readout__force" id="js-wind-bf-force">&mdash;</span>
                        <span class="beaufort-readout__label" id="js-wind-bf-label">Enter a wind speed to see its Beaufort force.</span>
                    </div>

                    <p class="help-block converter__note">
                        A knot is one nautical mile per hour, i.e. exactly <strong>1.852 km/h</strong>.
                        Croatian forecasts (meteo.hr) publish wind in <strong>m/s</strong>, while charts and
                        boat instruments read in knots &mdash; a handy rule of thumb is
                        <strong>1 m/s &asymp; 2 knots</strong>.
                    </p>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Beaufort scale</h2>
                </div>
                <div class="panel-body">
                    <p class="text-muted">
                        Type a speed above and its row lights up here.
                    </p>

                    <div class="table-responsive">
                        <table class="table table-condensed table-striped beaufort-table" id="js-beaufort-table">
                            <thead>
                                <tr class="bg-info">
                                    <th>Bf</th>
                                    <th>Description</th>
                                    <th>m/s</th>
                                    <th>Knots</th>
                                    <th>At sea</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-force="0">
                                    <td>0</td><td>Calm</td><td>&lt; 0.3</td><td>&lt; 1</td>
                                    <td>Sea like a mirror.</td>
                                </tr>
                                <tr data-force="1">
                                    <td>1</td><td>Light air</td><td>0.3&ndash;1.8</td><td>1&ndash;3</td>
                                    <td>Ripples, no foam crests.</td>
                                </tr>
                                <tr data-force="2">
                                    <td>2</td><td>Light breeze</td><td>1.9&ndash;3.3</td><td>4&ndash;6</td>
                                    <td>Small wavelets with glassy crests.</td>
                                </tr>
                                <tr data-force="3">
                                    <td>3</td><td>Gentle breeze</td><td>3.4&ndash;5.4</td><td>7&ndash;10</td>
                                    <td>Large wavelets, crests begin to break.</td>
                                </tr>
                                <tr data-force="4">
                                    <td>4</td><td>Moderate breeze</td><td>5.5&ndash;8.4</td><td>11&ndash;16</td>
                                    <td>Small waves, frequent whitecaps.</td>
                                </tr>
                                <tr data-force="5">
                                    <td>5</td><td>Fresh breeze</td><td>8.5&ndash;11.0</td><td>17&ndash;21</td>
                                    <td>Moderate waves, many whitecaps, some spray.</td>
                                </tr>
                                <tr data-force="6">
                                    <td>6</td><td>Strong breeze</td><td>11.1&ndash;14.1</td><td>22&ndash;27</td>
                                    <td>Large waves, foam crests everywhere, spray.</td>
                                </tr>
                                <tr data-force="7">
                                    <td>7</td><td>Near gale</td><td>14.2&ndash;17.2</td><td>28&ndash;33</td>
                                    <td>Sea heaps up, foam blown in streaks.</td>
                                </tr>
                                <tr data-force="8">
                                    <td>8</td><td>Gale</td><td>17.3&ndash;20.8</td><td>34&ndash;40</td>
                                    <td>Moderately high waves, crests break into spindrift.</td>
                                </tr>
                                <tr data-force="9">
                                    <td>9</td><td>Strong gale</td><td>20.9&ndash;24.4</td><td>41&ndash;47</td>
                                    <td>High waves, dense foam, spray hurts visibility.</td>
                                </tr>
                                <tr data-force="10">
                                    <td>10</td><td>Storm</td><td>24.5&ndash;28.5</td><td>48&ndash;55</td>
                                    <td>Very high waves with overhanging crests, sea looks white.</td>
                                </tr>
                                <tr data-force="11">
                                    <td>11</td><td>Violent storm</td><td>28.6&ndash;32.6</td><td>56&ndash;63</td>
                                    <td>Exceptionally high waves, sea completely covered in foam.</td>
                                </tr>
                                <tr data-force="12">
                                    <td>12</td><td>Hurricane</td><td>&ge; 32.7</td><td>64+</td>
                                    <td>Air filled with foam and spray, visibility gone.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="help-block converter__note">
                        Croatian forecasts publish wind speed in <strong>m/s</strong> but describe it in
                        Beaufort &mdash; &ldquo;bura 6 to 8&rdquo; means force, not knots. Note that the
                        wave heights behind the scale assume open ocean: the Adriatic is narrow, so the
                        same force builds a shorter, steeper sea here. For the forecast sea state see the
                        <a href="/sea">Douglas scale on the sea page</a>, and for what each Adriatic wind
                        does see <a href="/winds">Adriatic winds</a>. The scale is defined in knots, so the
                        knot column decides the force here (rounded to whole knots, the way an
                        instrument reads) and the m/s column is those same bands converted &mdash; which
                        puts it up to half a m/s off the rounded m/s ranges other tables print.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include('footer.php'); ?>
