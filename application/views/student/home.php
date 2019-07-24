<style type="text/css">
	.badge-icon { width: 50px; }
</style>

<h3 class="page-header">Dashboard</h3>
<?php if(!empty($this->announcements)) { ?>
	<div class="row">

		<div class="col-md-12">
			<section class="block messages">
				<h4>Announcements</h4>
				<div class="body">

					<!-- Announcements -->
					<ul>
						<?php foreach($this->announcements as $a): ?>
							<li>
								<div class="message-type"><i class="fa fa-fw fa-pencil"></i></div>
								<div class='message-text'><?= $a->content; ?> - posted on : <?= $a->posted_on; ?></div>
								<!-- <div class="message-text">The pracice exam form Algebra I is now available. <span class="action">[ <a href="#">Start Exam</a> ]</span></div> -->
							</li>
						<?php endforeach; ?>
					</ul>

				</div>
			</section>
		</div>

	</div>
<?php } ?>

<div class="row">

	<div class="col-md-8">

		<section class="block messages">
			<h4>Your Courses</h4>
			<div class="body">
				<?php if(isset($this->courses) ){?>

					<?php foreach($this->courses as $course): 
							$courseid = $course->course_id;
							$topicid = 0;
							$topicname = '';
						 if(isset($this->resume_point)){
						 foreach($this->resume_point as $r_course): 
							if($r_course['course_id'] == $course->course_id){
							$topicid = $r_course['topic_id'];
							$topicname = $r_course['topic_name'];
						}
						if($topicid) {
							$this->load->model("Topics_model");
							$topic = Topics_model::LoadById($topicid);
							$firstContentId = $topic->getFirstContent();
							$firstContentId = $firstContentId->content_id;
						}
						 endforeach; ?>
						<?php }?>
						<div class="topic-resume">

							<div class="row">
								
								<div class="col-xs-6 col-md-6">
									<h5 class="home-topic"><?= $course->name ?></h5>
								</div>
								<div class="col-md-3 hidden-sm">

								</div>
								<div class="col-xs-6 col-md-3">
									<?php if($topicid !=0 ){?>
									<a href="<?= base_url(); ?>student/learning_map/<?= encode($course->course_id); ?>#sub-topic-<?= $topic->topic_id; ?>" class="btn btn-sm btn-secondary btn-block"><i class="fa fa-fw fa-play"></i> Resume</a>
									<?php } else {?>
									<a href="<?= base_url(); ?>student/learning_map/<?= encode($course->course_id); ?>" class="btn btn-sm btn-secondary btn-block"><i class="fa fa-fw fa-play"></i> Start</a>
									<?php }?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<?php if($topicname != ''){?>
									<p>Most Recent Topic: <strong><?php echo $topicname; ?></strong></p>
									<?php } else { ?>
									<p>Most Recent Topic: <strong>Not Started</strong></p>
									<?php }?>
								</div>
							</div>
							<div class="course-resume">
							</div>

						</div>
						<?php endforeach; ?>

				<?php }?>

			</div>
		</section>

	 <section class="block leaderboard">
			<h4>
				Leaderboard
			</h4>
			<div class="body"> 
			<?php if($this->leaderboard != null) {?>
				<div class="tab-content">
					<div class="tab-pane active" id="leaderboard-all">
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
								<?php foreach ($this->leaderboard as $entry): ?>
									<tr <?= ($entry->user_id == $this->user->user_id ? "class='leaderboard-user'" : ""); ?>>
										<td><?= $entry->rank; ?></td>
										<td><?= $entry->firstname ?> <?= $entry->lastname ?></td>
										<td><?= $entry->level; ?></td>
										<td><?= $entry->points; ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<?php } else {?>
				<p>Welcome to codebook. You can begin scoring by starting the <strong>Introduction to codebook</strong> video from <strong>Your Courses</strong> section on the top.</p>
				<?php }?>
			</div>
		</section>
	</div>

	<div class="col-md-4">
		<section class="block user-stats">
			<h4><?= $this->user->getName(); ?></h4>
			<div class="body">

				<!-- User information -->
				<article>
					<div class="row mb">
						<div class="col-sm-6">
							<div class="earned-content">
								<h5>Level</h5>
								<p class="center big show_level"><?= $this->user->getLevel(); ?></p>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="earned-content">
								<h5>Coins</h5>
								<p class="center big"><?= $this->user->getGoldCoinCount(); ?></p>
							</div>
						</div>
					</div>
					<div class="row mb">
						<div class="col-sm-12">
							<div class="earned-content">
								<h5>Points</h5>
								<?php $total_points = $this->user->getTotalPoints();?>
								<p class="center big show_total_points"><?= $total_points; ?></p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="earned-content">

								<?php 
									$temp =  $this->user->getNextLevelInfo();
									$percent_complete = number_format( ( $total_points / $temp["next_level_points"] ) * 100, 1 ); 
								?>

								<h5>Level Progress</h5>
								<div class="progress">
								  <div class="progress-bar progress-bar-level" role="progressbar" aria-valuenow="<?= $percent_complete; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $percent_complete; ?>%">
								    <span class="sr-only"><span class='show_percent_complete'><?= $percent_complete; ?></span>% Complete (success)</span>
								  </div>
								</div>
								<div class="col-sm-12 center">
									<p><span class='show_total_points'><?= $total_points; ?></span> / <span class='show_next_level_points'><?= $temp["next_level_points"]; ?></span></p>
								</div>
							</div>
						</div>
					</div>
				</article>

				<article>
					<h5 class="divider">Recent Badges</h5>
					<div class="badges center">
						<?php foreach($this->recent_badges as $badge): ?>
							<a data-toggle="tooltip" data-placement="bottom" title="<?= $badge["message"]; ?>" class="badge fa-stack fa-2x">
								<!-- <img src='<?= base_url() . $badge["image"]; ?>' class='badge-icon' /> -->
								<i class='<?= $badge["image"]; ?>'></i>
							</a>	
						<?php endforeach;?>
					</div>
				</article>

			</div>
		</section>

		<section class="block messages">
			<h4>Community</h4>
			<div class="body">

				<!-- News -->
				<?php if($this->newsfeed) { ?>
					<ul>
						<?php foreach($this->newsfeed as $news): ?>
							<li>
								<div class='message-type'><i class='fa fa-fw fa-trophy'></i></div>
								<div class="message-text"><?= Users_model::LoadById($news["user_id"])->getName(); ?> <?= $news["message"]; ?></div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php } else { ?>

					<div class="center">There is no news to display.</div>

				<?php } ?>

			</div>
		</section>
	</div>

</div>

<script>
//	$(function(){
//		$.get(base_url + "student/point_data", {}, function(data){
//			
//			$(".show_level").html(data.current_level);
//			$(".show_total_points").html(data.total_points);
//			$(".progress-bar-level").attr("aria-valuenow", data.percent_complete);
//			$(".progress-bar-level").css("width", data.percent_complete + "%");
//			$(".show_next_level_points").html(data.next_level_points);
//			$(".show_percent_complete").html(data.percent_complete);
///
//		}, "json");
//	}); 
</script>