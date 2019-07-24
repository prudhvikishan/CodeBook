<!DOCTYPE html>
<html>
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
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">

</head>
<body>
<?php include "student_header.php"?>
<?php
$profile=htmlspecialchars($_GET["profile"]);
?>

<div id="my-tab-content" class="tab-content" style="margin-top:20px;">
        <div class="tab-pane <?php if(empty($profile)){ echo 'active'; }?>" id="newsfeed">
            <?php include "news_feed.php"?>
        </div>
        <div class="tab-pane" id="lmap">
            <?php include "learning_map.php"?>
        </div>
        <div class="tab-pane" id="reportcard">
          <?php include "student_report_card.php"?>
        </div>
        <div class="tab-pane <?php if(!empty($profile)){ echo 'active' ;}?>" id="studentprofile">
          <?php include "student_profile.php"?>
        </div>
 
    </div>
 <?php if(!empty($profile)){ ?>
 <script> $('#li_newsfeed').removeClass('active');
 $('#li_studentprofile').addClass('active');</script>
 <?php }?>

</body>
</html>