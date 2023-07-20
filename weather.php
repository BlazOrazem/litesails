<?php
    include('header.php');
    include('nav.php');

    $pathThree = 'https://prognoza.hr/3dslika2_print_tp_e.php?Code=';
    $pathSeven = 'https://prognoza.hr/7dslika2_print_tp_e.php?Code=';
?>

<div id="js-content" class="container" data-area="weather">

    <h1 class="page-title text-center jumbotron">Weather forecast</h1>

    <div class="row">
        <div class="col-md-2">
            <ul class="nav nav-stacked weather" id="accordion">
                <li class="panel">
                    <a class="bg-info" data-toggle="collapse" data-parent="#accordion" href="#acc7day">7-day forecast</a>
                    <ol id="acc7day" class="collapse">
                        <li class="dropdown-header">Istarska ž.</li>
                        <li><a href="<?= $pathSeven ?>14301">Poreč</a></li>
                        <li><a href="<?= $pathSeven ?>14303">Rovinj</a></li>
                        <li><a href="<?= $pathSeven ?>14307">Pula</a></li>
                        <li class="dropdown-header">Primorsko-goranska ž.</li>
                        <li><a href="<?= $pathSeven ?>14317">Rijeka</a></li>
                        <li><a href="<?= $pathSeven ?>14314">Mali Lošinj</a></li>
                        <li><a href="<?= $pathSeven ?>14006">Krk</a></li>
                        <li class="dropdown-header">Ličko-senjska ž.</li>
                        <li><a href="<?= $pathSeven ?>14323">Senj</a></li>
                        <li class="dropdown-header">Zadarska ž.</li>
                        <li><a href="<?= $pathSeven ?>14008">Pag</a></li>
                        <li><a href="<?= $pathSeven ?>14432">Maslenica</a></li>
                        <li><a href="<?= $pathSeven ?>14007">Nin</a></li>
                        <li><a href="<?= $pathSeven ?>14428">Zadar</a></li>
                        <li class="dropdown-header">Šibensko-kninska ž.</li>
                        <li><a href="<?= $pathSeven ?>14438">Šibenik</a></li>
                        <li class="dropdown-header">Splitsko-dalmatinska ž.</li>
                        <li><a href="<?= $pathSeven ?>14445">Split</a></li>
                        <li><a href="<?= $pathSeven ?>14454">Makarska</a></li>
                        <li><a href="<?= $pathSeven ?>14447">Hvar</a></li>
                        <li><a href="<?= $pathSeven ?>14005">Korčula</a></li>
                        <li class="dropdown-header">Dubrovačko-neretvanska ž.</li>
                        <li><a href="<?= $pathSeven ?>14462">Ploče</a></li>
                        <li><a href="<?= $pathSeven ?>14016">Orebić</a></li>
                        <li><a href="<?= $pathSeven ?>14472">Dubrovnik</a></li>
                        <li><a href="<?= $pathSeven ?>14474">Čilipi</a></li>
                    </ol>
                </li>
                <li class="panel">
                    <a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#accIstarska">Istarska</a>
                    <ol id="accIstarska" class="collapse">
                        <li><a href="<?= $pathThree ?>NP_Brijuni">Brijuni (NP Brijuni)</a></li>
                        <li><a href="<?= $pathThree ?>Buje">Buje</a></li>
                        <li><a href="<?= $pathThree ?>Buzet">Buzet</a></li>
                        <li><a href="<?= $pathThree ?>Fazana">Fazana</a></li>
                        <li><a href="<?= $pathThree ?>Groznjan">Grožnjan</a></li>
                        <li><a href="<?= $pathThree ?>Kanfanar">Kanfanar</a></li>
                        <li><a href="<?= $pathThree ?>Labin">Labin</a></li>
                        <li><a href="<?= $pathThree ?>Lupoglav">Lupoglav</a></li>
                        <li><a href="<?= $pathThree ?>Medulin">Medulin</a></li>
                        <li><a href="<?= $pathThree ?>Motovun">Motovun</a></li>
                        <li><a href="<?= $pathThree ?>Novigrad">Novigrad</a></li>
                        <li><a href="<?= $pathThree ?>Pazin">Pazin</a></li>
                        <li><a href="<?= $pathThree ?>Porec">Poreč</a></li>
                        <li><a href="<?= $pathThree ?>Pula">Pula</a></li>
                        <li><a href="<?= $pathThree ?>Zracna_luka_Pula">Pula Loborika (ZL)</a></li>
                        <li><a href="<?= $pathThree ?>Rovinj">Rovinj</a></li>
                        <li><a href="<?= $pathThree ?>Savudrija">Savudrija</a></li>
                        <li><a href="<?= $pathThree ?>Umag">Umag</a></li>
                        <li><a href="<?= $pathThree ?>Vodnjan">Vodnjan</a></li>
                        <li><a href="<?= $pathThree ?>Vrsar">Vrsar</a></li>
                        <li><a href="<?= $pathThree ?>Zminj">Žminj</a></li>
                    </ol>
                </li>
                <li class="panel">
                    <a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#accPrimorskoGoranska">Primorsko-goranska</a>
                    <ol id="accPrimorskoGoranska" class="collapse">
                        <li><a href="<?= $pathThree ?>Bakar">Bakar</a></li>
                        <li><a href="<?= $pathThree ?>Baska">Baška (Krk)</a></li>
                        <li><a href="<?= $pathThree ?>Cres">Cres</a></li>
                        <li><a href="<?= $pathThree ?>Crikvenica">Crikvenica</a></li>
                        <li><a href="<?= $pathThree ?>Kostrena">Kostrena</a></li>
                        <li><a href="<?= $pathThree ?>Kraljevica">Kraljevica</a></li>
                        <li><a href="<?= $pathThree ?>Krk">Krk</a></li>
                        <li><a href="<?= $pathThree ?>Most_Krk">Krk most</a></li>
                        <li><a href="<?= $pathThree ?>Lopar">Lopar (Rab)</a></li>
                        <li><a href="<?= $pathThree ?>Lovran">Lovran</a></li>
                        <li><a href="<?= $pathThree ?>Lubenice">Lubenice (Cres)</a></li>
                        <li><a href="<?= $pathThree ?>Mali_Losinj">Mali Lošinj</a></li>
                        <li><a href="<?= $pathThree ?>Zracna_luka_Mali_Los">Mali Lošinj (ZL)</a></li>
                        <li><a href="<?= $pathThree ?>Malinska">Malinska (Krk)</a></li>
                        <li><a href="<?= $pathThree ?>Moscenicka_Draga">Mošćenička Draga</a></li>
                        <li><a href="<?= $pathThree ?>Nerezine">Nerezine (Lošinj)</a></li>
                        <li><a href="<?= $pathThree ?>Novi_Vinodolski">Novi Vinodolski</a></li>
                        <li><a href="<?= $pathThree ?>Opatija">Opatija</a></li>
                        <li><a href="<?= $pathThree ?>Porozina">Porozina (Cres)</a></li>
                        <li><a href="<?= $pathThree ?>Povile">Povile</a></li>
                        <li><a href="<?= $pathThree ?>Rab">Rab</a></li>
                        <li><a href="<?= $pathThree ?>Rijeka">Rijeka</a></li>
                        <li><a href="<?= $pathThree ?>Zracna_luka_Rijeka">Rijeka Omišalj (ZL)</a></li>
                        <li><a href="<?= $pathThree ?>Selce">Selce</a></li>
                        <li><a href="<?= $pathThree ?>Unije">Unije</a></li>
                        <li><a href="<?= $pathThree ?>Urinj">Urinj</a></li>
                    </ol>
                </li>
                <li class="panel">
                    <a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#accLickoSenjska">Ličko-senjska</a>
                    <ol id="accLickoSenjska" class="collapse">
                        <li><a href="<?= $pathThree ?>Baske_Ostarije">Baške Oštarije</a></li>
                        <li><a href="<?= $pathThree ?>Brinje">Brinje</a></li>
                        <li><a href="<?= $pathThree ?>Donji_Lapac">Donji Lapac</a></li>
                        <li><a href="<?= $pathThree ?>Gornja_Ploca">Gornja Ploča</a></li>
                        <li><a href="<?= $pathThree ?>Gospic">Gospić</a></li>
                        <li><a href="<?= $pathThree ?>Jablanac">Jablanac</a></li>
                        <li><a href="<?= $pathThree ?>Karlobag">Karlobag</a></li>
                        <li><a href="<?= $pathThree ?>Korenica">Korenica</a></li>
                        <li><a href="<?= $pathThree ?>Krasno-NP_Sjeverni_V">Krasno</a></li>
                        <li><a href="<?= $pathThree ?>Licki_Osik">Lički Osik</a></li>
                        <li><a href="<?= $pathThree ?>Novalja">Novalja (Pag)</a></li>
                        <li><a href="<?= $pathThree ?>Otocac">Otočac</a></li>
                        <li><a href="<?= $pathThree ?>Perusic">Perušić</a></li>
                        <li><a href="<?= $pathThree ?>NP_Plitvicka_jezera">NP Plitvička jezera</a></li>
                        <li><a href="<?= $pathThree ?>Prizna">Prizna</a></li>
                        <li><a href="<?= $pathThree ?>Senj">Senj</a></li>
                        <li><a href="<?= $pathThree ?>Udbina">Udbina</a></li>
                        <li><a href="<?= $pathThree ?>Zavizan">Zavižan (NP Sj. Velebit)</a></li>
                    </ol>
                </li>
                <li class="panel">
                    <a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#accZadarska">Zadarska</a>
                    <ol id="accZadarska" class="collapse">
                        <li><a href="<?= $pathThree ?>Benkovac">Benkovac</a></li>
                        <li><a href="<?= $pathThree ?>Biograd">Biograd</a></li>
                        <li><a href="<?= $pathThree ?>Bozava">Božava (Dugi otok)</a></li>
                        <li><a href="<?= $pathThree ?>Gracac">Gračac</a></li>
                        <li><a href="<?= $pathThree ?>Ist">Ist</a></li>
                        <li><a href="<?= $pathThree ?>Maslenica">Maslenica</a></li>
                        <li><a href="<?= $pathThree ?>Molat">Molat</a></li>
                        <li><a href="<?= $pathThree ?>Nin">Nin</a></li>
                        <li><a href="<?= $pathThree ?>Obrovac">Obrovac</a></li>
                        <li><a href="<?= $pathThree ?>Olib">Olib</a></li>
                        <li><a href="<?= $pathThree ?>Pag">Pag</a></li>
                        <li><a href="<?= $pathThree ?>Most_Pag">Pag most</a></li>
                        <li><a href="<?= $pathThree ?>Pakostane">Pakoštane</a></li>
                        <li><a href="<?= $pathThree ?>Polaca">Polača</a></li>
                        <li><a href="<?= $pathThree ?>Posedarje">Posedarje</a></li>
                        <li><a href="<?= $pathThree ?>Povljana">Povljana</a></li>
                        <li><a href="<?= $pathThree ?>Razanac">Ražanac</a></li>
                        <li><a href="<?= $pathThree ?>Sali">Sali</a></li>
                        <li><a href="<?= $pathThree ?>Silba">Silba</a></li>
                        <li><a href="<?= $pathThree ?>Starigrad-NP_Pakleni">Starigrad-Paklenica (NP)</a></li>
                        <li><a href="<?= $pathThree ?>Sukosan">Sukošan</a></li>
                        <li><a href="<?= $pathThree ?>Sveti_Rok">Sveti Rok</a></li>
                        <li><a href="<?= $pathThree ?>Tkon">Tkon (Pašman)</a></li>
                        <li><a href="<?= $pathThree ?>Ugljan">Ugljan</a></li>
                        <li><a href="<?= $pathThree ?>Vir">Vir</a></li>
                        <li><a href="<?= $pathThree ?>Zadar">Zadar</a></li>
                        <li><a href="<?= $pathThree ?>Zracna_luka_Zadar">Zadar Zemunik (ZL)</a></li>
                    </ol>
                </li>
                <li class="panel">
                    <a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#accSibeskoKninska">Šibensko-kninska</a>
                    <ol id="accSibeskoKninska" class="collapse">
                        <li><a href="<?= $pathThree ?>Drnis">Drniš</a></li>
                        <li><a href="<?= $pathThree ?>Knin">Knin</a></li>
                        <li><a href="<?= $pathThree ?>NP_Kornati">Kornati (NP Kornati)</a></li>
                        <li><a href="<?= $pathThree ?>Lozovac-NP_Krka">Lozovac (NP Krka)</a></li>
                        <li><a href="<?= $pathThree ?>Murter">Murter</a></li>
                        <li><a href="<?= $pathThree ?>Pirovac">Pirovac</a></li>
                        <li><a href="<?= $pathThree ?>Primosten">Primošten</a></li>
                        <li><a href="<?= $pathThree ?>Rogoznica">Rogoznica</a></li>
                        <li><a href="<?= $pathThree ?>Skradin">Skradin</a></li>
                        <li><a href="<?= $pathThree ?>Sibenik">Šibenik</a></li>
                        <li><a href="<?= $pathThree ?>Tisno">Tisno (Murter)</a></li>
                        <li><a href="<?= $pathThree ?>Tribunj">Tribunj</a></li>
                        <li><a href="<?= $pathThree ?>Vodice">Vodice</a></li>
                        <li><a href="<?= $pathThree ?>Vrpolje">Vrpolje</a></li>
                        <li><a href="<?= $pathThree ?>Zlarin">Zlarin</a></li>
                        <li><a href="<?= $pathThree ?>zirje">Žirje</a></li>
                    </ol>
                </li>
                <li class="panel">
                    <a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#accSplitskoDalmatinska">Splitsko-dalmatinska</a>
                    <ol id="accSplitskoDalmatinska" class="collapse">
                        <li><a href="<?= $pathThree ?>Baska_Voda">Baška Voda</a></li>
                        <li><a href="<?= $pathThree ?>Bisevo">Biševo</a></li>
                        <li><a href="<?= $pathThree ?>Bisko">Bisko</a></li>
                        <li><a href="<?= $pathThree ?>Bol">Bol (Brač)</a></li>
                        <li><a href="<?= $pathThree ?>Brela">Brela</a></li>
                        <li><a href="<?= $pathThree ?>Cista_Provo">Cista Provo</a></li>
                        <li><a href="<?= $pathThree ?>Drvenik">Drvenik</a></li>
                        <li><a href="<?= $pathThree ?>Dugopolje">Dugopolje</a></li>
                        <li><a href="<?= $pathThree ?>Gradac">Gradac</a></li>
                        <li><a href="<?= $pathThree ?>Hvar">Hvar</a></li>
                        <li><a href="<?= $pathThree ?>Imotski">Imotski</a></li>
                        <li><a href="<?= $pathThree ?>Jelsa">Jelsa (Hvar)</a></li>
                        <li><a href="<?= $pathThree ?>Komiza">Komiža (Vis)</a></li>
                        <li><a href="<?= $pathThree ?>Lovrec">Lovreć</a></li>
                        <li><a href="<?= $pathThree ?>Makarska">Makarska</a></li>
                        <li><a href="<?= $pathThree ?>Milna">Milna (Brač)</a></li>
                        <li><a href="<?= $pathThree ?>Omis">Omiš</a></li>
                        <li><a href="<?= $pathThree ?>Palagruza">Palagruža</a></li>
                        <li><a href="<?= $pathThree ?>Zivogosce">Podgora</a></li>
                        <li><a href="<?= $pathThree ?>Podstrana">Podstrana</a></li>
                        <li><a href="<?= $pathThree ?>Postire">Postira</a></li>
                        <li><a href="<?= $pathThree ?>Povlja">Povlja</a></li>
                        <li><a href="<?= $pathThree ?>Prgomet">Prgomet</a></li>
                        <li><a href="<?= $pathThree ?>Ravca">Ravča</a></li>
                        <li><a href="<?= $pathThree ?>Sinj">Sinj</a></li>
                        <li><a href="<?= $pathThree ?>Solin">Solin</a></li>
                        <li><a href="<?= $pathThree ?>Split">Split</a></li>
                        <li><a href="<?= $pathThree ?>Zracna_luka_Split">Split Resnik (ZL)</a></li>
                        <li><a href="<?= $pathThree ?>Starigrad">Stari Grad (Hvar)</a></li>
                        <li><a href="<?= $pathThree ?>Sumartin">Sumartin (Brač)</a></li>
                        <li><a href="<?= $pathThree ?>Supetar">Supetar (Brač)</a></li>
                        <li><a href="<?= $pathThree ?>Sutivan">Sutivan (Brač)</a></li>
                        <li><a href="<?= $pathThree ?>sestanovac">Šestanovac</a></li>
                        <li><a href="<?= $pathThree ?>Solta">Šolta</a></li>
                        <li><a href="<?= $pathThree ?>Trilj">Trilj</a></li>
                        <li><a href="<?= $pathThree ?>Trogir">Trogir</a></li>
                        <li><a href="<?= $pathThree ?>Tucepi">Tučepi</a></li>
                        <li><a href="<?= $pathThree ?>Vis">Vis</a></li>
                        <li><a href="<?= $pathThree ?>Vrgorac">Vrgorac</a></li>
                        <li><a href="<?= $pathThree ?>Vrlika">Vrlika</a></li>
                        <li><a href="<?= $pathThree ?>Zagvozd">Zagvozd</a></li>
                        <li><a href="<?= $pathThree ?>Zrnovnica">Žrnovnica</a></li>
                    </ol>
                </li>
                <li class="panel">
                    <a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#accDubrovackoNeretvanska">Dubrovačko-neretvanska</a>
                    <ol id="accDubrovackoNeretvanska" class="collapse">
                        <li><a href="<?= $pathThree ?>Blato">Blato (Korčula)</a></li>
                        <li><a href="<?= $pathThree ?>Cavtat">Cavtat</a></li>
                        <li><a href="<?= $pathThree ?>Dubrovnik">Dubrovnik</a></li>
                        <li><a href="<?= $pathThree ?>Zracna_luka_Dubrovni">Dubrovnik Čilipi (ZL)</a></li>
                        <li><a href="<?= $pathThree ?>Govedari">Goveđari (NP Mljet)</a></li>
                        <li><a href="<?= $pathThree ?>Gruda">Gruda</a></li>
                        <li><a href="<?= $pathThree ?>Kolocep">Koločep</a></li>
                        <li><a href="<?= $pathThree ?>Korcula">Korčula</a></li>
                        <li><a href="<?= $pathThree ?>Korita-NP_Mljet">Korita (Mljet)</a></li>
                        <li><a href="<?= $pathThree ?>Kuna">Kuna</a></li>
                        <li><a href="<?= $pathThree ?>Lastovo">Lastovo</a></li>
                        <li><a href="<?= $pathThree ?>Lopud">Lopud</a></li>
                        <li><a href="<?= $pathThree ?>Lumbarda">Lumbarda (Korčula)</a></li>
                        <li><a href="<?= $pathThree ?>Metkovic">Metković</a></li>
                        <li><a href="<?= $pathThree ?>Opuzen">Opuzen</a></li>
                        <li><a href="<?= $pathThree ?>Orebic">Orebić</a></li>
                        <li><a href="<?= $pathThree ?>Ploce">Ploče</a></li>
                        <li><a href="<?= $pathThree ?>Prevlaka">Prevlaka</a></li>
                        <li><a href="<?= $pathThree ?>Rogotin">Rogotin</a></li>
                        <li><a href="<?= $pathThree ?>Slano">Slano</a></li>
                        <li><a href="<?= $pathThree ?>Ston">Ston</a></li>
                        <li><a href="<?= $pathThree ?>Uskoplje">Uskoplje</a></li>
                        <li><a href="<?= $pathThree ?>Trstenik">Trstenik</a></li>
                        <li><a href="<?= $pathThree ?>Trsteno">Trsteno</a></li>
                        <li><a href="<?= $pathThree ?>Vela_Luka">Vela Luka (Korčula)</a></li>
                    </ol>
                </li>
                <li class="panel">
                    <a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#accZracneLuke">Zračne luke</a>
                    <ol id="accZracneLuke" class="collapse">
                        <li><a href="<?= $pathThree ?>Zracna_luka_Dubrovni">Dubrovnik Čilipi</a></li>
                        <li><a href="<?= $pathThree ?>Zracna_luka_Mali_los">Mali Lošinj</a></li>
                        <li><a href="<?= $pathThree ?>Zracna_luka_Pula">Pula Loborika</a></li>
                        <li><a href="<?= $pathThree ?>Zracna_luka_Rijeka">Rijeka Omišalj</a></li>
                        <li><a href="<?= $pathThree ?>Zracna_luka_Split">Split Resnik</a></li>
                        <li><a href="<?= $pathThree ?>Zracna_luka_Zadar">Zadar Zemunik</a></li>
                    </ol>
                </li>
                <li class="panel">
                    <a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#accNacionalniParkovi">Nacionalni parkovi</a>
                    <ol id="accNacionalniParkovi" class="collapse">
                        <li><a href="<?= $pathThree ?>NP_Brijuni">Brijuni</a></li>
                        <li><a href="<?= $pathThree ?>NP_Kornati">Kornati</a></li>
                        <li><a href="<?= $pathThree ?>Govedari">Mljet</a></li>
                    </ol>
                </li>
            </ul>
        </div>
        <div class="col-md-10">
            <iframe src="<?= $pathSeven ?>14307" id="weather" width="100%" height="1200"></iframe>
        </div>
    </div>

</div>

<?php include('footer.php'); ?>
