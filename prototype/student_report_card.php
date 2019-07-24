
      <div class="container">
        <!-- END Top Row -->

        <!-- BEGIN Graph Area -->
        <div class="row">
        <div class="col-lg-12">
			<div class="panel">
				<div class="panel-heading">
					<strong><span class="glyphicon glyphicon-star"></span> Performance
						Meter</strong>
				</div>
				        <div class="row" style="text-align:center">
				<div class="col-lg-4">
					<span id="mathGaugeContainer"></span>
					</div>
					 <div class="col-lg-4">
					 <span id="physicsGaugeContainer"></span>
					 </div> 
					 <div class="col-lg-4">
					 <span id="chemistryGaugeContainer"></span> 
					 </div>
				</div>
				</div>
			<div class="panel">
            <div class="panel-heading">
            <strong><span class="glyphicon glyphicon-star"></span> Scores</strong>
            </div>
           <div id="graph"></div>

           <table class="table">
              <thead>
                <tr>
                  <th>Exam</th>
                  <th>Date</th>
                  <th>Math</th>
                  <th>Physics</th>
                  <th>Chemistry</th>
                  <th>Total</th>
                  <th>Rank</th>
                  <th>Review</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Week 1</td>
                  <td>July 1, 2013</td>
                  <td>10</td>
                  <td>10</td>
                  <td>10</td>
                  <td>30</td>
                  <td>5</td>
                  <td><a href='student_exam.php?rem=1'>Review</a></td>
                </tr>
                <tr>
                  <td>Week 2</td>
                  <td>July 8, 2013</td>
                  <td>10</td>
                  <td>10</td>
                  <td>10</td>
                  <td>30</td>
                  <td>5</td>
                  <td><a href='student_exam.php?rem=1'>Review</a></td>
                </tr>
                <tr>
                  <td>Week 3</td>
                  <td>July 15, 2013</td>
                  <td>10</td>
                  <td>10</td>
                  <td>10</td>
                  <td>30</td>
                  <td>5</td>
                  <td><a href='student_exam.php?rem=1'>Review</a></td>
                </tr>
                <tr>
                  <td>Week 4</td>
                  <td>July 23, 2013</td>
                  <td>10</td>
                  <td>10</td>
                  <td>10</td>
                  <td>30</td>
                  <td>5</td>
                  <td><a href='student_exam.php?rem=1'>Review</a></td>
                </tr>
              </tbody>
            </table>

        </div>
        </div>
        </div>

        


    <script src="js/holder.js"></script>

    <script src="js/stacked_chart.js"></script>
    <script src="js/student_performance_meter_chart.js"></script>
    <script>
loadGaugeChart();
</script>
</div>