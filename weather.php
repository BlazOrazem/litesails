<?php include('header.php'); ?>

<?php include('nav.php'); ?>

<div class="container">

	<div class="row">
		<div class="col-md-3">
			<ul class="nav nav-stacked weather" id="accordion">
				<li class="panel">
					<a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#acc1">Split Bay Area</a>
					<ol id="acc1" class="collapse">
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Splitsko-dalmatinska&code=Split">Split</a></li>
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Splitsko-dalmatinska&code=Trogir">Trogir</a></li>
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Splitsko-dalmatinska&code=Drvenik">Drvenik</a></li>
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Splitsko-dalmatinska&code=Solta">Šolta</a></li>
					</ol>
				</li>
				<li class="panel">
					<a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#acc2">Hvar & Korčula</a>
					<ol id="acc2" class="collapse">
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Splitsko-dalmatinska&code=Jelsa">Jelsa (H)</a></li>
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Splitsko-dalmatinska&code=Hvar">Hvar</a></li>
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Dubrovacko-neretvanska&code=Vela_Luka">Vela Luka (K)</a></li>
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Dubrovacko-neretvanska&code=Lumbarda">Lumbarda (K)</a></li>
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Dubrovacko-neretvanska&code=Korcula">Korčula</a></li>
					</ol>
				</li>
				<li class="panel">
					<a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#acc3">Vis & Biševo</a>
					<ol id="acc3" class="collapse">
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Splitsko-dalmatinska&code=Vis">Vis</a></li>
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Splitsko-dalmatinska&code=Komiza">Komiža (V)</a></li>
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Splitsko-dalmatinska&code=Bisevo">Biševo</a></li>
					</ol>
				</li>
				<li class="panel">
					<a class="bg-success" data-toggle="collapse" data-parent="#accordion" href="#acc4">Lastovo & Mljet</a>
					<ol id="acc4" class="collapse">
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Dubrovacko-neretvanska&code=Lastovo">Lastovo</a></li>
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Dubrovacko-neretvanska&code=Govedari">Goveđari (M)</a></li>
						<li><a href="http://prognoza.hr/tri_print.php?id=tri&param=Dubrovacko-neretvanska&code=Dubrovnik">Dubrovnik</a></li>
					</ol>
				</li>
				<li class="panel">
					<a class="bg-info" data-toggle="collapse" data-parent="#accordion" href="#acc5">7 day forecast</a>
					<ol id="acc5" class="collapse">
						<li class="dropdown-header">Istra & Kvarner</li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14301">Poreč</a></li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam.php?id=sedam&param=Hrvatska&code=14303">Rovinj</a></li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14307">Pula</a></li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14317">Rijeka</a></li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14006">Krk</a></li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14323">Senj</a></li>
						<li class="dropdown-header">Zadar Area</li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14008">Pag</a></li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14007">Nin</a></li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14428">Zadar</a></li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14438">Šibenik</a></li>
						<li class="dropdown-header">Split Area</li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14445">Split</a></li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14454">Makarska</a></li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14462">Ploče</a></li>
						<li class="dropdown-header">Dubrovnik Area</li>
						<li><a href="http://www.dhmz.htnet.hr/prognoza/sedam_print.php?id=sedam&param=Hrvatska&code=14472">Dubrovnik</a></li>
					</ol>
				</li>
			</ul>
		</div>
		<div class="col-md-9">
			<iframe src="http://prognoza.hr/tri_print.php?id=tri&param=Splitsko-dalmatinska&code=Split" id="weather" frameborder="0" width="100%" height="700"></iframe>
		</div>
	</div>

</div>

<?php include('footer.php'); ?>