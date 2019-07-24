
<h1>Activity for <?= $this->viewUser->getName(); ?></h1>

<h2>User Stats</h2>
<div class='row'>
	<div class='col-md-6'>
		<table class="table">
			<tr>
				<th>Points</th>
				<td><?= $this->viewUser->getTotalPoints(); ?></td>
			</tr>
			<tr>
				<th>Level</th>
				<td><?= $this->viewUser->getLevel(); ?></td>
			</tr>
			<tr>
				<th>Name</th>
				<td><?= $this->viewUser->getName(); ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?= $this->viewUser->email; ?></td>
			</tr>
			<tr>
				<th>Phone</th>
				<td><?= $this->viewUser->phone; ?></td>
			</tr>
			<tr>
				<th>Recent Interactions</th>
				<td>
					<?php 
						$interactions = $this->viewUser->getRecentInteractions(5); 
						foreach($interactions as $i) {
							// var_dump($i);
							echo "[" . $i->timestamp . "] ";
							switch($i->type) {
								case "C":
									echo "Completed " . $i->name;
									break ;
								case "V":
									echo "Viewed " . $i->name;
									break ;
								case "Exam Attempt":
									echo "Exam Completed in " . $i->name;
									break ;
								default:
									echo $i->type . " - " . $i->name;
									break ;
							}
							echo "<br />";
						}
					?>
				</td>
			</tr>
		</table>
	</div>
</div>
<hr />

<h2>Exam Breakdown</h2>
<div class="row">
	<table class='table'>
		<thead>
			<tr>
				<th>Topic</th>
				<th>Exam Level</th>
				<th>Score</th>
				<th>Date Completed</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($this->examAttempts as $row): ?>
				<tr>
					<td><a href="<?php echo base_url()."exam/getexam/".encode('0')."/".encode($row->exam_type)."/". encode($row->exam_id) ?>"><?= $row->name ?></a></td>
					<td><?= $row->exam_type ?></td>
					<td><?= $row->score ?></td>
					<td><?= $row->finished ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<hr />
<h2>Content Breakdown</h2>
Coming soon...

<hr />



<script>
	$(document).ready(function() {
		$('.table').dataTable();
	});
</script>