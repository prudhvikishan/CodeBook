<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?= base_url(); ?>images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= base_url(); ?>images/favicon.ico" type="image/x-icon">

	<title>codebook - We make education fun and engaging</title>

	<!-- Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Maven+Pro:400,700|Montserrat:400' rel='stylesheet' type='text/css'>


	<!-- Bootstrap core CSS -->
	<link href="<?= base_url(); ?>css/bootstrap.css" rel="stylesheet">
	<!-- Bootstrap theme -->
	<link href="<?= base_url(); ?>css/theme.css" rel="stylesheet">

	<link href="<?= base_url(); ?>css/dataTables.bootstrap.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<!-- Font Awesome needs to come after core Bootstrap -->
	<link href="<?= base_url(); ?>css/font-awesome.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="<?= base_url(); ?>js/html5shiv.js"></script>
		<script src="<?= base_url(); ?>js/respond.min.js"></script>
		<![endif]-->

		<script src="<?= base_url(); ?>js/jquery.js"></script>

		<script src="<?= base_url(); ?>js/modernizr.js"></script>

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

				<?php
				if($this->user->hasRole("S"))
					include(APPPATH . "/views/includes/student/header.php");
				else if($this->user->hasRole("T"))
					include(APPPATH . "/views/includes/instructor/header.php");
				?>

				<div class="container">
					<?= $content ?>
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
		<script src="<?= base_url(); ?>js/js-webshim/minified/polyfiller.js"></script>
		<script src="<?= base_url(); ?>js/min/jquery.icheck.min.js"></script>
		<script src="<?= base_url(); ?>js/min/bootbox.min.js"></script>
		<script src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
		<script src="<?= base_url(); ?>js/dataTables.bootstrap.js"></script>

		<script>
			//load and implement all unsupported features || call polyfill before DOM-Ready to implement everything as soon and as fast as possible
			$.webshims.polyfill();
		</script>

		<script>

			$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover();

			$('input').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			    increaseArea: '20%' // optional
			});

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
		<script src="<?= base_url(); ?>js/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
		<script src="<?= base_url(); ?>js/formula.js"></script>
		<script src="<?= base_url(); ?>ckeditor/ckeditor.js"></script>
		<script src="<?= base_url(); ?>ckfinder/ckfinder.js"></script>
		<script src="<?= base_url(); ?>ckeditor/config.js"></script>
		<script src="<?= base_url(); ?>ckeditor/adapters/jquery.js"></script>	
		<script type="text/javascript">
			CKEDITOR.disableAutoInline = true;
			CKFinder.setupCKEditor( null, { basePath : '/ckfinder/', rememberLastFolder : false } );
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
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-47023421-1', 'codebooklearning.com');
			ga('send', 'pageview');
		</script>

		<?php if($this->user): ?>
			<div id="notifications"></div>
			<script src="<?= base_url(); ?>js/announcements.js"></script>
		<?php endif; ?>
	</body>
	</html>