<h3 class="page-header">Admin Reports</h3>

<section class="block track-head">
	<h4>School Report</h4>
	<div class="body">

		<div class="row">
			<div class="col-md-12">

				<table class="table table-bordered dt">
					<thead><tr><th>School</th><th>Section</th><th>No. of Students</th><th>Points</th></tr></thead>
					<tbody>
						<?php foreach($this->results as $row): ?>	
							<tr>
								<td><?= $row->schoolname; ?></td>
								<td><?= $row->section; ?></td>
								<td><?= $row->totalstudents; ?></td>
								<td><?= $row->points; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</section>

<script>
	$(document).ready(function() {

		$('.dt').dataTable();

	});
</script>







