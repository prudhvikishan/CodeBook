

<h3 class="page-header">School Leaderboard</h3>
<div class="row block leaderboard">
	<div class="col-md-12">	
		<div class='body'>
			<div class="filter-options">
				<ul class="nav">
					<?php foreach($this->schoolLeaderboard as $key => $value): ?>
						<li class="<?= $value['class'] ?>"><a href="#leaderboard-<?= $key; ?>" data-toggle="tab"><?= $value["title"]; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="tab-content">
				<?php foreach($this->schoolLeaderboard as $key => $value): ?>
					<div class="tab-pane <?= $value['class']; ?>" id="leaderboard-<?= $key ?>">
						<table class="table">
						<thead><tr><th>School</th><th>Section</th><th>Points</th></tr></thead>
						<tbody>
							<?php foreach($value["leaderboard"] as $row): ?>	
								<tr>
									<td><?= $row->schoolname; ?></td>
									<td><?= $row->section; ?></td>
									<td><?= $row->points; ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>