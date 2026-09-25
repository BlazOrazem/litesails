<?php
    $pageTitle       = 'Lightning Map — Strikes in the Last 30 Minutes | Lite Sails';
    $pageDescription = 'Live map of lightning strikes over Croatia and the Adriatic in the last 30 minutes (DHMZ / meteo.hr) — spot thunderstorms before you sail.';

    // Map tiles load from OpenStreetMap via Leaflet — warm the connection early.
    $preconnect = ['https://tile.openstreetmap.org'];

    // Leaflet is only needed here, so it ships outside app.min.js (see build.js).
    $pageStyles  = ['/dist/leaflet/leaflet.min.css'];
    $pageScripts = ['/dist/leaflet/leaflet.min.js'];

    // Shared meteo.hr fetch helpers (dhmzHttpGet).
    include('dhmz.php');

    /**
     * Pull the strikes, per-age counts and "last updated" stamp out of the
     * meteo.hr lightning page, or null if it didn't load / isn't recognisable.
     *
     * meteo.hr draws the map client-side: every strike is an inline
     *   L.marker([lat,lon], {icon: L.icon({iconUrl: ".../~atd/<colour>.png", …})})
     * where the icon colour is the strike's age. That script can't run here
     * (CSP: no inline JS), so the coordinates are read out with a regex and
     * handed to our own Leaflet map in initLightning(). Counts are taken from
     * the parsed markers rather than their legend table, so the legend always
     * matches the dots drawn.
     */
    function lightningParse($html) {
        // No map script at all means an error page or a redesign — say so,
        // rather than reporting a reassuring "no lightning".
        if ($html === '' || strpos($html, 'L.map(') === false) {
            return null;
        }

        // Icon colour => age bucket: 0 = < 10 min, 1 = 10–20 min, 2 = 20–30 min.
        $ages = ['crvena' => 0, 'zutaa' => 1, 'zuta' => 1, 'plava' => 2];

        $strikes = [];
        $counts  = [0, 0, 0];

        preg_match_all(
            '/L\.marker\(\s*\[\s*(-?\d+(?:\.\d+)?)\s*,\s*(-?\d+(?:\.\d+)?)\s*\]\s*,\s*\{\s*icon:\s*L\.icon\(\{\s*iconUrl:\s*["\'][^"\']*\/(\w+)\.png/',
            $html,
            $matches,
            PREG_SET_ORDER
        );

        foreach ($matches as $m) {
            $lat = (float) $m[1];
            $lon = (float) $m[2];

            if (!isset($ages[$m[3]]) || abs($lat) > 90 || abs($lon) > 180) {
                continue;
            }

            $age = $ages[$m[3]];
            $strikes[] = [round($lat, 3), round($lon, 3), $age];
            $counts[$age]++;
        }

        // "Zadnja izmjena: 25. 09. 2026.  16:38" — Croatian local time.
        $updated = '';
        if (preg_match('/Zadnja izmjena.*?<th[^>]*>\s*(\d{1,2})\.\s*(\d{1,2})\.\s*(\d{4})\.\s+(\d{1,2}):(\d{2})\s*</s', $html, $t)) {
            $updated = sprintf('%02d. %02d. %04d, %02d:%02d', $t[1], $t[2], $t[3], $t[4], $t[5]);
        }

        return ['strikes' => $strikes, 'counts' => $counts, 'updated' => $updated];
    }

    // Deliberately NOT cached (dhmzHttpGet, not dhmzFetch): meteo.hr refreshes
    // this every few minutes and a 30 min cache would outlive the whole
    // 30 min window it shows. The flip side is no stale fallback — if meteo.hr
    // is down, the page says so instead.
    $sourceUrl = 'https://meteo.hr/podaci.php?section=podaci_mjerenja&param=mg&el=hrvatska';
    $lightning = lightningParse(dhmzHttpGet($sourceUrl));

    include('header.php');
    include('nav.php');

    $ageLabels = ['&lt; 10 min ago', '10&ndash;20 min ago', '20&ndash;30 min ago'];
?>

<div id="js-content" class="container" data-area="lightning">

    <div class="row">
        <div class="col-xs-12" id="content">

            <h1 class="page-title text-center jumbotron">Lightning in the last 30 minutes</h1>

            <hr>

<?php if ($lightning === null): ?>
            <div class="alert alert-warning text-center">
                Lightning data couldn't be loaded from meteo.hr right now.
                <a href="/lightning" class="alert-link">Try again</a> in a minute, or check the
                <a href="<?= htmlspecialchars($sourceUrl) ?>" class="alert-link" target="_blank" rel="noopener noreferrer">source page</a>.
            </div>
<?php else: ?>
            <div class="row">
                <div class="col-md-9">
                    <div id="js-lightning-map" class="lightning-map" role="img"
                         aria-label="Map of lightning strikes over Croatia and the Adriatic in the last 30 minutes"></div>
                    <noscript>
                        <p class="alert alert-info">The lightning map needs JavaScript. The counts are listed alongside.</p>
                    </noscript>
                    <script type="application/json" id="js-lightning-data"><?= json_encode(['strikes' => $lightning['strikes']], JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
                </div>

                <div class="col-md-3">
                    <div class="panel panel-default lightning-legend">
                        <div class="panel-heading">
                            <h2 class="panel-title">Lightning strikes</h2>
                        </div>
                        <table class="table">
                            <tbody>
<?php foreach ($ageLabels as $age => $label): ?>
                                <tr>
                                    <td><span class="lightning-dot lightning-dot--<?= $age ?>" aria-hidden="true"></span> <?= $label ?></td>
                                    <td class="text-right"><strong><?= $lightning['counts'][$age] ?></strong></td>
                                </tr>
<?php endforeach; ?>
                                <tr class="lightning-legend__total">
                                    <th>Total</th>
                                    <th class="text-right"><?= array_sum($lightning['counts']) ?></th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel-body">
<?php if (array_sum($lightning['counts']) === 0): ?>
                            <p><strong>No lightning in the last 30 minutes.</strong></p>
<?php endif; ?>
<?php if ($lightning['updated'] !== ''): ?>
                            <p class="text-muted">
                                Last updated<br>
                                <strong><?= htmlspecialchars($lightning['updated']) ?></strong> (local time)
                            </p>
<?php endif; ?>
                            <a href="/lightning" class="btn btn-default btn-block">Refresh</a>
                        </div>
                    </div>
                </div>
            </div>
<?php endif; ?>

            <p class="text-muted small text-center lightning-source">
                Data: <a href="https://www.metoffice.gov.uk/" target="_blank" rel="noopener noreferrer">Met Office</a>,
                processed and published by
                <a href="<?= htmlspecialchars($sourceUrl) ?>" target="_blank" rel="noopener noreferrer">DHMZ (meteo.hr)</a>.
                The shaded box is the area DHMZ covers.
            </p>

        </div>
    </div>

</div>

<?php include('footer.php'); ?>
