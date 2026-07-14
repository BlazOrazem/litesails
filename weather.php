<?php
    $pageTitle       = '7-Day Adriatic Weather Forecast — Coastal Towns | Lite Sails';
    $pageDescription = '7-day DHMZ weather forecast for 170+ towns along the Croatian Adriatic coast — temperature, sky, wind and precipitation.';

    include('header.php');
    include('nav.php');

    /*
     * DHMZ (meteo.hr) 7-day forecast lives at:
     * https://meteo.hr/prognoze.php?Code=PULA&id=prognoza&section=prognoze_model&param=7d
     * where "Code" is the DHMZ cipher for the location (uppercase).
     */
    $areas = [
        'Istarska'               => [
            'NP BRIJUNI'       => 'Brijuni (NP)',
            'FAŽANA'           => 'Fažana',
            'LABIN'            => 'Labin',
            'MEDULIN'          => 'Medulin',
            'NOVIGRAD - ISTRA' => 'Novigrad',
            'POREČ'            => 'Poreč',
            'PULA'             => 'Pula',
            'ZRAČNA LUKA PULA' => 'Pula Loborika (ZL)',
            'ROVINJ'           => 'Rovinj',
            'SAVUDRIJA'        => 'Savudrija',
            'UMAG'             => 'Umag',
            'VODNJAN'          => 'Vodnjan',
            'VRSAR'            => 'Vrsar',
        ],
        'Primorsko-goranska'     => [
            'BAKAR'                   => 'Bakar',
            'BAŠKA'                   => 'Baška (Krk)',
            'CRES'                    => 'Cres',
            'CRIKVENICA'              => 'Crikvenica',
            'KOSTRENA'                => 'Kostrena',
            'KRALJEVICA'              => 'Kraljevica',
            'KRK'                     => 'Krk',
            'MOST KRK'                => 'Krk most',
            'LOPAR'                   => 'Lopar (Rab)',
            'LOVRAN'                  => 'Lovran',
            'LUBENICE'                => 'Lubenice (Cres)',
            'MALI LOŠINJ'             => 'Mali Lošinj',
            'ZRAČNA LUKA MALI LOŠINJ' => 'Mali Lošinj (ZL)',
            'MALINSKA'                => 'Malinska (Krk)',
            'MOŠĆENIČKA DRAGA'        => 'Mošćenička Draga',
            'NEREZINE'                => 'Nerezine (Lošinj)',
            'NOVI VINODOLSKI'         => 'Novi Vinodolski',
            'OPATIJA'                 => 'Opatija',
            'POROZINA'                => 'Porozina (Cres)',
            'POVILE'                  => 'Povile',
            'RAB'                     => 'Rab',
            'RIJEKA'                  => 'Rijeka',
            'ZRAČNA LUKA RIJEKA'      => 'Rijeka Omišalj (ZL)',
            'SELCE'                   => 'Selce',
            'UNIJE'                   => 'Unije',
            'URINJ'                   => 'Urinj',
        ],
        'Ličko-senjska'          => [
            'JABLANAC' => 'Jablanac',
            'KARLOBAG' => 'Karlobag',
            'NOVALJA'  => 'Novalja (Pag)',
            'PRIZNA'   => 'Prizna',
            'SENJ'     => 'Senj',
        ],
        'Zadarska'               => [
            'BIOGRAD NA MORU'          => 'Biograd',
            'BOŽAVA'                   => 'Božava (Dugi otok)',
            'IST'                      => 'Ist',
            'MASLENICA'                => 'Maslenica',
            'MOLAT'                    => 'Molat',
            'NIN'                      => 'Nin',
            'OLIB'                     => 'Olib',
            'PAG'                      => 'Pag',
            'MOST PAG'                 => 'Pag most',
            'PAKOŠTANE'                => 'Pakoštane',
            'POSEDARJE'                => 'Posedarje',
            'POVLJANA'                 => 'Povljana',
            'RAŽANAC'                  => 'Ražanac',
            'SALI'                     => 'Sali (Dugi otok)',
            'SILBA'                    => 'Silba',
            'NP PAKLENICA - STARIGRAD' => 'Starigrad-Paklenica (NP)',
            'SUKOŠAN'                  => 'Sukošan',
            'TKON'                     => 'Tkon (Pašman)',
            'UGLJAN'                   => 'Ugljan',
            'VIR'                      => 'Vir',
            'ZADAR'                    => 'Zadar',
            'ZRAČNA LUKA ZADAR'        => 'Zadar Zemunik (ZL)',
        ],
        'Šibensko-kninska'       => [
            'NP KORNATI'         => 'Kornati (NP)',
            'NP KRKA - LOZOVAC'  => 'Lozovac (NP Krka)',
            'MURTER'             => 'Murter',
            'PIROVAC'            => 'Pirovac',
            'PRIMOŠTEN'          => 'Primošten',
            'ROGOZNICA'          => 'Rogoznica',
            'SKRADIN'            => 'Skradin',
            'ŠIBENIK'            => 'Šibenik',
            'TISNO'              => 'Tisno (Murter)',
            'TRIBUNJ'            => 'Tribunj',
            'VODICE - DALMACIJA' => 'Vodice',
            'ZLARIN'             => 'Zlarin',
            'ŽIRJE'              => 'Žirje',
        ],
        'Splitsko-dalmatinska'   => [
            'BAŠKA VODA'        => 'Baška Voda',
            'BIŠEVO'            => 'Biševo',
            'BOL'               => 'Bol',
            'BRELA'             => 'Brela',
            'DRVENIK'           => 'Drvenik',
            'GRADAC'            => 'Gradac',
            'HVAR'              => 'Hvar',
            'JELSA'             => 'Jelsa (Hvar)',
            'KOMIŽA'            => 'Komiža (Vis)',
            'MAKARSKA'          => 'Makarska',
            'MILNA'             => 'Milna (Brač)',
            'OMIŠ'              => 'Omiš',
            'PALAGRUŽA'         => 'Palagruža',
            'ŽIVOGOŠĆE'         => 'Podgora - Živogošće',
            'PODSTRANA'         => 'Podstrana',
            'POSTIRA'           => 'Postira (Brač)',
            'POVLJA'            => 'Povlja',
            'SOLIN'             => 'Solin',
            'SPLIT'             => 'Split',
            'ZRAČNA LUKA SPLIT' => 'Split Resnik (ZL)',
            'STARIGRAD - HVAR'  => 'Stari Grad (Hvar)',
            'SUMARTIN'          => 'Sumartin (Brač)',
            'SUPETAR'           => 'Supetar (Brač)',
            'SUTIVAN'           => 'Sutivan (Brač)',
            'ŠOLTA'             => 'Šolta',
            'TROGIR'            => 'Trogir',
            'TUČEPI'            => 'Tučepi',
            'VIS'               => 'Vis',
            'ŽRNOVNICA'         => 'Žrnovnica',
        ],
        'Dubrovačko-neretvanska' => [
            'BLATO NA KORČULI'      => 'Blato (Korčula)',
            'CAVTAT'                => 'Cavtat',
            'DUBROVNIK'             => 'Dubrovnik',
            'ZRAČNA LUKA DUBROVNIK' => 'Dubrovnik Čilipi (ZL)',
            'GOVEĐARI U MORU'       => 'Goveđari (NP Mljet)',
            'KOLOČEP'               => 'Koločep',
            'KOMIN'                 => 'Komin',
            'KORČULA'               => 'Korčula',
            'NP MLJET - KORITA'     => 'Korita (NP Mljet)',
            'KUNA'                  => 'Kuna',
            'LASTOVO'               => 'Lastovo',
            'LOPUD'                 => 'Lopud',
            'LUMBARDA'              => 'Lumbarda (Korčula)',
            'OPUZEN'                => 'Opuzen',
            'OREBIĆ'                => 'Orebić',
            'PLOČE'                 => 'Ploče',
            'PREVLAKA'              => 'Prevlaka',
            'ROGOTIN'               => 'Rogotin',
            'SLANO'                 => 'Slano',
            'STON'                  => 'Ston',
            'TRSTENIK'              => 'Trstenik',
            'TRSTENO'               => 'Trsteno',
            'VELA LUKA'             => 'Vela Luka (Korčula)',
        ],
    ];

    // Flat cipher => name lookup, for validation and the page title.
    $cityNames = [];
    foreach ($areas as $group) {
        $cityNames += $group;
    }

    $code = (isset($_GET['code']) && isset($cityNames[$_GET['code']])) ? $_GET['code'] : 'PULA';

    $url = 'https://meteo.hr/prognoze.php?Code=' . rawurlencode($code) . '&id=prognoza&section=prognoze_model&param=7d';

    /**
     * Fetch remote HTML.
     *
     * Prefers cURL with full TLS verification. If that fails (e.g. a server with
     * a misconfigured CA bundle), it retries without peer verification so the
     * page still works — acceptable here since we only read public forecast HTML.
     * Falls back to file_get_contents when cURL is unavailable.
     */
    function fetchHtml($url) {
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
                    return $html;
                }
            }
        }

        return @file_get_contents($url);
    }

    /**
     * Pull a single <table> (by id) out of an HTML string, markup untouched.
     * The id may appear anywhere in the opening tag. No nested tables here, so a
     * lazy match to the first </table> is safe — and it keeps the inline SVG
     * icons intact (unlike a DOM parser, which would mangle their `viewBox`).
     */
    function extractTable($html, $id) {
        if (preg_match('#<table[^>]*id="' . preg_quote($id, '#') . '".*?</table>#s', $html, $m)) {
            return $m[0];
        }

        return '';
    }

    $forecastTable = '';   // The 7-day summary (#kratka_tablica), translated.
    $hourlyTables  = '';   // Hidden per-hour tables that power the "More…" view.

    $html = fetchHtml($url);

    if ($html) {
        $table = extractTable($html, 'kratka_tablica');
    }

    if (!empty($table)) {
        // Drop the stray empty <tr> that sits between the header and data rows.
        $table = preg_replace('#<tr>\s*<tr#', '<tr', $table, 1);

        // Translate DHMZ's Croatian labels to English (SVG markup is untouched).
        // The last column's "detaljnije.." becomes a "More…" toggle (see scripts.js).
        $table = strtr($table, [
            '<th scope="col">Dan</th>'               => '<th scope="col">Day</th>',
            '<th scope="col">Noć</th>'               => '<th scope="col">Night</th>',
            '<th scope="col">Jutro</th>'             => '<th scope="col">Morning</th>',
            '<th scope="col">Popodne</th>'           => '<th scope="col">Afternoon</th>',
            '<th scope="col">Večer</th>'             => '<th scope="col">Evening</th>',
            '<th scope="col">Maksimum/Minimum</th>'  => '<th scope="col">Max / Min</th>',
            '<th scope="col">Maksimum</th>'          => '<th scope="col">Wind</th>',
            '<th scope="col">Oborina</th>'           => '<th scope="col">Precip.</th>',
            'Ponedjeljak' => 'Monday',
            'Utorak'      => 'Tuesday',
            'Srijeda'     => 'Wednesday',
            'Četvrtak'    => 'Thursday',
            'Petak'       => 'Friday',
            'Subota'      => 'Saturday',
            'Nedjelja'    => 'Sunday',
            'detaljnije..' => '<a href="#" class="js-more-link" title="Hourly forecast"><img src="/images/search.svg" alt="More"></a>',
        ]);

        $table = preg_replace('/Zadnja izmjena (.*?) u (.*?)\./', 'Last updated $1 at $2.', $table);

        $forecastTable = $table;

        // DHMZ keeps the hourly data in these parallel hidden tables, one
        // <tr data-row="N"> per day (N matches the 7-day rows' data-col), one
        // <td> per hour. scripts.js reads them to build the hourly view.
        foreach (['tabl_sat', 'tabl_simb', 'tabl_temp', 'tabl_vjet', 'tabl_obor', 'tabl_prob'] as $tableId) {
            $hourlyTables .= extractTable($html, $tableId);
        }
    }
?>

<div id="js-content" class="container" data-area="weather">

    <h1 class="page-title text-center jumbotron">Weather forecast</h1>

    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-stacked weather" id="accordion">
                <?php $groupIndex = 0; foreach ($areas as $group => $places): ?>
                    <?php $panelId = 'acc-group-' . $groupIndex; $hasActive = isset($places[$code]); ?>
                    <li class="panel">
                        <a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#<?= $panelId ?>">
                            <?= $group ?>
                        </a>
                        <ol id="<?= $panelId ?>" class="collapse<?= $hasActive ? ' in' : '' ?>">
                            <?php foreach ($places as $cipher => $name): ?>
                                <li<?= $cipher === $code ? ' class="active"' : '' ?>>
                                    <a href="?code=<?= rawurlencode($cipher) ?>"><?= $name ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </li>
                    <?php $groupIndex++; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-10">
            <h3 class="text-center alert alert-success">
                <?= $cityNames[$code] ?> &ndash; 7-day forecast
            </h3>

            <?php if ($forecastTable): ?>
                <div id="js-weather-forecast" class="table-responsive">
                    <?= $forecastTable ?>
                </div>

                <div id="js-weather-hourly" class="table-responsive" style="display: none;">
                    <a href="#" class="js-back btn btn-default btn-sm">&larr; Back to 7-day forecast</a>
                    <h4 id="js-hourly-title" class="text-center"></h4>
                    <table id="js-hourly-table"></table>
                </div>

                <div id="js-weather-source" style="display: none;"><?= $hourlyTables ?></div>

                <p class="text-center text-muted">
                    Source:
                    <a href="<?= htmlspecialchars($url) ?>" target="_blank" rel="noopener">meteo.hr (DHMZ)</a>
                </p>
            <?php else: ?>
                <div class="alert alert-warning text-center">
                    <p class="lead">The forecast for <?= $cityNames[$code] ?> is currently unavailable.</p>
                    <p>
                        <a href="<?= htmlspecialchars($url) ?>" target="_blank" rel="noopener" class="btn btn-info">
                            Open the forecast on meteo.hr
                        </a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php include('footer.php'); ?>
