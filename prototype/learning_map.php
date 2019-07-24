
  
  <div class="container" style="margin-top:20px;">

    <div class="row">

    <div class="col-lg-2">

      <ul id="classesboardtabs" class="nav nav-pills nav-stacked" data-tabs="tabs">
        <li class="active"><a href="#maths" data-toggle="tab">Mathematics</a></li>
        <li><a href="#physics" data-toggle="tab">Physics</a></li>
        <li><a href="#chemistry" data-toggle="tab">Chemistry</a></li>
      </ul>
    </div>
 
    <div class="col-lg-10">
    	<div id="my-class-tab-content" class="tab-content">
    		<div class="tab-pane active" id="maths">
		    	<?php include "course_syllabus.php" ?>
		    </div>
		    <div class="tab-pane" id="physics">
		    	<?php include "physics_course_syllabus.php" ?>
		    </div>
		    <div class="tab-pane" id="chemistry">
		    	<?php include "chemistry_course_syllabus.php" ?>
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