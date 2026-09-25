<?php
    $pageTitle       = 'Adriatic Sea Forecast — Waves, Tides & Sea Temperature | Lite Sails';
    $pageDescription = 'Marine forecast for the Adriatic: sea state, wave height and direction (Douglas scale), current sea temperatures, and high/low tide times.';

    // Wave/map images load from prognoza.hr via JS — warm the connection early.
    $preconnect = ['https://prognoza.hr'];

    // Shared meteo.hr fetch + cache helpers (dhmzFetch, dhmzCachePath).
    include('dhmz.php');

    include('header.php');
    include('nav.php');

    // DHMZ marine forecast + sea temperature, fetched live from meteo.hr through a
    // short filesystem cache (no external cron needed). Parsing uses PHP's built-in
    // DOM extension (no third-party dependency).
    $forecastUrl    = 'https://meteo.hr/prognoze.php?section=prognoze_specp&param=pomorci';
    $temperatureUrl = 'https://meteo.hr/podaci.php?section=podaci_vrijeme&param=more_n';
    // Tides come from HHI (Croatian Hydrographic Institute), not DHMZ.
    $tideUrl        = 'https://www.hhi.hr/webapi/data.json';

    /** Load an HTML string into a DOMXPath (UTF-8 safe), or null on empty input. */
    function seaXPath($html) {
        if ($html === '' || $html === false || $html === null) {
            return null;
        }

        $doc = new DOMDocument();
        $previous = libxml_use_internal_errors(true);
        // The <?xml encoding> prefix makes libxml treat the input as UTF-8,
        // avoiding the 'HTML-ENTITIES' mb_convert_encoding trick (removed in PHP 8.2+).
        $doc->loadHTML('<?xml encoding="UTF-8">' . $html);
        libxml_use_internal_errors($previous);
        libxml_clear_errors();

        return new DOMXPath($doc);
    }

    /** Trimmed inner HTML of a node (its children serialized). */
    function seaInnerHtml($node) {
        if (!$node) {
            return '';
        }

        $html = '';
        foreach ($node->childNodes as $child) {
            $html .= $node->ownerDocument->saveHTML($child);
        }

        return trim($html);
    }

    /**
     * Inner HTML of the <div> immediately following an <h5> whose text contains $needle — mirrors "h5:contains(...)->next('div')".
     */
    function seaSection($xpath, $needle) {
        if (!$xpath) {
            return '';
        }

        $node = $xpath->query("//h5[contains(., '{$needle}')][1]/following-sibling::*[1][self::div]")->item(0);

        return seaInnerHtml($node);
    }

    /**
     * Tide-gauge stations ("MP …", mareografske postaje) from HHI's JSON feed —
     * the same one the "Plima i oseka" tiles on hhi.hr fill themselves from
     * client-side (the numbers in hhi.hr's HTML are 2020 placeholders). The feed
     * also carries wave/wind/pressure stations (type 2–4); tides are type 1.
     *
     * Returns stations north to south, every value validated: times as
     * DateTime (or null), levels as float metres (or null), next tide as
     * 'HW'/'LW' (or null). Nothing from the feed reaches the page unchecked.
     */
    function seaTides($json) {
        $items = json_decode((string) $json, true);
        if (!is_array($items)) {
            return [];
        }

        $stations = [];

        foreach ($items as $item) {
            if (!is_array($item) || ($item['type'] ?? null) !== 1 || !is_string($item['name'] ?? null)) {
                continue;
            }

            $data = is_array($item['data'] ?? null) ? $item['data'] : [];

            $stations[] = [
                'name'       => trim(preg_replace('/^MP\s+/u', '', $item['name'])),
                'lat'        => (float) ($item['lat'] ?? 0),
                'measuredAt' => seaTideTime($data['LastMeasuredDateTime'] ?? ''),
                'measured'   => seaTideLevel($data['LastMeasuredLevel'] ?? null),
                'predicted'  => seaTideLevel($data['PredictionLevel'] ?? null),
                'nextAt'     => seaTideTime($data['NextTideDateTime'] ?? ''),
                'nextLevel'  => seaTideLevel($data['NextTideLevel'] ?? null),
                'nextType'   => in_array($data['NextTideType'] ?? null, ['HW', 'LW'], true) ? $data['NextTideType'] : null,
            ];
        }

        // North to south, the way you'd sail down the coast.
        usort($stations, function ($a, $b) {
            return $b['lat'] <=> $a['lat'];
        });

        return $stations;
    }

    /**
     * An HHI "25.09.2026 15:45" stamp as a DateTime in Croatian local time.
     *
     * HHI stamps in UTC+1 all year (no summer time) — at 14:53 UTC the
     * freshest readings say 15:45–15:49 — so it's parsed as +01:00 and shown
     * as Europe/Zagreb, which is an hour later in summer.
     */
    function seaTideTime($value) {
        $time = DateTime::createFromFormat('!d.m.Y H:i', (string) $value, new DateTimeZone('+01:00'));

        return $time ? $time->setTimezone(new DateTimeZone('Europe/Zagreb')) : null;
    }

    /** A level in metres as a float, or null for HHI's "-"/"undefined"/missing. */
    function seaTideLevel($value) {
        return is_numeric($value) ? (float) $value : null;
    }

    /** "15:45" for today, "Sat 03:12" for another day, "–" when unknown. */
    function seaTideClock($time) {
        if (!$time) {
            return '&ndash;';
        }

        $today = new DateTime('now', new DateTimeZone('Europe/Zagreb'));

        return $time->format('Y-m-d') === $today->format('Y-m-d') ? $time->format('H:i') : $time->format('D H:i');
    }

    /** "0.40 m", or "–" when unknown. */
    function seaTideMetres($level) {
        return $level === null ? '&ndash;' : number_format($level, 2) . ' m';
    }

    /** All <th> then all <td> texts of a table node, whitespace-normalised. */
    function seaCells($table) {
        $data = [];

        if (!$table) {
            return $data;
        }

        foreach (['th', 'td'] as $tag) {
            foreach ($table->getElementsByTagName($tag) as $cell) {
                $data[] = trim(preg_replace('/\s+/', ' ', $cell->textContent));
            }
        }

        return $data;
    }

    $forecastXPath = seaXPath(dhmzFetch($forecastUrl, dhmzCachePath('forecast')));
?>

<div id="js-content" class="container" data-area="sea">

    <h1 class="page-title text-center jumbotron">Sea forecast</h1>

    <ul class="nav nav-tabs nav-justified nav-shadowed" role="tablist">
        <li class="active">
            <a href="#recap" data-toggle="tab">Quick recap</a>
        </li>
        <li>
            <a href="#forecast" data-toggle="tab">Descriptive forecast</a>
        </li>
        <li>
            <a href="#waves" data-toggle="tab">Waves</a>
        </li>
        <li>
            <a href="#info" data-toggle="tab">Info</a>
        </li>
        <li>
            <a href="#temperature" data-toggle="tab">Temperature</a>
        </li>
        <li>
            <a href="#tide" data-toggle="tab">Tide</a>
        </li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="recap">
            <h3 class="text-center alert alert-success">Adriatic sea forecast</h3>
            <?php
                if ($warning = seaSection($forecastXPath, 'Upozorenje')) {
                    echo '
                        <div class="alert alert-danger">
                            <h3 class="text-danger text-center"><strong>Warning</strong></h3>
                            <p class="lead text-center">' . $warning . '</p>
                        </div>
                    ';
                }
            ?>
            <div class="row">
                <div class="col col-xs-12 center-block">
                    <?php
                        $table = $forecastXPath
                            ? $forecastXPath->query("//table[@id='table-aktualni-podaci']")->item(0)
                            : null;
                        $data = array_chunk(seaCells($table), 6);
                    ?>
                    <?php if ($data): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr class="bg-info">
                                <?php
                                    foreach ($data[0] as $title) {
                                        echo('<th>' . $title . '</th>');
                                    }

                                    array_shift($data);
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                    foreach ($data as $row) {
                                        echo('<tr>');

                                        foreach ($row as $cell) {
                                            echo('<td>' . $cell . '</td>');
                                        }

                                        echo('</tr>');
                                    }
                                ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="forecast">
            <h3 class="text-center alert alert-success">Descriptive forecast</h3>
            <div class="row">
                <div class="col col-md-4">
                    <div class="alert alert-info">
                        <h3 class="text-info">North Adriatic</h3>
                        <?php
                            if ($northAdriatic = seaSection($forecastXPath, 'Sjeverni Jadran')) {
                                echo "{$northAdriatic}";
                            }
                        ?>
                    </div>
                </div>
                <div class="col col-md-4">
                    <div class="alert alert-success">
                        <h3 class="text-info">Middle Adriatic</h3>
                        <?php
                            if ($middleAdriatic = seaSection($forecastXPath, 'Srednji Jadran')) {
                                echo "{$middleAdriatic}";
                            }
                        ?>
                    </div>
                </div>
                <div class="col col-md-4">
                    <div class="alert alert-warning">
                        <h3 class="text-info">South Adriatic</h3>
                        <?php
                            if ($southAdriatic = seaSection($forecastXPath, 'Južni Jadran')) {
                                echo "{$southAdriatic}";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="waves">
            <h3 class="text-center alert alert-success">Wave direction and height</h3>
            <nav class="text-center">
                <ul class="pagination aladin-hour">
                    <li class="active"><a href="#" data-value="[1,2,3,4]">1<sup>st</sup> day</a></li>
                    <li><a href="#" data-value="[5,6,7,8]">2<sup>nd</sup> day</a></li>
                    <li><a href="#" data-value="[9,10,11,12]">3<sup>rd</sup> day</a></li>
                    <li><a href="#" data-value="[13,14,15,16]">4<sup>th</sup> day</a></li>
                    <li><a href="#" data-value="[17,18,19,20]">5<sup>th</sup> day</a></li>
                    <li><a href="#" data-value="[21,22,23,24]">6<sup>th</sup> day</a></li>
                    <li><a href="#" data-value="[25,26,27,28]">7<sup>th</sup> day</a></li>
                </ul>
                <p class="text-center">
                    <a href="#" class="animation-play btn btn-success">Play animation</a>
                    <a href="#" class="animation-stop btn btn-info" style="display: none;">Stop animation</a>
                </p>
                <div id="js-sea-forecast-frame">
                    <img src="https://prognoza.hr/valovi/val_w.1.png" id="js-sea-forecast-image" class="img-responsive center-block" />
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="lead">
                            <strong>Wave height</strong> is expressed in <strong>meters</strong>. <strong>Time</strong>
                            is expressed in UTC (Universal Time). Add <strong>2 hours</strong> in the summer or
                            <strong>1 hour</strong> in the winter to calculate the result expressed in local
                            (Adriatic) time.
                        </p>
                    </div>
                </div>
            </nav>
        </div>

        <div class="tab-pane" id="info">
            <div class="row">
                <div class="col col-xs-12 center-block">
                    <?php
                        $douglasScale = $forecastXPath
                            ? $forecastXPath->query("//h5[contains(., 'Douglasova skala')][1]/following-sibling::*[1][self::table]")->item(0)
                            : null;
                        $data = array_chunk(seaCells($douglasScale), 4);
                    ?>
                    <h3 class="text-center alert alert-success">Douglas scale</h3>
                    <?php if ($data): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered douglas-scale">
                            <thead>
                                <tr class="bg-info">
                                    <?php
                                        foreach ($data[0] as $title) {
                                            echo('<th>' . $title . '</th>');
                                        }

                                        array_shift($data);
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                        foreach ($data as $row) {
                                            echo('<tr>');

                                            foreach ($row as $cell) {
                                                echo('<td>' . $cell . '</td>');
                                            }

                                            echo('</tr>');
                                        }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col col-xs-12 center-block">
                    <h3 class="text-center alert alert-success">Map of the Adriatic</h3>
                    <img src="https://prognoza.hr/podjela_jadran.gif" class="adriatic-map img-responsive center-block" />
                </div>
            </div>
        </div>

        <div class="tab-pane" id="temperature">
            <div class="row">
                <div class="col col-xs-12 center-block">
                    <?php
                        $temperatureXPath = seaXPath(dhmzFetch($temperatureUrl, dhmzCachePath('temperature')));
                        $table = $temperatureXPath
                            ? $temperatureXPath->query("//table[@id='table-aktualni-podaci']")->item(0)
                            : null;
                        $data = array_chunk(seaCells($table), 7);
                        $heading = $temperatureXPath
                            ? $temperatureXPath->query("//*[contains(@class, 'glavni__content')]//h4")->item(0)
                            : null;
                    ?>
                    <h3 class="text-center alert alert-success">Adriatic sea temperature</h3>
                    <h4 class="text-center"><?= $heading ? trim($heading->textContent) : '' ?></h4>
                    <?php if ($data): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr class="bg-info">
                                <?php
                                    foreach ($data[0] as $title) {
                                        echo('<th>' . $title . '</th>');
                                    }

                                    array_shift($data);
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                    foreach ($data as $row) {
                                        echo('<tr>');

                                        foreach ($row as $cell) {
                                            echo('<td>' . $cell . '</td>');
                                        }

                                        echo('</tr>');
                                    }
                                ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="lead">
                        <strong>Temperatures</strong> are expressed in <strong>degrees Celsius</strong>.
                    </p>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tide">
            <?php
                // HHI refreshes its gauges every ~15 min, so a shorter TTL than
                // the DHMZ pages; dhmzFetch() is source-agnostic despite its name
                // (the _dhmz_ prefix is what keeps the cache file 403'd).
                $tides = seaTides(dhmzFetch($tideUrl, dhmzCachePath('hhi_tide'), 600));
            ?>
            <h3 class="text-center alert alert-success">Adriatic tide</h3>
            <?php if ($tides): ?>
            <div class="row tide-stations">
                <?php foreach ($tides as $station): ?>
                <div class="col-sm-6 col-md-4">
                    <div class="panel panel-default tide-station">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?= htmlspecialchars($station['name']) ?></h4>
                        </div>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Sea level</td>
                                    <td class="text-right"><strong><?= seaTideMetres($station['measured']) ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Predicted</td>
                                    <td class="text-right"><?= seaTideMetres($station['predicted']) ?></td>
                                </tr>
                                <tr>
                                    <td>Measured at</td>
                                    <td class="text-right"><?= seaTideClock($station['measuredAt']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel-footer tide-station__next">
                            <?php if ($station['nextType']): ?>
                                <span class="glyphicon glyphicon-arrow-<?= $station['nextType'] === 'HW' ? 'up' : 'down' ?>" aria-hidden="true"></span>
                                Next <strong><?= $station['nextType'] === 'HW' ? 'high tide' : 'low tide' ?></strong>
                                at <strong><?= seaTideClock($station['nextAt']) ?></strong>
                                <span class="tide-station__level"><?= seaTideMetres($station['nextLevel']) ?></span>
                            <?php else: ?>
                                Next tide unknown
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-warning text-center">
                Tide data couldn't be loaded from HHI right now. Please try again later.
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="lead">
                        <strong>Sea levels</strong> are expressed in <strong>meters</strong>.<br><strong>Times</strong> are local (Croatian) time.
                    </p>
                    <p class="text-muted small">
                        Data: <a href="https://www.hhi.hr/" target="_blank" rel="noopener noreferrer">Croatian Hydrographic Institute (HHI)</a>.
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include('footer.php'); ?>
