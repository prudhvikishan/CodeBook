
<?php $count = count($this->results); ?>
<h3 class="page-header">Admin Reports</h3>

<section class="block track-head">
	<h4>User Registrations ( <?php echo $count?> )</h4>
	<div class="body">

		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered dt">
					<thead><tr><th>User ID</th><th>Name</th><th>School Name</th><th>City</th><th>State</th><th>Email</th><th>Phone</th><th>Status</th></tr></thead>
					<tbody>
						<?php foreach($this->results as $row): ?>	
							<tr>
								<td><?= $row->user_id; ?></td>
								<td><a href='<?= base_url(); ?>admin/user/<?= $row->user_id; ?>'><?= $row->firstname . " " . $row->lastname; ?></a></td>
								<td><?= $row->name; ?></td>
								<td><?= $row->city; ?></td>
								<td><?= $row->state; ?></td>
								<td><?= $row->email; ?></td>
								<td><?= $row->phone; ?></td>
								
					
								<td><?= $row->is_account_verified; ?>, <?= $row->user_status; ?>, <?= $row->user_created; ?></td>								
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