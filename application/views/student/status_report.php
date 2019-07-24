<h3 class="page-header">Weekly Status Report</h3>

<div class="row">

	<div class="col-md-8">

		<section class="block progress-report">
			<h4>Progress Report</h4>
			<div class="body">

				<?php if(isset($this->allcourses) ){?>

					<div class="row">
						
						<?php foreach($this->allcourses as $course): ?>

							<div class="col-md-12">
								<h3><?= $course->name ?></h3>
								Username
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="<?= rand(0, 50); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= rand(0, 50); ?>%;">
										<span class="sr-only"><?= rand(0, 50); ?>% Complete</span>
									</div>
									<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= rand(0, 50); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= rand(0, 50); ?>%;">
										<span class="sr-only"><?= rand(0, 50); ?>% Complete</span>
									</div>
								</div>

								Classmates
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="<?= rand(0, 50); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= rand(0, 50); ?>%;">
										<span class="sr-only"><?= rand(0, 50); ?>% Complete</span>
									</div>
									<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= rand(0, 50); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= rand(0, 50); ?>%;">
										<span class="sr-only"><?= rand(0, 50); ?>% Complete</span>
									</div>
								</div>
							</div>

						<?php endforeach; ?>

					</div>

				<?php }?>

			</div>
		</section>

		<section class="block progress-report">
			<h4>Report Card</h4>
			<div class="body">

				Maybe show a graph here similar to the report card but for exams taken over the course of the week? If none were taken this section can be omitted.

			</div>
		</section>

	</div>

	<div class="col-md-4">

		<section class="block messages">
			<h4>Badges Report</h4>
			<div class="body">

				Insert badges earned over the course of the report here.

			</div>
		</section>

		<section class="block messages">
			<h4>Points Report</h4>
			<div class="body">

				Points Earned This Week

			</div>
		</section>

		<section class="block messages">
			<h4>Achievement Report</h4>
			<div class="body">

				<ul>

					<li>
						<div class="message-type"><i class="fa fa-fw fa-video-camera"></i></div>
						<div class="message-text"><a href="#">Username</a> watched the Order Of Operations video.</div>
					</li>
					<li>
						<div class="message-type"><i class="fa fa-fw fa-star"></i></div>
						<div class="message-text"><a href="#">Username</a> earned 150 points for completing the Algebra I practice exam.</div>
					</li>
					<li>
						<div class="message-type"><i class="fa fa-fw fa-pencil"></i></div>
						<div class="message-text"><a href="#">Username</a> completed the Algebra I practice exam.</div>
					</li>
					<li>
						<div class="message-type"><i class="fa fa-fw fa-trophy"></i></div>
						<div class="message-text"><a href="#">Username</a> earned the Trigonometry Apprentice badge.</div>
					</li>
					<li>
						<div class="message-type"><i class="fa fa-fw fa-book"></i></div>
						<div class="message-text"><a href="#">Username</a> completed the Trigonometric Equations course.</div>
					</li>

				</ul>

			</div>
		</section>

	</div>

</div>