<?php
    $pageTitle       = 'Adriatic Sea Forecast — Waves & Sea Temperature | Lite Sails';
    $pageDescription = 'Marine forecast for the Adriatic: sea state, wave height and direction (Douglas scale), and current sea temperatures.';

    // Wave/map images load from prognoza.hr via JS — warm the connection early.
    $preconnect = ['https://prognoza.hr'];

    include('header.php');
    include('nav.php');

    // DHMZ marine forecast + sea temperature, fetched live from meteo.hr through a
    // short filesystem cache (no external cron needed). Parsing uses PHP's built-in
    // DOM extension (no third-party dependency).
    $forecastUrl    = 'https://meteo.hr/prognoze.php?section=prognoze_specp&param=pomorci';
    $temperatureUrl = 'https://meteo.hr/podaci.php?section=podaci_vrijeme&param=more_n';

    /**
     * Fetch a URL through a filesystem cache (default 30 min TTL).
     *
     * Serves the cache while it's fresh; otherwise fetches live (cURL, retrying
     * without TLS verification if the host's CA bundle is misconfigured, then a
     * file_get_contents fallback) and rewrites the cache. If the live fetch
     * fails, falls back to a stale cache so the page still renders.
     */
    function dhmzFetch($url, $cacheFile, $ttl = 1800) {
        if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
            $cached = file_get_contents($cacheFile);
            if ($cached !== false && $cached !== '') {
                return $cached;
            }
        }

        $html = false;
        if (function_exists('curl_init')) {
            foreach ([true, false] as $verify) {
                $ch = curl_init($url);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_TIMEOUT        => 15,
                    CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; LiteSails/1.0)',
                    CURLOPT_SSL_VERIFYPEER => $verify,
                    CURLOPT_SSL_VERIFYHOST => $verify ? 2 : 0,
                ]);
                $html = curl_exec($ch);
                curl_close($ch);
                if ($html !== false && $html !== '') {
                    break;
                }
            }
        }

        if ($html === false || $html === '') {
            $html = @file_get_contents($url);
        }

        if ($html !== false && $html !== '') {
            @file_put_contents($cacheFile, $html, LOCK_EX);
            return $html;
        }

        // Live fetch failed — fall back to a stale cache if one exists.
        if (is_file($cacheFile)) {
            $stale = file_get_contents($cacheFile);
            if ($stale !== false && $stale !== '') {
                return $stale;
            }
        }

        return '';
    }

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

    $forecastXPath = seaXPath(dhmzFetch($forecastUrl, __DIR__ . '/_dhmz_forecast.html'));
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
                        $temperatureXPath = seaXPath(dhmzFetch($temperatureUrl, __DIR__ . '/_dhmz_temperature.html'));
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

    </div>

</div>

<?php include('footer.php'); ?>
