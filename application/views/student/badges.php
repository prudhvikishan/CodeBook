<h3 class="page-header">Achievements</h3>

<div class="row">
	<div class="col-md-12">

		<section class="block user-badges">
			<h4>Badge Overview</h4>
			<div class="body">

				<!-- Badge Overview, needs data -->
				<div class="badges">
					<div class="row">
						<?php if($this->user->getBadgeCounts()) { ?>
							<?php foreach($this->user->getBadgeCounts() as $badge): ?>
								<div class="col-sm-2 col-xs-6">
									<div><i class="<?= $badge["badge"]->icon_path ?>"></i></div>

									<!-- Need query to get # of each type of badge, fill in data here -->
									<h5><?= $badge["count"] ?></h5>
									<h6>
										<!-- <?= $badge['badge']->badge_name; ?> Badge 
										<br/>-->
										(
											<?php switch($badge['badge']->badge_name) {
												case "Bronze":
													echo "> 60% Score";
													break;
												case "Silver":
													echo "> 70% Score";
													break;
												case "Gold":
													echo "> 85% Score";
													break;
												case "100% complete":
													echo "Course Complete";
													break;
												case "No":
													echo "No Badge";
													break;
											}
											?>
										)
									</h6>
								</div>
							<?php endforeach; ?>		
						<?php } else { ?>
							<div class="center">You have not earned any badges yet.</div>
						<?php } ?>				
					</div>
						
				</div>

			</div>
		</section>

	</div>

	<div class="col-md-12">
		<section class="block user-badges">
			<!-- Name of topic -->
			<h4>Badges</h4>
			<div class="body">

				<!-- Badge information -->
				<div class="badges">

					
					<table>
						<thead>
							<tr>
								<td>Topic</td>
								<td>Apprentice</td>
								<td>Senior</td>
								<td>Master</td>
								<td>100% Complete</td>
							</tr>

						<tbody>
							<!-- For each should now go here -->
							<?php foreach($this->user->badgesByTopic() as $topic => $badges): ?>
							<?php 
								// NOTE this is a terrible hack...sorry 
								$allBadges = array("Apprentice Exam", "Senior Exam", "Master Exam", "100% Completion"); 
								$topic = Topics_model::LoadById($topic);
								$course = Courses_model::LoadById($topic->getParentInfo());
								if($course->isIntroCourse()) {
									$allBadges = array("-","-","-","100% Completion");
								}
								$topic = $topic->name;
							?>
							<tr>
								<td><?= $topic; ?></td>

								<?php foreach($allBadges as $search): ?>
									<?php $match = null; ?>
									<?php foreach($badges as $badge){ ?>
										<?php
											if($search=="-")
											{
												$match = "-";
												break ;

											}
											if($badge->label == $search) {
												$match = $badge;
												break ;
											}
										?>
									<?php } ?>
								

										<?php if($match == "-"): ?>
										<td>
											<i data-toggle="tooltip" data-placement="bottom" title="None" class="fa fa-fw fa-minus"></i>
										</td>
										<?php else: ?>
										<?php if($match == null): ?>	
										<td>
											<i data-toggle="tooltip" data-placement="bottom" title="None" class="fa fa-fw fa-lock"></i>
										</td>
										<?php else: ?>
										<td>
											<i data-toggle="tooltip" data-placement="bottom" title="<?= $badge->badge_name; ?>" class="<?= $badge->icon_path; ?>"></i>
										</td>
									<?php endif; ?>
									<?php endif; ?>
								<?php endforeach; ?>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
						
				</div>

			</div>
		</section>
	</div>









	<!-- For each -->

	<!-- <div class="col-md-6">
		<?php foreach($this->user->badgesByTopic() as $topic => $badges): ?>
		<?php 
			// NOTE this is a terrible hack...sorry 
			$allBadges = array("Apprentice Exam", "Senior Exam", "Master Exam", "100% Completion"); 
			$topic = Topics_model::LoadById($topic);
			$course = Courses_model::LoadById($topic->getParentInfo());
			if($course->isIntroCourse()) {
				$allBadges = array("100% Completion");
			}
			$topic = $topic->name;
		?>
		<section class="block user-badges">
			<h4><?= $topic ?></h4>
			<div class="body">

				<div class="badges">

					<div class="row">
					<?php foreach($allBadges as $search): ?>
						<?php $match = null; ?>
						<?php foreach($badges as $badge){ ?>
							<?php
								if($badge->label == $search) {
									$match = $badge;
									break ;
								}
							?>
						<?php } ?>
						<?php if($match == null): ?>				
							<div class="col-sm-3 col-xs-6">
								<i data-toggle="tooltip" data-placement="bottom" title="None" class="fa fa-fw fa-trophy"></i>
								<h6><?= $search; ?></h6>
							</div>
						<?php else: ?>
							<div class="col-sm-3 col-xs-6">
								<i data-toggle="tooltip" data-placement="bottom" title="<?= $badge->badge_name; ?>" class="<?= $badge->icon_path; ?>"></i>
								<h6><?= $badge->label; ?></h6>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
					</div>
						
				</div>

			</div>
		</section>
		<?php endforeach; ?>
	</div> -->

	<!-- End for each -->

</div>