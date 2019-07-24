<h3 class="page-header">Learderboard</h3>

<div class="row">

	<div class="col-md-12">

		<section class="block leaderboard">
			<h4>
				Monthly Rankings
			</h4>
			<div class="body">

				<!-- Leaderboard Filter Options -->
				<div class="filter-options">
					<ul class="nav">
						<li class="active"><a href="#month-leaderboard-all" data-toggle="tab">All</a></li>
						<?php foreach($this->courses as $course): ?>
							<li><a href="#month-leaderboard-<?= $course->course_id; ?>" data-toggle="tab"><?= $course->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>

				<!-- Leaderboard -->
				<div class="tab-content">
					<div class="tab-pane active" id="month-leaderboard-all">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Rank</th>
									<th>Name</th>
									<th>Level</th>
									<th>Points</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($this->MonthlyLeaderboard as $entry): ?>
									<tr <?= ($entry->user_id == $this->user->user_id ? "class='leaderboard-user'" : ""); ?>>
										<td><?= $entry->row; ?></td>
										<td><?= $entry->user->getName(); ?></td>
										<td><?= $entry->user->getLevel(); ?></td>
										<td><?= $entry->user->getTotalPointsThisMonth(); ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php foreach($this->courses as $course): ?>
						<div class="tab-pane" id="month-leaderboard-<?= $course->course_id; ?>">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Rank</th>
										<th>Name</th>
										<th>Level</th>
										<th>Points</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($course->MonthlyLeaderboard as $entry): ?>
										<tr <?= ($entry->user_id == $this->user->user_id ? "class='leaderboard-user'" : ""); ?>>
											<td><?= $entry->row; ?></td>
											<td><?= $entry->user->getName(); ?></td>
											<td><?= $entry->user->getLevel(); ?></td>
											<td><?= $entry->user->getTotalPointsByCourse($course->course_id); ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="block leaderboard">
			<h4>
				All Time Rankings
			</h4>
			<div class="body">

				<!-- Leaderboard Filter Options -->
				<div class="filter-options">
					<ul class="nav">
						<li class="active"><a href="#all-leaderboard-all" data-toggle="tab">All</a></li>
						<?php foreach($this->courses as $course): ?>
							<li><a href="#all-leaderboard-<?= $course->course_id; ?>" data-toggle="tab"><?= $course->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>

				<!-- Leaderboard -->
				<div class="tab-content">
					<div class="tab-pane active" id="all-leaderboard-all">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Rank</th>
									<th>Name</th>
									<th>Level</th>
									<th>Points</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($this->AllTimeLeaderboard as $entry): ?>
									<tr <?= ($entry->user_id == $this->user->user_id ? "class='leaderboard-user'" : ""); ?>>
										<td><?= $entry->row; ?></td>
										<td><?= $entry->user->getName(); ?></td>
										<td><?= $entry->user->getLevel(); ?></td>
										<td><?= $entry->user->getTotalPoints(); ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php foreach($this->courses as $course): ?>
						<div class="tab-pane" id="all-leaderboard-<?= $course->course_id; ?>">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Rank</th>
										<th>Name</th>
										<th>Level</th>
										<th>Points</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($course->AllTimeLeaderboard as $entry): ?>
										<tr <?= ($entry->user_id == $this->user->user_id ? "class='leaderboard-user'" : ""); ?>>
											<td><?= $entry->row; ?></td>
											<td><?= $entry->user->getName(); ?></td>
											<td><?= $entry->user->getLevel(); ?></td>
											<td><?= $entry->user->getTotalPointsByCourse($course->course_id); ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</section>

	</div>

</div>