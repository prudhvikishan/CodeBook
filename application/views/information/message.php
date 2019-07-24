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
  <script src="<?= base_url(); ?>js/jquery-ui.js"></script>
  <link href="<?= base_url(); ?>css/jquery-ui.css" rel="stylesheet" type="text/css">
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

        <h2 class="page-header"><?= $title ?></h2>

        <section class="block">
          <h4 class="<?= $status ?>"><?= ucfirst($status) ?></h4>
          <div class="body">
            <?= $message ?>
          </div>
        </section>

        <?php if(isset($link) && $link) { ?>
          <div class="center">
            <a href='<?= site_url("$link->url_part"); ?>' class="btn btn-secondary"><?= $link->label ?></a>
          </div>
        <?php } ?>
        
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
              <div class="links"><!--<a href="#">Terms of Use</a> · <a href="#">Privacy Policy</a> ·--> <a href="<?= site_url('information/contact'); ?>">Contact Us</a></div>
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