<h3 class="page-header">Profile <small><a href="<?= site_url('student/edit_profile'); ?>">Edit</a></small></h3>

<div class="row">

	<div class="col-md-4">

		<section class="block user-stats">
			<h4><?= $this->user->getName();?></h4>
			<div class="body">

				<!-- User information -->
				<article>
					<img class="user-profile" src="<?= base_url(); ?>images/default_gravatar.jpg" alt="gravatar" />
				</article>

				<article>
					<h5 class="divider">Level</h5>
					<div class="level">
						<?= $this->user->getLevel(); ?>
					</div>
				</article>

				<article>
					<h5 class="divider">Points</h5>
					<div class="points">
						<?= $this->user->getTotalPoints(); ?>
					</div>
				</article>

			</div>
		</section>

	</div>

	<div class="col-md-8">
		
		<!--
		<section class="block user-rank">
			<h4>Ranking</h4>
			<div class="body">

				<div class="row">
					<div class="col-md-4">

						<div class="overall-rank">
							<p><?php echo $this->overallRank; ?></p>
							<span>Overall</span>
						</div>

					</div>

					<div class="col-md-8">

						<div class="subject-rank">
							<h5>Rank By Subject</h5>
							<?php foreach ($this->courses as $course) {?>
							<p><?php  echo $course['course_name'] ?><span class="rank"><?php  echo $course['course_rank'] ?></span></p>
							<?php }?>
						</div>

					</div>
				</div>

			</div>
		</section>
	-->

		<section class="block messages">
			<h4>Recent Activity</h4>
			<div class="body">

				<!-- Activity information -->
				<?php if($this->newsfeed) { ?>
				<ul>
					<?php foreach($this->newsfeed as $news): ?>
						<li>
							<div class='message-type'><i class='fa fa-fw fa-trophy'></i></div>
							<div class="message-text"><a href="#"><?= Users_model::LoadById($news["user_id"])->getName(); ?></a> <?= $news["message"]; ?></div>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php } else { ?>
					<div class="center">You have no recent activity.</div>
				<?php } ?>

			</div>
		</section>

		<section class="block user-badges">
			<h4>Badges</h4>
			<div class="body">

				<!-- Badge information -->
				<div class="badges">

					<?php if($this->badges) { ?>

						<?php foreach($this->badges as $badge) {?>
								<a data-toggle="tooltip" data-placement="bottom" title="<?php echo $badge['message'];?>" >
									<img src="<?= base_url(); ?><?php echo $badge['image'];?>" width="70px" height="70px" >
								</a>
						<?php }?>

					<?php } else { ?>

						<div class="center">You have not earned any badges yet.</div>

					<?php } ?>
						
					</div>
				

			</div>
		</section>

	</div>

</div>