
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel">
      <div class="panel-heading">
      <strong><i class="icon-bullhorn icon-large"></i> Announcements</strong>
      </div>
        <p><i class="icon-pencil exam-activity"></i> The pracice exam form Algebra I is now available. <a href="student_exam.php">Start Exam</a></p>
        <p><i class="icon-time badge-activity"></i> Oct 1 2013, is the last date to submit your Algebra I exam</p>
      </div>
      </div>

  </div>

<div class="row">
<div class="col-lg-6 ">
        <div class="panel">
            <div class="panel-heading">
            <strong><span class="glyphicon glyphicon-certificate"></span> Leaderboard</strong>
          </div>
        <div class="row" style="margin-top:10px; margin-bottom:10px;">
		    <div class="col-lg-12">
		    <ul id="leaderboardtabs" class="nav nav-tabs">
		      <li class="active"><a href="#leaderboardall" data-toggle="tab">All</a></li>
		      <li><a href="#leaderboardmaths" data-toggle="tab">Maths</a></li>
		      <li><a href="#leaderboardphysics" data-toggle="tab">Physics</a></li>
		      <li><a href="#leaderboardchem" data-toggle="tab">Chemistry</a></li>
		    </ul>
		  </div>
		  <script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#leaderboardtabs').tab();
    });
</script> 
		  </div>
		  <div id="my-tab-content1" class="tab-content" style="margin-top:20px;">
		  <div class="tab-pane active" id="leaderboardall">
		  		<?php $lb = 0; include "student_leader_board.php" ?>
		          </div>
		          <div class="tab-pane" id="leaderboardmaths">
		              <?php  $lb = 1; include "student_leader_board.php" ?>
		          </div>
		          <div class="tab-pane" id="leaderboardphysics">
		            <?php $lb = 2; include "student_leader_board.php" ?>
		          </div>
		          <div class="tab-pane" id="leaderboardchem">
		            <?php  $lb = 3; include "student_leader_board.php" ?>
		          </div>
		   
		      </div>
            </div>
           </div>

  <div class="col-lg-6">
  <div class="panel">
      <div class="panel-heading">
      <strong><i class="icon-bullhorn icon-large"></i> What's Happening</strong>
      </div>
      
      <div class="row">
      <div class="col-lg-2">
      <img src="images/1.jpg" alt="Shanthan Kesharaju" class="img-rounded" width="40px" height="40px">
      </div>
      <div class="col-lg-10">
          <p><a href="student_dashboard.php?profile=profile">Shanthan Kesharaju</a> has just started the Algebra I practice exam</p>
      </div>
 
      </div>

      <div class="row">
      <div class="col-lg-2">
      <img src="images/1.jpg" alt="Shanthan Kesharaju" class="img-rounded" width="40px" height="40px">
      </div>
      <div class="col-lg-10">
          <p><a href="student_dashboard.php?profile=profile">Kenneth Koch</a> has just earned 150 points for completing the Algebra I practice exam</p>
      </div>
   
      </div>

      <div class="row">
      <div class="col-lg-2">
      <img src="images/1.jpg" alt="Shanthan Kesharaju" class="img-rounded" width="40px" height="40px">
      </div>
      <div class="col-lg-10">
          <p><a href="student_dashboard.php?profile=profile">Maddy Singh</a> has earned the Trigonometry Apprentice badge</p>
      </div>
      </div>
  
  </div>

</div>
</div>
</div>