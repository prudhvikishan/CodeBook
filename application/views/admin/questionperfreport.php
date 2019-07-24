<h3 class="page-header">Admin Reports</h3>

<section class="block track-head">
	<h4>Question Perf Report</h4>
	<div class="body">

		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered dt">
					<thead><tr><th>User Id</th><th>Topic Name</th><th>Right Answers</th><th>Wrong Answers</th></tr></thead>
					<tbody>
						<?php foreach($this->results as $row): ?>	
							<tr>
								<td><?= $row->userid; ?></td>
								<td><?= $row->topic; ?></td>
								<td><?= $row->rightanswers; ?></td>
								<td><?= $row->wronganswers; ?></td>
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
		$('.dt').dataTable({
	        "order": [[ 1, "desc" ]]
	    } );
	});
</script>








