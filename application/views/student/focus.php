<style>

	.arc path {
	  stroke: #fff;
	}

	.legend {
		position: absolute;
		right:0px;
		top:0px;
	}

	.legend table {
		float:right;
		clear:both;
	}

	.legend table tr td,
	.legend table tr th {
		padding: 5px;
	}

	td.number {
		text-align: right;
	}

	.tab-pane {
		position: relative;
	}

</style>
<h3 class="page-header">Focus</h3>
<div class="row">
	<div class="col-md-12">
		<section class="block leaderboard">
			<h4>Monitor Your Focus</h4>
			<div class="body">
				<!-- Filter Options -->
				<div class="filter-options">
					<ul class="nav">
						<li><a href="#focus-7days" data-timeframe="7days" data-toggle="tab">Past 7 Days</a></li>
						<li><a href="#focus-thismonth" data-timeframe="thismonth" data-toggle="tab">This Month</a></li>
						<li><a href="#focus-thisyear" data-timeframe="thisyear" data-toggle="tab">This Year</a></li>
						<li><a href="#focus-lastmonth" data-timeframe="lastmonth" data-toggle="tab">Last Month</a></li>
						<li><a href="#focus-lastyear" data-timeframe="lastyear" data-toggle="tab">Last Year</a></li>
					</ul>
				</div>

				<!-- Report Card Graph Panes -->
				<div class="tab-content">
					<div class="tab-pane active" style="text-align:center;" id="reportcard-landing">
						Choose a time frame above to see your focus chart.
					</div>
					<div class="tab-pane" id="focus-7days">
						<div class='chart-view' id="focus-chart-7days">
							Loading data for Past 7 Days
						</div>
					</div>
					<div class="tab-pane" id="focus-thismonth">
						<div class='chart-view' id="focus-chart-thismonth">
							Loading data for This Month
						</div>
					</div>
					<div class="tab-pane" id="focus-thisyear">
						<div class='chart-view' id="focus-chart-thisyear">
							Loading data for This Year
						</div>
					</div>
					<div class="tab-pane" id="focus-lastmonth">
						<div class='chart-view' id="focus-chart-lastmonth">
							Loading data for Last Month
						</div>
					</div>
					<div class="tab-pane" id="focus-lastyear">
						<div class='chart-view' id="focus-chart-lastyear">
							Loading data for Last Year
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>	
</div>

<script type="text/javascript" src="<?= base_url(); ?>js/d3.js"></script>
<script type="text/javascript">
	$(function(){

		$("ul.nav li a[data-toggle=tab]").on("click", function(){
			var timeFrame = $(this).attr("data-timeframe");
			var element_id = "#focus-chart-"+timeFrame;
			console.log("Load graph for " + timeFrame);

			// Dont draw the grap multiple times
			if($(element_id).attr("data-chart-loaded") == 1) {
				return ;
			}

			// Go get the report card data for this course
			$.get(base_url+"report_data/focus_chart/"+timeFrame, {}, function(data){
				var table = $("<table class='table table-bordered tabled-hover' />");
				table.append("<thead><tr><th>Course</th><th>Topic</th><th>Total Time Spent (minutes)</th><th>Percent of Time in Course</th><th>Total Percent of Time</th></tr></head>");
				var tbody = $("<tbody />");

				var data = data.results;

				// Loop over the data and compute totals
				var courseTotalData = [];
				var topicTotalData = {};
				var totalTime = 0;

				for(var k in data) {
					var total = 0;
					var subtopicTotalData = [];
					for(var subtopic in data[k]) {
						var time = parseInt(data[k][subtopic]);
						subtopicTotalData.push({"topic":subtopic, "total":time});
						total += time;
						totalTime += time;
					}

					// sort the subtopics and push them to the topicTotalData
					subtopicTotalData = subtopicTotalData.sort(function(a,b){ return b.total - a.total; });
					topicTotalData[k] = subtopicTotalData;

					courseTotalData.push({"course":k, "total":total});
				}

				// Sort the course totals
				// courseTotalData = courseTotalData.sort(function(a,b){ return b.total - a.total; });				

				// Loop over the first level keys of the result
				for(var k in courseTotalData) {
					var courseName = courseTotalData[k].course;
					var courseTotal = courseTotalData[k].total;
					var courseData = data[courseName];
					
					var tr = $("<tr />");

					// the first column has a rowspan to cover the rest
					tr.append("<td rowspan='"+Object.keys(courseData).length+"'><strong>" + courseName + "</strong></td>");

					var subtopicOrder = topicTotalData[courseName];
					for(var subtopic in subtopicOrder) {
						subtopic = subtopicOrder[subtopic];
						tr.append("<td>" + subtopic.topic + "</td>");
						tr.append("<td class='number'>" + (parseInt(subtopic.total) / 1000.0 / 60.0).toFixed(2) + "</td>");
						tr.append("<td class='number'>" + (parseInt(subtopic.total) / courseTotal * 100.0).toFixed(0) + "%</td>");
						tr.append("<td class='number'>" + (parseInt(subtopic.total) / totalTime * 100.0).toFixed(0) + "%</td>");

						tbody.append(tr);
						tr = $("<tr />");
					}
				}
				
				$(table).append(tbody);
				$("#focus-chart-"+timeFrame).html(table);
			}, "json");
		});

		$("ul.nav li a[data-toggle=tab]")[0].click();
	});

</script>