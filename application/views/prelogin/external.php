<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?= base_url(); ?>images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= base_url(); ?>images/favicon.ico" type="image/x-icon">

	<title>aksharas - We make education fun and engaging</title>

	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Maven+Pro:400,700|Montserrat:400' rel='stylesheet' type='text/css'>


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
									<h2>learn different</h2>
									<a class="btn btn-primary" href="<?= site_url('user/registration'); ?>">Start learning today <i class="fa fa-fw fa-arrow-right"></i></a>
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

				<div class="front-page">

					<div class="container front-section">

						<div class="row">
							<div class="col-md-4 front-icon">
								<span class="fa-stack fa-4x">
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-desktop fa-stack-1x fa-inverse"></i>
								</span>
								<h3>Learn</h3>
								<p>Watch videos, review notes, and take tests</p>
							</div>
							<div class="col-md-4 front-icon">
								<span class="fa-stack fa-4x">
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-trophy fa-stack-1x fa-inverse"></i>
								</span>
								<h3>Earn</h3>
								<p>Earn points and badges for completing activities</p>
							</div>
							<div class="col-md-4 front-icon">
								<span class="fa-stack fa-4x">
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-desktop fa-stack-1x fa-inverse"></i>
								</span>
								<h3>Redeem</h3>
								<p>Redeem points you've earned to get rewards</p>
							</div>
						</div>

					</div>

					<div class="large-callout front-section">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<h2>We make education fun and engaging</h2>
									<h3>Free access for a limited time</h3>
									<a class="btn btn-secondary mb" href="<?= site_url('user/registration'); ?>">Get Access</a>
								</div>
							</div>
						</div>
					</div>

					<div class="container front-section">

						<div class="row">
							<div class="col-md-4">
								<div class="callout">
									<i class="fa fa-fw fa-tablet"></i>
									<h3>Any Device</h3>
									<p>Our device agnostic software helps students and parents access content, tests, and analytics anywhere on any device.</p>
								</div>
							</div>

							<div class="col-md-4">
								<div class="callout">
									<i class="fa fa-fw fa-bar-chart-o"></i>
									<h3>Beautiful Analytics</h3>
									<p>Our easy to understand report card helps students measure their progress and identify strengths and weaknesses in real-time.</p>
								</div>
							</div>

							<div class="col-md-4">
								<div class="callout">
									<i class="fa fa-fw fa-puzzle-piece"></i>
									<h3>Game Mechanics</h3>
									<p>We've created an easy-to-use interface and applied game mechanics to amplify motivation and promote enagament.</p>
								</div>
							</div>
						</div>

					</div>

				</div> 

			</div>
		</div>

		<div id="footer">

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

			<script type="text/x-mathjax-config">
			MathJax.Hub.Config({
				tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]},
				TeX: {
					extensions: ["mhchem.js"],
					Macros: {
						RR: "{\\bf R}",
						bold: ["{\\bf #1}",1]
					}
				}
			});
			</script>
			<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
			<script src="<?= base_url(); ?>js/formula.js"></script>
			<script src="<?= base_url(); ?>ckeditor/ckeditor.js"></script>
			<script src="<?= base_url(); ?>ckeditor/config.js"></script>
			<script src="<?= base_url(); ?>ckeditor/adapters/jquery.js"></script>	
			<script type="text/javascript">
			CKEDITOR.disableAutoInline = true;
			$( document ).ready( function() {
				Formula.createBigEditor(".question_editor");
				Formula.createSmallEditor(".choice_editor");
				/* need to put this in the by_topic page, but can't get it working*/
				$("toggleDiv").hide();
				$(".show_hide").show();

				$('.show_hide').click(function(){
					var toggleDiv = $(this).attr('rel');

					$(toggleDiv).slideToggle();
				});

			});
			</script>
			<script src="<?= base_url(); ?>js/tracking.js"></script>
			<script type="text/javascript">
			Tracker.trackPageView();
			</script>
		</body>
		</html>