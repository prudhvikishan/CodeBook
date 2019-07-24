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

        <h2 class="page-header">Sign Up - New Users</h2>
        <div class="authorization signup">
          <div class="row">
            <div class="block">

      <div class="col-sm-6">
         <div class="row">
        <div class="col-md-6">
        <div class="form-group <?php if( form_error('lastname') ) { echo 'has-error'; } ?>">
    			  <input type="text" class="form-control" name="lastname" id="lastname" autocomplete="off" value="<?php echo set_value('lastname'); ?>" placeholder="Surname/Family Name" />
				<span class="help-block"><?php echo form_error('lastname'); ?></span>
		</div>
		</div>
        <div class="col-md-6">
         <div class="form-group <?php if( form_error('firstname') ) { echo 'has-error'; } ?>">
				<input type="text" class="form-control" name="firstname" id="firstname" autocomplete="off" value="<?php echo set_value('firstname'); ?>" placeholder="First Name" autofocus=""/>
				<span class="help-block"><?php echo form_error('firstname'); ?></span>
		</div>
		</div>
		</div>
		<div class="row">
        <div class="col-md-6">
        <div class="form-group <?php if( form_error('email') ) { echo 'has-error'; } ?>">
              <input type="text" class="form-control" name="email" id="email" autocomplete="off" value="<?php echo set_value('email'); ?>" placeholder="Email"/>
              <span class="help-block"><?php echo form_error('email'); ?></span>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group <?php if( form_error('phone') ) { echo 'has-error'; } ?>">
              <input type="text" class="form-control" name="phone" id="phone" autocomplete="off" value="<?php echo set_value('phone'); ?>" placeholder="Phone Number (digits only)" />
              <span class="help-block"><?php echo form_error('phone'); ?></span>
        </div>
		</div>
		</div>
		<div class="row">
        <div class="col-md-6">
		<div class="form-group <?php if( form_error('password') ) { echo 'has-error'; } ?>">
				<input type="password" name="password" id="password" autocomplete="off" class="form-control" value="<?php echo set_value('password'); ?>" placeholder="Password"/>
				<span class="help-block"><?php echo form_error('password'); ?></span>
		</div>
		</div>
        <div class="col-md-6">
		<div class="form-group <?php if( form_error('repassword') ) { echo 'has-error'; } ?>">
				<input type="password" name="repassword" id="repassword" autocomplete="off" class="form-control" value="<?php echo set_value('repassword'); ?>" placeholder="Re-enter Password"/>
				<span class="help-block"><?php echo form_error('repassword'); ?></span>
		</div>
		</div>
		</div>
		<div id="school_details">
		  <div class="row">
            <div class="col-md-6">
    		<div class="form-group <?php if( form_error('schoolname') ) { echo 'has-error'; } ?>">
              <input type="text" class="form-control" name="schoolname" id="schoolname" value="<?php echo set_value('schoolname'); ?>" placeholder="School Name"/>
              <span class="help-block"><?php echo form_error('schoolname'); ?></span>
         	 </div>
            </div>
            <div class="col-md-6">
    			<div class="form-group <?php if( form_error('class') ) { echo 'has-error'; } ?>">
    				<select class="form-control" name="class">
    					<option value="0">Class</option>
    					<?php foreach ($classes as $class) {?>
    					<option value="<?php echo $class->class_id;?>" <?= set_select("class", $class->class_id ); ?>><?php echo $class->name;?></option>
    					 <?php }?>
    					</select>							
    				<span class="help-block"><?php echo form_error('class'); ?></span>
    			</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
    		<div class="form-group <?php if( form_error('schoolcity') ) { echo 'has-error'; } ?>">
              <input type="text" class="form-control" name="schoolcity" id="schoolcity" value="<?php echo set_value('schoolcity'); ?>" placeholder="City"/>
              <span class="help-block"><?php echo form_error('schoolcity'); ?></span>
         	 </div>
            </div>
            <div class="col-md-6">
         	 <div class="form-group <?php if( form_error('schoolstate') ) { echo 'has-error'; } ?>">
    			<select class="form-control" name="schoolstate">
    			<option value="">State</option>
    				<?php foreach ($states as $state) {?>
    					<option value="<?php echo $state->name;?>" <?= set_select("schoolstate", $state->name ); ?>><?php echo $state->name;?></option>
    				<?php }?>
    			</select>							
    			<span class="help-block"><?php echo form_error('schoolstate'); ?></span>
    		</div>
            </div>
          </div>		
          </div>				
                  	<button class="btn btn-primary btn-block" type="submit" name="save" value="save">Sign Up</button>
                </form>
              </div>

              <div class="col-sm-1">
               <!--  <div class="account-divide">
                  <div class="divider login">
                    <hr class="left">
                    <span>or</span>
                    <hr class="right">
                  </div>
                </div> -->
              </div> 

              <div class="col-sm-5 center">
                <!-- <div style="margin-top: 20px;">
                  <p style="font-size: 18px;">Already have an account?</p>
                  <a href="<?= site_url('login'); ?>" class="btn btn-link">Login</a>
                </div -->
               <div id="divfacebook" style="padding-top:10px"> <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fcodebooklearning&amp;width=350&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:290px;" allowTransparency="true"></iframe></div>
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














<!-- <body>
<?= form_open() ?>
	<h2>User Registration</h2>
	        <?php echo $this->session->flashdata("validation_error"); ?> </br></br>
	
	    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" autofocus=""/></br>
	    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" autofocus=""/></br>

        <input type="text" class="form-control" name="email" id="email" placeholder="Email" autofocus=""/></br>

        <input type="password" name="password" id="password" class="form-control" placeholder="Password"/></br>
        <input type="password" name="repassword" id="repassword" class="form-control" placeholder="Re-enter Password"/></br></br>

 
	<input class='btn btn-orange' type='submit' name='save' value='save' />
	

<?= "</form>" ?>
</body>
 -->
