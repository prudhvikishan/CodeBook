      <!--<div class="container">
        <div class="row">
          <div class="col-lg-2">-->

              <ul id="classtabs" class="nav nav-tabs" data-tabs="tabs">
              <li class="active"><a href="all" data-toggle="tab">All Classes</a></li>
              <li><a href="class1" data-toggle="tab">MPC-S1</a></li>
              <li><a href="class2" data-toggle="tab">MPC-S2</a></li>
              <li><a href="class3" data-toggle="tab">MPC-S3</a></li>
            </ul>

          <!--</div>
   
        <div class="col-lg-10">-->
           <div id="my-class-tab-content" class="tab-content" style="margin-top:20px;">
        <div class="tab-pane active" id="all">
            <div class="panel">
            <div class="panel-heading">
            <strong><span class="glyphicon glyphicon-star"></span> Class Performance</strong>
            </div>
           <div id="chart"></div>
        </div>
      </div>
        <div class="tab-pane" id="class1">
            <?php include "teacher_class_report.php"?>
        </div>
        <div class="tab-pane" id="class2">
            <?php include "teacher_class_report.php"?>
        </div>
        <div class="tab-pane" id="class3">
            <?php include "teacher_class_report.php"?>
        </div>

    </div>

        
     <!-- </div>
    </div>

    </div> -->


    <script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#classtabs').tab();
    });
</script> 
<script src="js/teacher_dashboard_chart.js"></script>