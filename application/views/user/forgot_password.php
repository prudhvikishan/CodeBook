<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?= base_url(); ?>images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= base_url(); ?>images/favicon.ico" type="image/x-icon">

	<title>Codebook - We make education fun and engaging</title>

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

			<div class="container">
						<?= form_open() ?>
						<h2>Password Reset</h2>
						<div class="form-group <?php if( form_error('email') ) { echo 'has-error'; } ?>">
						<div class="row">
							<div class="col-md-8">
							<label for="email">Enter your email address used to create your account, and we'll send you instructions on how to reset your password.</label>
							</div>
						</div>
						<div class="row">
						<div class="col-md-4">
							<input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>" placeholder="Email"/>
							<span class="help-block"><?php echo form_error('email'); ?></span>
							<?php if($this->message) echo $this->message; ?> 
						</div>
						</div>
						<div class="row">
						<div class="col-md-2">
						<input class='btn btn-secondary btn-block' type='submit' name='submit' value='Submit' />
						<?= "</form>" ?>
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
      <script src="//cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
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
  </html>\

