<h3 class="page-header"><?= $this->course->name; ?></h3>
<div class="row">
	<div class="col-md-12">
		<section class="block track-head">
			<h4>Course Overview</h4>
			<div class="body">

				<div class="row">
					<div class="col-md-12">
						<div class="track-user">
							<h5>Course Progress</h5>
							<p>Course Completion <span class="earned-number"><?= number_format($this->course->getFastPercentageForUser($this->user), 0) . "%"; ?></span></p>
							<p>Points Earned <span class="earned-number"><?= $this->course->pointsForUser($this->user); ?></span></p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">

						<!-- User Progress in Category -->
						<div class="track-progress">

							<h5>Progress Breakdown</h5>

							<?php 
							$numCourses = count($this->course->getCourseTopics());
							$progressWidth = (100 - ($numCourses - 1)) / $numCourses;
							?>

							<?php foreach($this->course->getCourseTopics() as $topic): ?>

							<?php 

								$topic_extras = '';

								if($topic->premium) {
									$topic_extras = 'premium';
								} else if($topic->locked) {
									$topic_extras = 'locked';
								}

							?>

							<a style="<?php echo "width:" . $progressWidth . "%"; ?>" data-html="true" data-toggle="popover" title="<?= $topic->name; ?>" data-placement="bottom" data-trigger="hover" data-content="<ul class='track-progress-list'>
								<?php 
								foreach($topic->getSubTopics() as $subtopic) {

									?>
									<?php if($subtopic->userHasViewed()) { ?>
									<li><i class='fa fa-fw fa-check'></i> <?= $subtopic->name ?></li>
									<?php } else { ?>
									<li><i class='fa fa-fw fa-chevron-right muted'></i> <?= $subtopic->name ?></li>
									<?php } ?>

									<?php } ?>
								</ul>" class="<?php $k= $topic->getProgressOverview(); echo $k['topic_status']; ?> <?= $topic_extras ?>" href="#">

								<?php if($topic->premium) { ?>
									<i class="fa fa-asterisk"></i>
								<?php } else if($topic->locked) { ?>
									<i class="fa fa-lock hidden-xs hidden-sm"></i>
								<?php } ?>

							</a>

							<?php endforeach; ?> 


						</div>

						<div class="well well-sm color-legend">
							<article class="legend-available"><i class="fa fa-fw fa-square"></i> Available</article>
							<article class="legend-started"><i class="fa fa-fw fa-square"></i> Started</article>
							<article class="legend-completed"><i class="fa fa-fw fa-square"></i> Completed</article>
							<article class="legend-locked"><i class="fa fa-fw fa-square"></i> Locked</article>
							<article class="legend-premium"><i class="fa fa-fw fa-square"></i> Premium</article>
						</div>

					</div>
				</div>

			</div>
		</section>
	</div>

	<div class="col-md-12">

		<div class="block track-course panel-group" id="accordion">

			<?php foreach($this->course->getCourseTopics() as $topic): ?>

				<?php $k1 = $topic->getProgressOverview(); $percentComplete=$k1['percentage']; ?>

				<div class="panel panel-default <?=  $topic->available($this->user) ? "" : "locked" ?>">
					<div class="panel-heading">
						<a class="panel-link" data-toggle="collapse" data-parent="#accordion" href="<?php echo "#sub-topic-" . $topic->topic_id; ?>">
							<h4 class="panel-title">								
								<?= $topic->name; ?> <small><?= $percentComplete; ?>% Complete <i class="fa fa-fw fa-chevron-down"></i></small>								
							</h4>
						</a>
					</div>

					<?php

						foreach($this->resume_point as $resume) {
							if($resume['course_id'] == $this->course->course_id) {
								$resume_topic = $resume['topic_id'];
							}
						}

						$topics_id_array = array();

						$topics_array = $topic->getSubTopics();
						foreach($topics_array as $tas) {
							
							array_push($topics_id_array, $tas->topic_id);
							
						}

						if( isset($resume_topic) && in_array($resume_topic, $topics_id_array) ) {

					?>

					<div id="<?php echo "sub-topic-" . $topic->topic_id; ?>" class="panel-collapse collapse in">

					<?php	

						} else {

					?>

					<div id="<?php echo "sub-topic-" . $topic->topic_id; ?>" class="panel-collapse collapse">

					<?php

						}

					?>

						<div class="panel-body">

							<div class="course-subcategories">
								<ul>

									<?php 

										//If there are no sub topics show main topic content
									$topics_ar = $topic->getSubTopics();
									if(count($topics_ar) == 0){
										$topic->name='Course Materials';
										$topics_ar[] = $topic;
									}

									foreach($topics_ar as $subtopic) {

										$contentCount = $subtopic->getContentCount();
										$first = $subtopic->getFirstContent();
										$progressOverview = $subtopic->getProgressOverview();
									?>

										<li class="subcategory">
											<?php if($subtopic->available($this->user)): ?>
												<a href="<?= base_url(); ?>content/review/<?php echo $first ? encode($first->content_id) : -1; ?>">
											<?php else: ?>
												<a href='#' onclick="return false;">
											<?php endif; ?>
												<?php if(!$subtopic->available($this->user)) { ?>
													<div class="check-mark">
														<span class="fa-stack">
															<i class="fa fa-square fa-stack-2x"></i>
															<i class="fa fa-lock fa-stack-1x fa-inverse"></i>
														</span>
													</div>
												<?php } else if ($subtopic->premium) { ?>
													<span class="fa-stack">
														<i class="fa fa-square fa-stack-2x color-premium"></i>
													</span>
												<?php } else if($subtopic->userHasCompleted()){ ?> 
												<div class="check-mark completed">
													<span class="fa-stack">
														<i class="fa fa-square fa-stack-2x color-completed"></i>
													</span>
												</div>
												<?php } else if($subtopic->hasUserStarted($this->user)) { ?>
												<div class="check-mark">
													<span class="fa-stack">
														<i class="fa fa-square fa-stack-2x color-started"></i>
													</span>
												</div>
												<?php } else { ?>
												<div class="check-mark">
													<span class="fa-stack">
														<i class="fa fa-square fa-stack-2x color-available"></i>
													</span>
												</div>
												<?php } ?>

												<div class="description">
													<h5>
														<?= $subtopic->name ?>
													</h5>

													<span><i class="fa fa-fw fa-video-camera"></i></span>
													<span><i class="fa fa-fw fa-file"></i></span>
												</div>
											</a>
										</li>

									<?php } ?>


								</ul>

								<div class="exams">

									<div class="row">

										<?php 
										$userexams = array(
											UserExam_model::LoadByUserIdTopicIdExamType($this->user->user_id, $topic->topic_id, 1),
											UserExam_model::LoadByUserIdTopicIdExamType($this->user->user_id, $topic->topic_id, 2),
											UserExam_model::LoadByUserIdTopicIdExamType($this->user->user_id, $topic->topic_id, 3)
											);
											?>

										<?php $i = 0; foreach($userexams as $ue): ?>

										<?php
											// if the attempt is null, it needs to look at the previous attempt to see what status it should have
										$progress = $topic->getProgressOverview($this->user, false);
										$this->load->model("Exams_model");
										$is_premium = Exams_model::IsPremium($topic->topic_id, ($i+1));
										$is_user_premium = $this->user->isPremium();
										if(!$topic->available($this->user) || $progress["topic_status"] != "completed") {
											$status = "Locked";
										} 
										else if($is_premium && !$is_user_premium) {
											$status = "premium";
										}
										else if($ue == null)
										{
												// If this is the fisrst exam, show it with "begin" as its message.
											if(($i == 0 || ($userexams[$i-1] != null && $userexams[$i-1]->status == "C"))) {
												$exam_href = base_url()."exam/getexam/".encode($topic->topic_id)."/".encode($i+1);
												$status = "Begin";
											} else {
												$status = "Locked";
											}
										}
											// Otherwise, base on the status of this either show "review" or "resume"
										else if($ue->status == "I") {
											$exam_href = base_url()."exam/getexam/".encode($topic->topic_id)."/".encode($i+1)."/".encode($ue->exam_id);
											$status = "Resume";
										} else if($ue->status == "C") {
											$exam_href = base_url()."exam/getexam/".encode($topic->topic_id)."/".encode($i+1)."/".encode($ue->exam_id);
											$status = "Review";
											$this->load->model("Badges_model");
											$badge = Badges_model::getBadesBasedOnCriteria($ue->score, "exam", $ue->exam_id);
											if($badge) {
												$badge = $badge[0];
												$badge_icon = $badge->icon_path;
											} else {
												$badge_icon = "fa fa-fw fa-trophy";
											}
										}
										?>

										<?php if (strtolower($status) == "locked") { ?>
										<div class="col-sm-4 subcategory exam locked">
											<a>
												<div class="learning-type">
													<i class="fa fa-fw fa-lock"></i>
													<h5><?php if($i+1 == 1) { echo 'Apprentice'; } else if($i+1 == 2) { echo 'Senior';} else if($i+1 == 3) { echo 'Master';}?><br/>Exam</h5>
												</div>
											</a>
										</div>
										<?php } else if(strtolower($status) == "premium") { ?>
										<div class="col-sm-4 subcategory exam premium">
											<a>
												<div class="learning-type">
													<i class="fa fa-fw fa-asterisk"></i>
													<h5><?php if($i+1 == 1) { echo 'Apprentice'; } else if($i+1 == 2) { echo 'Senior';} else if($i+1 == 3) { echo 'Master';}?><br/>Exam</h5>
												</div>
											</a>
										</div>
										<?php } else { ?>
										<div class="col-sm-4 subcategory exam <?php if(strtolower($status) == "review") { ?>completed<?php } ?>">

											<a href="<?= $exam_href ?>">
												<div class="learning-type">
													<?php if(strtolower($status) == "review") { ?>
														<i class='<?= $badge_icon; ?>'></i>
													<?php } else { ?>
														<i class="fa fa-fw fa-edit"></i>
													<?php } ?>

													<h5><?php if($i+1 == 1) { echo 'Apprentice'; } else if($i+1 == 2) { echo 'Senior';} else if($i+1 == 3) { echo 'Master';}?><br/>Exam</h5>
													
												</div>
											</a>
										</div>
										<?php } ?>

										<?php $i++; endforeach; ?>

									</div>


									<!-- <ul> -->
										<!-- <td>
											<?php
												// if the attempt is null, it needs to look at the previous attempt to see what status it should have
												if($ue == null)
												{
													// If this is the fisrst exam, show it with "begin" as its message.
													if($i == 0)
														echo "<a href='".base_url()."exam/getexam/".encode($topic->topic_id)."/".encode($i+1)."'>Begin</a>";
													// Otherwise, check if the previous attempt is null
													// If its not, and the status is complete, show begin for this level
													else if($userexams[$i-1] != null && $userexams[$i-1]->status == "C")
														echo "<a href='".base_url()."exam/getexam/".encode($topic->topic_id)."/".encode($i+1)."'>Begin</a>";
													// If the previous attempt is null, or not complete, don't show anything for this level.
												}
												// Otherwise, base on the status of this either show "review" or "resume"
												else if($ue->status == "I")
													echo "<a href='".base_url()."exam/getexam/".encode($topic->topic_id)."/".encode($i+1)."/".encode($ue->exam_id)."'>Resume</a>";
												else if($ue->status == "C")
													echo "<a href='".base_url()."exam/getexam/".encode($topic->topic_id)."/".encode($i+1)."/".encode($ue->exam_id)."'>Review</a>";
											?>
										</td> -->


										


										<!-- </ul> -->

								</div>

							</div>

						</div>
					</div>
				</div>

			<?php endforeach; ?>


		</div>

	</div>
</div>




<!-- 
<h1><?= $this->course->name; ?></h1>
<p><?= $this->course->description; ?></p>

<table style="width:100%;">
	<thead><tr><th>Topic</th><th>View Content</th><th>Level 1</th><th>Level 2</th><th>Level 3</th></tr></thead>
	<tbody>
		<?php foreach($this->course->getCourseTopics() as $topic): ?>
			<?php 
				$userexams = array(
					UserExam_model::LoadByUserIdTopicIdExamType($this->user->user_id, $topic->topic_id, 1),
					UserExam_model::LoadByUserIdTopicIdExamType($this->user->user_id, $topic->topic_id, 2),
					UserExam_model::LoadByUserIdTopicIdExamType($this->user->user_id, $topic->topic_id, 3)
				);
			?>
			<tr>
				<td><?= $topic->name; ?></td>
				<td><a href='<?= base_url(); ?>student/course/<?= $this->course->course_id; ?>/content/<?= $topic->topic_id; ?>'>View Content</a></td>
				<?php $i = 0; foreach($userexams as $ue): ?>
					<td>
						<?php
							// if the attempt is null, it needs to look at the previous attempt to see what status it should have
							if($ue == null)
							{
								// If this is the fisrst exam, show it with "begin" as its message.
								if($i == 0)
									echo "<a href='".base_url()."exam/getexam/".encode($topic->topic_id)."/".encode($i+1)."'>Begin</a>";
								// Otherwise, check if the previous attempt is null
								// If its not, and the status is complete, show begin for this level
								else if($userexams[$i-1] != null && $userexams[$i-1]->status == "C")
									echo "<a href='".base_url()."exam/getexam/".encode($topic->topic_id)."/".encode($i+1)."'>Begin</a>";
								// If the previous attempt is null, or not complete, don't show anything for this level.
							}
							// Otherwise, base on the status of this either show "review" or "resume"
							else if($ue->status == "I")
								echo "<a href='".base_url()."exam/getexam/".encode($topic->topic_id)."/".encode($i+1)."/".encode($ue->exam_id)."'>Resume</a>";
							else if($ue->status == "C")
								echo "<a href='".base_url()."exam/getexam/".encode($topic->topic_id)."/".encode($i+1)."/".encode($ue->exam_id)."'>Review</a>";
						?>
					</td>
				<?php $i++; endforeach; ?>
			</tr>
		<?php endforeach; ?> 
	</tbody>
</table> -->
