<html>
<head>
<title>Student Dashboard</title>
<!-- Bootstrap -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.css" rel="stylesheet">

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/d3.js"></script>


<link href="css/custom.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">

</head>
<body>
  <div class="container" style="margin-top:20px;">
<?php include "header.php" ?>
    <ol class="breadcrumb">
    <li><a href="student_dashboard.php?learning_map=1">Learning Map</a></li>
    <li class="active">Algebra</li>
    </ol>

    <div class="row">

    <div class="col-lg-2">

      <ul id="classesboardtabs" class="nav nav-pills nav-stacked" data-tabs="tabs">
        <li class="active"><a href="#videos" data-toggle="tab">Videos</a></li>
        <li><a href="#classnotes" data-toggle="tab">Class Notes</a></li>
        <li><a href="#practice" data-toggle="tab">Practice Questions</a></li>
      </ul>
    </div>
 
    <div class="col-lg-10">
    	<div id="my-class-tab-content" class="tab-content">
    		<div class="tab-pane active" id="videos">
		    	<div class="row">
        <div class="col-lg-12">
          <div class="thumbnail" style="margin-bottom:10px;">
            <div class="row">
              <div class="col-lg-3">
            <img alt="algebra1" src="http://i1.ytimg.com/vi/QWsP5vggaAA/mqdefault.jpg" style="width: 200px; height: 150px; padding:10px; ">
            </div>
            <div class="col-lg-9">

            <div class="caption">
              <h5>Pre-Algebra: Lesson 1 Order of operations </h5>
              <p>Learn the basics of Algebra.</p>
              <p><a href="http://www.youtube.com/watch?v=QWsP5vggaAA" class="btn btn-primary">Watch Video</a> </p>
            </div>
          </div>
          </div>
        </div>
   
          <div class="thumbnail" style="margin-bottom:10px;">
             <div class="row">
              <div class="col-lg-3">
            <img  alt="algebra2" src="http://i1.ytimg.com/vi/bYVHMNMvycQ/mqdefault.jpg" style="width: 200px; height: 150px;padding:10px; ">
           </div>
            <div class="col-lg-9">
            <div class="caption">
              <h5>Linear Equations </h5>
              <p>This lesson is about Linear Equations (Equations with x and y). This lesson shows how to transform and make a table of values for a linear equation</p>
              <p><a href="http://www.youtube.com/watch?v=bYVHMNMvycQ" class="btn btn-primary">Watch Video</a> </p>
            </div>
          </div>
          </div>
        </div>
            <div class="thumbnail" style="margin-bottom:10px;">
              <div class="row">
              <div class="col-lg-3">
            <img  alt="algebra1" src="http://i1.ytimg.com/vi/P4Bn5w6XYOI/mqdefault.jpg" style="width: 200px; height: 150px;padding:10px; ">
            </div>
            <div class="col-lg-9">
            <div class="caption">
              <h5>Direct Variation</h5>
              <p>Learn the basics of Algebra.</p>
              <p><a href="http://www.youtube.com/watch?v=QWsP5vggaAA" class="btn btn-primary">Watch Video</a> </p>
            </div>
          </div>
       </div>
      </div>
		    </div>
      </div>
    </div>
		    <div class="tab-pane" id="classnotes">
		    	<iframe src="data/notes.pdf" style="width:100%; height:100%"></iframe>
		    </div>
		    <div class="tab-pane" id="practice">
		    	<?php include "student_exam.php"?>
		    </div>

    </div>
    
    </div>
  </div>
  </div>
   <script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#classesboardtabs').tab();
    });
</script>
</body>
</html>