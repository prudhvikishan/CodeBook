    <div class="container">
    <div class="row">
    <div class="col-lg-2">
    <ul id="classtabs" class="nav nav-pills nav-stacked" data-tabs="tabs">
        <li class="active"><a href="#allclasses" data-toggle="tab">All Classes</a></li>
        <li><a href="#sec1" data-toggle="tab">MPC-S1</a></li>
        <li><a href="#sec2" data-toggle="tab">MPC-S2</a></li>
        <li><a href="#sec3" data-toggle="tab">MPC-S3</a></li>
    </ul>
  </div>
  <div class="col-lg-10">
    <div id="my-class-tab-content" class="tab-content">
        <div class="tab-pane active" id="allclasses">
            <div class="panel">
            <div class="panel-heading">
            <strong><span class="glyphicon glyphicon-star"></span> Class Performance</strong>
            </div>
           <div id="chart"></div>
        </div>
        </div>
        <div class="tab-pane" id="sec1">
          <div id="chart2"></div>
        </div>
        <div class="tab-pane" id="sec2">
            
        </div>
        <div class="tab-pane" id="sec3">
         
        </div>
    </div>
</div>
 </div>

 </div>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#classtabs').tab();
    });
</script>    
<script src="js/teacher_dashboard_chart.js"></script>

    <script src="js/holder.js"></script>
    <script src="js/trulia_trends.js"></script>