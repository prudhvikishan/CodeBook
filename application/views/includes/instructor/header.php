<nav class="navbar navbar-default page_header" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<?php $link = $this->user->user_home() == null ? base_url() : $this->user->user_home(); ?>
		<a class="navbar-brand" href="<?= $link; ?>"><img src="<?= base_url(); ?>/images/akshara-logo.png"></a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<?php if(isset($this->allcourses) ){?>
		<ul class="nav navbar-nav">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle headerfont" data-toggle="dropdown">Learn <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php foreach($this->allcourses as $course): ?>
						<li><a href="<?= base_url(); ?>instructor/index/<?= $course->course_id; ?>"><?= $course->name ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
		</ul>
		<?php }?>
		
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle headerfont" data-toggle="dropdown"><?= $this->user->firstname ?><b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#">Profile</a></li>
					<li><a href="<?= base_url(); ?>login/logout">Logout</a></li>
				</ul>
			</li>
		</ul>
	</div><!-- /.navbar-collapse -->
</nav>