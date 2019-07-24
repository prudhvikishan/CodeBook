<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>akshara interactive education</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
    <!-- Custom styles for this template -->
    <link href="css/jumbotron-narrow.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
    <style>
    .row.features
    {
      margin-top:25px;margin-bottom: 25px;
    }
    h3
    {
      font-family:Helvetica;
      color:#428BCA;
    }
    h4
    {
      font-family: Arial;
    }
    .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
      color:#ffffff;
      background-color: #f4c717;
    }
    hr
    {
    margin-top: 5px;
    margin-bottom: 5px;

    height: 12px;
    border: 0;
    box-shadow: inset 0 12px 12px -12px rgba(0,0,0,0.5);

    }
    </style>
  </head>

  <body>
   <div class="navbar navbar-inverse navbar-fixed-top" style="background-color:black;">
      <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="student_dashboard.php">  <img src="images/akshara_logo_white.png" ></img></a>

        <div class="nav-collapse collapse">
          <ul class="nav navbar-nav pull-right">
            <li><div id="home2_login"><button type="button" class="btn btn-default navbar-btn" style="margin:15px;background-color:#f4c717;color:#2b2b2b;border-color:#f4c717;">Login</button></div></li>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
   </div>
    <div class="container">
     <!-- <div class="header">
       
       <ul class="nav nav-pills pull-right">
          <li class="active"><a href="login.php">Login</a></li>
        </ul>
        <img src="akshara_logo.png" style="padding:5px;"></img>

      </div>-->

      <div class="row" style="margin-top:75px;">
        <div class="col-lg-12">
        <img src="images/akshara.jpg" width="100%"></img></p>
 
      </div>
      </div>

       <div class="row features">
        <div class="col-lg-8">
          <h3>Access content from multiple devices</h3>
          <h4>Our device agnostic software helps students, teachers and parents access content, tests and analytics from anywhere and on any device.</h4>
        </div>
        <div class="col-lg-4">
          <img src="images/anywhere.png" style="padding:20px;"></img>
        </div>
      </div>
              <div class="row">
          <div class="col-lg-12">
        <hr/>
      </div>
    </div>


       <div class="row features">
        <div class="col-lg-3">
          <img src="images/game.png" style="padding:20px;"></img>
        </div>
        <div class="col-lg-9">
          <h3>Engaging experience through Gamification</h3>
          <h4>We have designed an easy to use interface and applied game mechanics to amplify student motivation and promote enagament.</h4>
        </div>

      </div>

             <div class="row">
          <div class="col-lg-12">
        <hr/>
      </div>
    </div>


      <div class="row features">
        <div class="col-lg-8">
          <h3>Powerful Analytics</h3>
          <h4>Our powerful analytic engine helps you generate detailed class and student reports and aid you in creating customized study plans for students.</h4>
        </div>
        <div class="col-lg-4">
          <img src="images/graph.png" style="padding:20px;"></img>
        </div>

      </div>
              <div class="row">
          <div class="col-lg-12">
        <hr/>
      </div>
    </div>


    
    <div class="row features">
        <div class="col-lg-3">
          <img src="images/exam.png" style="padding:20px;"></img>
        </div>
        <div class="col-lg-9">
          <h3>Tests and Assessments</h3>
          <h4>Our state of the art test creation tool will allow you to create customized tests and deliver them instantly.</h4>
        </div>
  
      </div>
        <div class="row">
          <div class="col-lg-12">
        <hr/>
      </div>
    </div>
<script>$(function(){
    $('#home2_login').click(function(){
        window.location='login.php'
    });
});</script>
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>

