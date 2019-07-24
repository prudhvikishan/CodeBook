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

          <?php echo form_open(null, array("class"=>"form-signin")); ?>

          <h2 class="page-header">Our Values</h2>

          <div class="row">

            <div class="col-md-4">

              <section class="values-section">
                <span class="fa-stack fa-values fa-4x">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-user fa-stack-1x"></i>
                </span>
                <h4>Parents</h4>
                <ul class="values-list">
                  <li><span>We help you spend more time with your children, by bringing quality education right into your home.</span></li>
                  <li><span>With our unlimited replays of learning videos, your children will never miss a concept.</span></li>
                  <li><span>Our online examinations will give your children a jump on future competitive exams like IIT.</span></li>
                  <li><span>Our detailed reports will help you identify the strengths and weaknesses of your children.</span></li>
                  <li><span>Our remediation reports will guide your child to eliminate weaknesses and achieve success.</span></li>
                </ul>
              </section>

            </div>

            <div class="col-md-4">

              <section class="values-section">
                <span class="fa-stack fa-values fa-4x">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-graduation-cap fa-stack-1x"></i>
                </span>
                <h4>Students</h4>
                <ul class="values-list">
                  <li><span>We provide integrated SSC and CBSE syllabus for high school students.</span></li>
                  <li><span>Our Mathematics and Science content has been developed by the best teachers in the field.</span></li>
                  <li><span>We offer easy to understand videos, class notes and online examinations.</span></li>
                  <li><span>We provide instant results on examinations including score and a badge.</span></li>
                  <li><span>We offer detailed remediation steps for every question in the examination.</span></li>
                  <li><span>We give you tools to compare your test scores with your class and national averages.</span></li>
                </ul>
              </section>

            </div>
            
            <div class="col-md-4">

              <section class="values-section">
                <span class="fa-stack fa-values fa-4x">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-institution fa-stack-1x"></i>
                </span>
                <h4>Schools</h4>
                <ul class="values-list">
                  <li><span>Our rich analytics and reports will help you devise customized study plans for every student.</span></li>
                  <li><span>We provide you performance reports of every class at a section level in your school.</span></li>
                  <li><span>Our detailed topic level assessment reports helps you identify gaps and organize remediation classes.</span></li>
                  <li><span>Our Focus and Activity reports will help you identify correlations of student's effort and performance.</span></li>
                  <li><span>We help you identify how your school compares with your competitors.</span></li>
                </ul>
              </section>

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