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

    <div class="container" style="margin-top:20px">
         <div class="row">
    <div class="col-lg-2">
    <ul id="questiontabs" class="nav nav-pills nav-stacked" data-tabs="tabs">
        <li class="active"><a href="#practicequestions" data-toggle="tab">Practice</a></li>
        <li><a href="#examquestions" data-toggle="tab">Exam</a></li>
    </ul>
  </div>
  <div class="col-lg-10">
    <div id="my-class-tab-content" class="tab-content">
        <div class="tab-pane active" id="practicequestions">
       		 	<?php include "practice_questions.php"?>
        </div>
        <div class="tab-pane" id="examquestions">
		    	<?php include "exam_questions.php"?>
        </div>
       
    </div>
</div>
 </div>

 </div>
 
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#questiontabs').tab();
        updateFormulas();
    });
</script>    


 <script src="js/jquery.js"></script>
    <script src="js/d3.js"></script>
    <script src="js/holder.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/formula.js"></script>
       </div>
    
  </body>
</html>