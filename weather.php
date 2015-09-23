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
			</ul>
		</div>
		<div class="col-md-9">
			<iframe src="http://prognoza.hr/tri_print.php?id=tri&param=Splitsko-dalmatinska&code=Split" id="weather" frameborder="0" width="100%" height="700"></iframe>
		</div>
	</div>

</div>

<?php include('footer.php'); ?>