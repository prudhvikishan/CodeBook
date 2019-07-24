<!DOCTYPE html>
<html lang="en">
  <head>
   <head>
<title>Student Dashboard</title>
<!-- Bootstrap -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.min.css" rel="stylesheet">

  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/d3.js"></script>


<link href="css/custom.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style type="text/css">
      body {
        padding-top: 80px;
        padding-bottom: 80px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>

    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <script type="text/javascript">
    function checkUserType(){
    	var login = document.getElementById('login').value;
    	console.log(login);
    	console.log(login.toUpperCase());
    	var form = document.getElementById('form1');
    	if(login != null && login.toUpperCase() == 'TEACHER'){
    		form.action = 'teacher_dashboard.php';
    	}else{
    		form.action = 'news_feed.php';
    	}
    	form.submit();
    	
    }    
    </script>

  </head>

  <body>

   <?php include "header.php"?>

    <div class="container">
      <form class="form-signin" id='form1' onsubmit="checkUserType();" action="#">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" id="login" class="input-block-level" placeholder="Login ID">
        <input type="password" class="input-block-level" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
      </form>
    
    </div><!-- /.container -->

    <script src="js/jquery.js"></script>
    <script src="js/d3.js"></script>
    <script src="js/holder.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>