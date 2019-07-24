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
           <div id="chart">
           	</div>
        </div>
        </div>
        <div class="tab-pane" id="sec1">
          <div id="chart2"></div>
          <div id="chart3" style="display:none;">
            <h3>Student Breakdown For Exam1 <small><a href='#' id="return_from_chart">Return</a></small></h3>
            <div class="row">
                <table class="table" style="width:90%; margin:auto;">
                    <thead><tr><th>Student</th><th>Score</th></tr></thead>
                    <tbody>
                        <tr><td>Student 1</td><td>100.0%</td></tr>
                        <tr><td>Student 2</td><td>96.0%</td></tr>
                        <tr><td>Student 3</td><td>90.0%</td></tr>
                        <tr><td>Student 4</td><td>80.0%</td></tr>
                        <tr><td>Student 5</td><td>70.0%</td></tr>
                        <tr><td>Student 6</td><td>65.0%</td></tr>
                        <tr><td>Student 7</td><td>50.0%</td></tr>
                    </tbody>
                </table>
            </div>

            <h3>Question Breakdown For Exam1</h3>
            <div class="row">
                <table class="table" style="width:90%; margin:auto;">
                    <thead><tr><th>Question</th><th>Topic</th><th>Class Accuracy</th></tr></thead>
                    <tbody>
                        <tr><td>Question 1</td><td>Physics</td><td>100.0%</td></tr>
                        <tr><td>Question 2</td><td>Calculus</td><td>96.0%</td></tr>
                        <tr><td>Question 3</td><td>Physics</td><td>90.0%</td></tr>
                        <tr><td>Question 4</td><td>Physics - Fluid Dynamics</td><td>80.0%</td></tr>
                        <tr><td>Question 5</td><td>Chemistry</td><td>70.0%</td></tr>
                        <tr><td>Question 6</td><td>Physics - Electricity</td><td>65.0%</td></tr>
                        <tr><td>Question 7</td><td>Algebra</td><td>50.0%</td></tr>
                    </tbody>
                </table>
            </div>

            <h3>Topic Breakdown For Exam1</h3>
            <div class="row">
                <table class="table" style="width:90%; margin:auto;">
                    <thead><tr><th>Topic</th><th>Class Accuracy</th></tr></thead>
                    <tbody>
                        <tr><td>Algebra</td><td>100.0%</td></tr>
                        <tr><td>Calculus</td><td>96.0%</td></tr>
                        <tr><td>Calculus - Integration</td><td>90.0%</td></tr>
                        <tr><td>Physics - Fluid Dynamics</td><td>80.0%</td></tr>
                        <tr><td>Chemistry</td><td>70.0%</td></tr>
                        <tr><td>Physics - Electricity</td><td>65.0%</td></tr>
                        <tr><td>Calculus - Differential Equations</td><td>50.0%</td></tr>
                    </tbody>
                </table>
            </div>
            <br /><br />
          </div>
        <div id="chart6"></div>
        </div>
        <div class="tab-pane" id="sec2">
                      <div id="chart4"></div>
        </div>
        <div class="tab-pane" id="sec3">
                   <div id="chart5"></div>
        </div>
    </div>
</div>
 </div>

 </div>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#classtabs').tab();

        $("#return_from_chart").click(function(){ ExamClassPerformanceChart.hide(); return false; });
    });
</script>    
<script src="js/teacher_dashboard_chart.js"></script>

    <script src="js/holder.js"></script>
    <script src="js/ExamClassPerformanceChart.js"></script>
    <script src="js/class_report.js"></script>
    <script src="js/class_report1.js"></script>
    <script src="js/class_report2.js"></script>