<?php
    include_once('header.php');
    include_once('nav.php');

    $html = 'https://meteo.hr/prognoze.php?section=prognoze_specp&param=pomorci';

    if (!$doc = phpQuery::newDocumentFileHTML($html)) {
        $doc = null;
    }
?>

<div id="js-content" class="container" data-area="sea">

    <h1 class="page-title text-center jumbotron">Sea forecast</h1>

    <ul class="nav nav-tabs nav-justified" role="tablist">
        <li class="active">
            <a href="#recap" data-toggle="tab">Quick recap</a>
        </li>
        <li>
            <a href="#forecast" data-toggle="tab">Descriptive forecast</a>
        </li>
        <li>
            <a href="#waves" data-toggle="tab">Wave direction and height</a>
        </li>
        <li>
            <a href="#info" data-toggle="tab">Info</a>
        </li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="recap">
            <?php
                if ($warning = pq("h5:contains('Upozorenje')")->next('div')->html()) {
                    echo '
                        <br />
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
                        $data = [];
                        $table = pq("table#table-aktualni-podaci");

                        foreach ($table['th'] as $th) {
                            $data[] = pq($th)->text();
                        }

                        foreach ($table['td'] as $td) {
                            $data[] = pq($td)->text();
                        }

                        $data = array_chunk($data, 6);
                    ?>
                    <h2 class="text-center alert alert-success">Adriatic sea forecast</h2>
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
                </div>
            </div>
        </div>

        <div class="tab-pane" id="forecast">
            <div class="row">
                <div class="col col-md-4">
                    <div class="alert alert-warning">
                        <h3 class="text-info">North Adriatic</h3>
                        <?php
                            if ($northAdriatic = pq("h5:contains('Sjeverni Jadran')")->next('div')->html()) {
                                echo "{$northAdriatic}";
                            }
                        ?>
                    </div>
                </div>
                <div class="col col-md-4">
                    <div class="alert alert-warning">
                        <h3 class="text-info">Middle Adriatic</h3>
                        <?php
                            if ($middleAdriatic = pq("h5:contains('Srednji Jadran')")->next('div')->html()) {
                                echo "{$middleAdriatic}";
                            }
                        ?>
                    </div>
                </div>
                <div class="col col-md-4">
                    <div class="alert alert-warning">
                        <h3 class="text-info">South Adriatic</h3>
                        <?php
                            if ($southAdriatic = pq("h5:contains('Južni Jadran')")->next('div')->html()) {
                                echo "{$southAdriatic}";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="waves">
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
                    <a href="#" class="animation-play btn btn-success" data-hours="[1,2,3,4]">Play animation</a>
                    <a href="#" class="animation-stop btn btn-info">Stop animation</a>
                </p>
                <div id="js-sea-forecast-frame">
                    <img src="https://prognoza.hr/valovi/val_w_1.png" id="js-sea-forecast-image" class="img-responsive center-block" />
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
                        $data = [];
                        $douglasScale = pq("h5:contains('Douglasova skala')")->next('table');

                        foreach ($douglasScale['th'] as $th) {
                            $data[] = str_replace('1', ' ',  pq($th)->text());
                        }

                        foreach ($douglasScale['td'] as $td) {
                            $data[] = str_replace('glatko,1zrcalno,1bonaca', 'glatko, zrcalno, bonaca', pq($td)->text());
                        }

                        $data = array_chunk($data, 4);
                    ?>
                    <h3 class="text-center alert alert-success">Douglas scale</h3>
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
                </div>
            </div>
            <div class="row">
                <div class="col col-xs-12 center-block">
                    <h3 class="text-center alert alert-success">Map of the Adriatic</h3>
                    <img src="https://prognoza.hr/podjela_jadran.gif" class="adriatic-map img-responsive center-block" />
                </div>
            </div>
        </div>

    </div>

</div>

<?php include_once('footer.php'); ?>
