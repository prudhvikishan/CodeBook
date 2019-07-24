<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?= base_url(); ?>images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= base_url(); ?>images/favicon.ico" type="image/x-icon">

	<title>codebook - learn different</title>

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Maven+Pro:400,700|Montserrat:400' rel='stylesheet' type='text/css'>


	<!-- Bootstrap core CSS -->
	<link href="<?= base_url(); ?>css/bootstrap.css" rel="stylesheet">
	<!-- Bootstrap theme -->
	<link href="<?= base_url(); ?>css/theme.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<!-- Font Awesome needs to come after core Bootstrap -->
	<link href="<?= base_url(); ?>css/font-awesome.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="<?= base_url(); ?>js/html5shiv.js"></script>
		<script src="<?= base_url(); ?>js/respond.min.js"></script>
		<![endif]-->

		<script src="<?= base_url(); ?>js/jquery.js"></script>
		<script type="text/javascript">var base_url = "<?=base_url(); ?>"; </script>

		<!-- video.js must be in the <head> for older IEs to work. -->
		<link href="<?= base_url(); ?>videojs/video-js.css" rel="stylesheet" type="text/css">
		<script src="<?= base_url(); ?>videojs/video.js"></script>
		<script>
			videojs.options.flash.swf = base_url + "videojs/video-js.swf";
		</script>
	</head>

	<body>

		<div id="wrap">
			<div id="main">

				<?php include("../application/views/includes/prelogin_header.php"); ?>

				<section class="hero">

					<div class="container">
						<div class="hero-content">
							<div class="row mb">

								<div class="col-sm-6">
									<h1>codebook</h1>
									<h2>learn <span class="color-primary">different</span></h2>
									<div class="row mb">

									<div class="col-sm-offset-2 col-sm-4">
									<h4>New Users</h4>
									<a class="btn btn-primary"  href="<?= site_url('user/registration'); ?>">SIGN UP</i></a>
								   </div>
								   <div class="col-sm-4">
									<h4>Existing Users</h3>
									<a class="btn btn-secondary"  href="<?= site_url('login'); ?>">LOGIN</i></a>
								   </div>
								   </div>
								   <div> <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fcodebooklearning&amp;width=100&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:45px;padding-top:19px;" allowTransparency="true"></iframe></div>
								</div>

								<div class="col-sm-6 hidden-xs">
									<div class="hero-image">
										<img height="250px" src="<?= site_url('images/librarybooks.png') ?>" />
									</div>
								</div>

							</div>

						</div>

					</div>

				</section>

				<div class="front-page why-layer">

					<div class="container front-section">

						<div class="row">
							<div class="col-md-12">

								<div class="row">
									<div class="col-md-offset-1 col-md-10">
										<div class="callout">
											<h1><span class="orange">Why</span> did we start codebook?</h1> 
											<p class="sectiontext"> We at codebook want to make a difference in this world and we strongly believe there is no other better way to do that, than by helping children realize their dreams through best quality education presented in a fun and engaging way.</p>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-offset-1  col-md-2">
										<div class="home-bullet">
											Why?
										</div>
									</div>

									<div class="col-md-4">
										
										<div class="callout">
											<img src="<?=site_url('images/13004343_l.jpg');?>" alt="img" />
											<div class="body">
												<p>We believe that fun and learning should never be separated for a student.</p>
											</div>
										</div>
									</div>

									<div class="col-md-4">
										<div class="callout">
											<img src="<?=site_url('images/7298701_l.jpg');?>" alt="img" />
											<div class="body">
												<p>We believe that every child's education and future should be secure for a parent.</p>
											</div>
										</div>
									</div>
									
								</div>

							</div>
						</div>
					</div>
				</div>
				<div class="front-page how-layer">

					<div class="container front-section">

						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-offset-1 col-md-10">
										<div class="callout">
											<h1><span class="orange">How</span> do we make education fun and engaging ?</h1> 
											<p class="sectiontext"> We bring the best education videos, class notes and examinations right to your home. We have integrated game mechanics to your learning experience, to make it fun and motivating.</p>
										</div>
									</div>
								</div>
								<div class="row">

									<div class="col-md-offset-1 col-md-4">
										<div class="callout">
											<img src="<?=site_url('images/14669254_l.jpg');?>" alt="img" />
											<div class="body">
												<p>We bring comprehensive content through videos, class notes and quizzes.</p>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="home-bullet">
											How?
										</div>
									</div>
									<div class="col-md-4">
										<div class="callout">
											<img src="<?=site_url('images/16141850_l.jpg');?>" alt="img" />
											<div class="body">
												<p>We add fun to learning through gamification using points, levels and badges.</p>
											</div>
										</div>
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="front-page">

					<div class="container front-section">

						<div class="row">
							<div class="col-md-12">

								<div class="row">
									<div class="col-md-offset-1 col-md-8">
										<div class="callout">
											<h1><span class="orange">What</span> do we give you ?</h1> 
											<p  class="sectiontext"> We provide you a state of the art online learning platform woven with gamification and rich analytical tools, to help you assess your skills and become successful.</p>
										</div>
									</div>
									<div class="col-md-2">
										<div class="home-bullet">
											What?
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-offset-1 col-md-10">

										<div class="row">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-5">
														<div class="callout front-icon">
															<span class="fa-stack fa-4x">
																<i class="fa fa-circle fa-stack-2x"></i>
																<i class="fa fa-desktop fa-fw fa-stack-1x fa-inverse"></i>
															</span>	
														</div>
													</div>
													<div class="col-md-7">
														<div class="callout front-icon">
															<h3>ONLINE LEARNING PLATFORM</h3>
															<p>We provide an online learning platform with rich videos, class notes and examinations.</p>
														</div>
													</div>
												</div>

											</div>

											<div class="col-md-4">
												<div class="row">
													<div class="col-md-5">
														<div class="callout front-icon">
															<span class="fa-stack fa-4x">
																<i class="fa fa-circle fa-stack-2x"></i>
																<i class="fa fa-tablet fa-fw fa-stack-1x fa-inverse"></i>
															</span>
														</div>
													</div>
													<div class="col-md-7">
														<div class="callout front-icon">
															<h3>COMPUTER, MOBILE PHONE AND TABLET</h3>
															<p>We provide students a device agnostic platform that can be accessed from a computer, tablet or a mobile phone.</p>
														</div>
													</div>
												</div>

											</div>


											<div class="col-md-4">
												<div class="row">
													<div class="col-md-5">
														<div class="callout front-icon">
															<span class="fa-stack fa-4x">
																<i class="fa fa-circle fa-stack-2x"></i>
																<i class="fa fa-bar-chart-o fa-fw fa-stack-1x fa-inverse"></i>
															</span>
														</div>
													</div>
													<div class="col-md-7">
														<div class="callout front-icon">
															<h3>EASY TO UNDERSTAND ANALYTICS</h3>
															<p>We provide easy to understand analytics to help you identify strengths and eliminate weaknesses.</p>
														</div>
													</div>
												</div>

											</div>

										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-5">
														<div class="callout front-icon">
															<span class="fa-stack fa-4x">
																<i class="fa fa-circle fa-stack-2x"></i>
																<i class="fa fa-trophy fa-fw fa-stack-1x fa-inverse"></i>
															</span>
														</div>
													</div>
													<div class="col-md-7">
														<div class="callout front-icon">
															<h3>GAMIFICATION</h3>
															<p>We have woven our learning platform with game mechanics, like points, levels and badges, to enhance student motivation.</p>
														</div>
													</div>
												</div>
											</div>

											<div class="col-md-4">
												<div class="row">
													<div class="col-md-5">
														<div class="callout front-icon">
															<span class="fa-stack fa-4x">
																<i class="fa fa-circle fa-stack-2x"></i>
																<i class="fa fa-star fa-fw fa-stack-1x fa-inverse"></i>
															</span>
														</div>
													</div>
													<div class="col-md-7">
														<div class="callout front-icon">
															<h3>LEADERSHIP</h3>
															<p>We provide leadership opportunities for students to collaborate in group tasks and hone their team building skills.</p>
														</div>
													</div>
												</div>
											</div>


											<div class="col-md-4">
												<div class="row">
													<div class="col-md-5">
														<div class="callout front-icon">
															<span class="fa-stack fa-4x">
																<i class="fa fa-circle fa-stack-2x"></i>
																<i class="fa fa-users fa-fw fa-stack-1x fa-inverse"></i>
															</span>
														</div>
													</div>
													<div class="col-md-7">
														<div class="callout front-icon">
															<h3>COMPETITION</h3>
															<p>We provide opportunities for students to compete in regional, state and national level examinations.</p>
														</div>
													</div>
												</div>
											</div>	

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> 

		</div>


 <div id="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="copyright">&copy; 2014 Codebook Technologies Pvt. Ltd.</div>
          </div>
          <div class="col-md-6">
            <div class="links"><a href="<?= site_url('information/termsofuse'); ?>">Terms of Use</a>.     <a href="<?= site_url('information/privacypolicy'); ?>">Privacy Policy</a>.  <a href="<?= site_url('information/contact'); ?>">Contact Us</a></div>
          </div>
        </div>
      </div>
    </div>

	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?= base_url(); ?>js/bootstrap.js"></script>
	<script src="<?= base_url(); ?>js/holder.js"></script>

	<script>

		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover();

	</script>

	<script>
			//load and implement all unsupported features || call polyfill before DOM-Ready to implement everything as soon and as fast as possible
			$.webshims.polyfill();
		</script>

		<script src="<?= base_url(); ?>js/tracking.js"></script>
		<script type="text/javascript">
			Tracker.trackPageView();
		</script>
	</body>
	</html>