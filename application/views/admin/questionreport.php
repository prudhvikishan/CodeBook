<h3 class="page-header">Admin Reports</h3>

<section class="block track-head">
	<h4>Question Report</h4>
	<div class="body">

		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered dt">
					<thead><tr><th>Question Id</th><th>Topic Name</th><th>No. of times appeared</th><th>No. of times answered correctly</th><th>No. of times answered wrongly</th></tr></thead>
					<tbody>
						<?php foreach($this->results as $row): ?>	
							<tr>
								<td><a href='<?= base_url(); ?>question/edit/<?= $row->question_id; ?>'><?= $row->question_id; ?></a></td>
								<td><?= $row->name; ?></td>
								<td><?= $row->no_of_times_appeared; ?></td>
								<td><?= $row->no_of_times_answered_correct; ?></td>
								<td><?= $row->no_of_times_answered_wrong; ?></td>
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








