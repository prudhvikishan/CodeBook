<!-- Static navbar -->
<div class="navbar navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php $link = $this->user->user_home() == null ? base_url() : $this->user->user_home(); ?>
			<a class="navbar-brand" href="<?= $link; ?>">codebook</a>
		</div>
		<div class="navbar-collapse collapse">
		<?php if($this->user->isIntroComplete()){?>
			<ul class="nav navbar-nav">
				<li><a href="<?= $link; ?>">Dashboard</a></li>
				<?php if(isset($this->allcourses) ){?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Learn <i class="fa fa-fw fa-angle-down"></i></a>
						<ul class="dropdown-menu">
							<?php foreach($this->allcourses as $course): ?>
							<?php if(!$course->isIntroCourse()) { ?>
								<li><a href="<?= site_url('student/learning_map/' . encode($course->course_id) ); ?>"><?= $course->name ?></a></li>
							<?php } endforeach; ?>
						</ul>
					</li>
				<?php }?>
				<li class='dropdown'>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <i class="fa fa-fw fa-angle-down"></i></a>
					<ul class='dropdown-menu'>
						<li><a href="<?= site_url("student/report_card"); ?>">Report Card</a></li>
						<li><a href="<?= site_url("student/activity"); ?>">Activity Report</a></li>
						<li><a href="<?= site_url("student/focus"); ?>">Focus</a></li>
						<li><a href="<?= site_url("student/question_report"); ?>">Strength</a></li>
					</ul>
				</li>
				<!-- <li><a href="<?= site_url('student/school_leaderboard'); ?>">Leaderboard</a></li> -->
				<li><a href="<?= site_url('student/badges'); ?>">Achievements</a></li>
			<!-- 	<li><a href="<?= site_url('student/rewards'); ?>">Rewards</a></li> -->
				<?php if($this->user->hasRole("A")): ?>
					<li class='dropdown'>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <i class="fa fa-fw fa-angle-down"></i></a>
						<ul class='dropdown-menu'>
							<li><a href="<?= site_url("admin/registration"); ?>">User Registration Report</a></li>
							<li><a href="<?= site_url("admin/users"); ?>">User Activity Report</a></li>
							<li><a href="<?= site_url("admin/leaderboard"); ?>">Student Leaderboard</a></li>
							<li><a href="<?= site_url("admin/schoolreport"); ?>">School Report</a></li>
							<li><a href="<?= site_url("admin/questionreport"); ?>">Question Report</a></li>
							<li><a href="<?= site_url("admin/awardpoints"); ?>">Award Points</a></li>
							<li><a href="<?= site_url("admin/sendemail"); ?>">Send Email</a></li>
							<li><a href="<?= site_url("admin/commentreport"); ?>">Comment Report</a></li>
							<li><a href="<?= site_url("admin/coinredemptionreport"); ?>">Gold Coin Redemption Report</a></li>
							<li><a href="<?= site_url("admin/questionperfreport"); ?>">Question Perf Report</a></li>
							<li><a href="<?= site_url("admin/schoolheatmap"); ?>">School Heat Map</a></li>
						</ul>
					</li>
				<?php endif; ?>
			</ul>
			<?php } ?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<?php if($this->user->profile_pic) { ?>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class="menu-avatar" src="<?= base_url(); ?><?php echo $this->user->profile_pic?>" alt="gravatar" /><?= $this->user->firstname ?> <i class="fa fa-angle-down"></i></a>
					<?php } else { ?>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class="menu-avatar" src="<?= base_url(); ?>images/default_gravatar.jpg" alt="gravatar" /><?= $this->user->firstname ?> <i class="fa fa-angle-down"></i></a>
					<?php } ?>
					<ul class="dropdown-menu">
						<li><a href="<?= site_url('student/settings'); ?>">Settings</a></li>
						<li><a href="<?= site_url('student/help'); ?>">Help</a></li>
						<li><a href="<?= site_url('login/logout'); ?>">Logout</a></li>
					</ul>
				</li>
			</ul>

		</div><!--/.nav-collapse -->
	</div>
</div>
