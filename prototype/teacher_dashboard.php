<!DOCTYPE html>
<html>
<head>
<title>Teacher Dashboard</title>
<!-- Bootstrap -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.min.css" rel="stylesheet">

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/d3.js"></script>

<link href="css/slider.css" rel="stylesheet">    
<link href="css/custom.css" rel="stylesheet">
<link href="css/charts.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>
    <?php include "header.php" ?>
<?php include "teacher_header.php" ?>
 

<div id="my-tab-content" class="tab-content" style="margin-top:20px;">
        <div class="tab-pane active" id="news">
            <?php include "news_feed.php"; ?>
        </div>
        <div class="tab-pane" id="myclasses">
            <?php include "teacher_classes.php" ?>
        </div>
        <div class="tab-pane" id="questionbank">
          <?php include "question_bank.php" ?>
        </div>
        <div class="tab-pane" id="testcreator">
          <?php include "teacher_exam_creator.php" ?>
        </div>
 
    </div>

</body>
</html>