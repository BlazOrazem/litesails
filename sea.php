<?php include('header.php'); ?>

<?php include('nav.php'); ?>

<div class="container">

	<div class="row">
		<div class="col col-lg-12 center-block">
			<?php
				$html = 'http://www.dhmz.htnet.hr/prognoza/prognoze.php?id=pomorci';
				$doc = phpQuery::newDocumentFileHTML($html);
				$table = pq("p:contains('VRIJEME NA JADRANU')")->next('table');

				$data = array();
				foreach($table['td'] as $td)
				{
					$data[] = pq($td)->text();
				}
				$data = array_chunk($data, 6);
			?>
			<table class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
				<tr class="bg-info">
					<?php
					foreach ($data[0] as $title) {
						echo('<th>'.$title.'</th>');
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
							echo('<td>'.$cell.'</td>');
						}
						echo('</tr>');
					}
					?>
				</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-12 center-block">
			<?php
				$douglasScale = pq("b:contains('Douglasova skala')")->next('p')->next('table');

				$data = array();
				foreach($douglasScale['td'] as $td)
				{
					$data[] = pq($td)->text();
				}
				$data = array_chunk($data, 4);
			?>
			<h3>Douglas scale</h3>
			<table class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
				<tr class="bg-info">
					<?php
					foreach ($data[0] as $title) {
						echo('<th>'.$title.'</th>');
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
							echo('<td>'.$cell.'</td>');
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

<?php include('footer.php'); ?>