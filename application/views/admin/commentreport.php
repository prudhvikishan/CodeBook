<h3 class="page-header">Admin Reports</h3>

<section class="block track-head">
	<h4>Question Report</h4>
	<div class="body">

		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered dt">
					<thead><tr><th>Content Id</th><th>Content Name</th><th>User Name</th><th>School Name</th><th>Comment</th><th>Posted on</th></tr></thead>
					<tbody>
						<?php foreach($this->results as $row): ?>	
							<tr>
								<td><a href='<?= base_url(); ?>content/review/<?= encode($row->content_id); ?>'><?= $row->content_id; ?></a></td>
								<td><?= $row->name; ?></td>
								<td><?= $row->firstname; ?> <?= $row->lastname; ?></td>
								<td><?= $row->school_name; ?></td>
								<td><?= $row->comment; ?></td>
								<td><?= $row->posted_on; ?></td>
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








