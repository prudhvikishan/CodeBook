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

      <div class="container">

        <?php echo form_open(null, array("class"=>"form-signin")); ?>

        <h2 class="page-header">Login - Existing Users</h2>

        <?php if ($this->session->flashdata("login_error")) { ?>
        <div class="row">
          <div class="col-md-12">

            <div class="alert alert-danger">
               <?php echo $this->session->flashdata("login_error"); ?>
            </div>

          </div>
        </div>
        <?php } ?>

        <div class="authorization">
          <div class="row">
            <div class="block">

              <div class="col-sm-6">
                <form role="form" class="account">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="username" id="login" autocomplete="off" placeholder="Email Address" autofocus="">
                      <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                    </div>
                    <span class="help-block"><!-- Error goes here --></span>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <input type="password" name="password" class="form-control" autocomplete="off"  placeholder="Password">
                      <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                    </div>
                    <span class="help-block"><!-- Error goes here --></span>
                  </div>

                  <div class="row extras">

<!--                     <div class="col-sm-6 pull-left"> -->
<!--                       <div class="checkbox"> -->
<!--                         <label> -->
<!--                           <input checked type="checkbox" value="remember-me"> Remember me -->
<!--                         </label> -->
<!--                       </div> -->
<!--                     </div> -->
                    <div class="col-sm-6 pull-left">
                      <a href="<?= site_url('user/forgotpassword'); ?>">Forgot password?</a>
                    </div>

                  </div>

                  <button class="btn btn-secondary btn-block" type="submit">Login</button>
                </form>
              </div>

              <div class="col-sm-2">
                <div class="account-divide">
                  <div class="divider login">
                    <hr class="left">
                    <span>or</span>
                    <hr class="right">
                  </div>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="center" style="margin-top: 30px;">
                  <p style="font-size: 18px;">Don't have an account?</p>
                  <a href="<?= site_url('user/registration'); ?>" class="btn btn-link">Sign Up</a>
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