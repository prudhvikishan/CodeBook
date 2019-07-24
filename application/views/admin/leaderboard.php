<h3 class="page-header">Admin Reports</h3>

<section class="block track-head">
	<h4>Student Leaderboard</h4>
	<div class="body">

		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered dt">
					<thead><tr><th>User ID</th><th>Name</th><th>School</th><th>Points</th><th>Level</th></tr></thead>
					<tbody>
						<?php foreach($this->results as $row): ?>	
							<tr>
								<td><?= $row->user_id; ?></td>
								<td><?= $row->firstname . " " . $row->lastname; ?></td>
								<td><?= $row->schoolname; ?></td>
								<td><?= $row->points; ?></td>
								<td><?= $row->level; ?></td>
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