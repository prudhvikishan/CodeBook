<h3 class="page-header">Admin Reports</h3>

<section class="block track-head">
	<h4>Gold Coin Redemption Report</h4>
	<div class="body">

		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered dt">
					<thead><tr><th>User Id</th><th>User Name</th><th>Reward Name</th><th>Reward Desc</th><th>Reward Cost</th><th>Redemption on</th></tr></thead>
					<tbody>
						<?php foreach($this->results as $row): ?>	
							<tr>
								<td><?= $row->user_id; ?></td>
								<td><?= $row->firstname; ?> <?= $row->lastname; ?></td>
								<td><?= $row->reward_name; ?></td>
								<td><?= $row->description; ?></td>
								<td><?= $row->cost; ?></td>
								<td><?= $row->transaction_date; ?></td>
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








