<style>

	.bar {
		fill: steelblue;
	}

	.bar:hover {
		fill: brown;
	}

	.axis {
		font: 10px sans-serif;
	}

	.axis path,
	.axis line {
		fill: none;
		stroke: #000;
		shape-rendering: crispEdges;
	}

</style>

<h3 class="page-header">Report Card</h3>
<div class="row">
	<div class="col-md-12">
		<section class="block leaderboard">
			<h4>Strength</h4>
			<div class="body">
				<!-- Report Card Filter Options -->
				<div class="filter-options">
					<ul class="nav">
						<?php foreach($this->courses as $i => $course): ?>
							<?php if($course->isIntroCourse()) continue; ?>
							<li>
								<a href="#reportcard-<?= $course->course_id ?>" data-course-id="<?= $course->course_id; ?>" data-toggle="tab"><?= $course->name ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class='row' id="legend"></div>

				<!-- Report Card Graph Panes -->
				<div class="tab-content">
					<div class="tab-pane active" style="text-align:center;" id="reportcard-landing">
						Choose a course above to see your report card.
					</div>
					<?php foreach($this->courses as $course): ?>
						<div class="tab-pane" id="reportcard-<?= $course->course_id ?>">
							<div class='table-view' id="reportcard-table-<?= $course->course_id ?>">
								Loading data for <?= $course->name; ?>
							</div>
						</div>
					<?php endforeach; ?>	
				</div>
			</div>
		</section>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>js/d3.js"></script>
<script type="text/javascript">
	$(function(){

		$("ul.nav li a[data-toggle=tab]").on("click", function(){
			console.log("ASDFASDF");
			var course_id = $(this).attr("data-course-id");
			var element_id = "#reportcard-chart-"+course_id;
			var table_element_id = "#reportcard-table-"+course_id;
			var legend_element_id = "#legend";

			// Dont draw the grap multiple times
			if($(element_id).attr("data-chart-loaded") == 1) {
				return ;
			}

			// Go get the report card data for this course
			$.get(base_url+"report_data/question_report/"+course_id, {}, function(data){
				buildTable(table_element_id, data);
			});

		});

		$("ul.nav li a[data-toggle=tab]")[0].click();
	});

	function barColor(score) {
		if(score >= 90) {
			return "#FFD700";		// Gold
		} else if(score >= 75) {
			return "#C0C0C0";		// Silver
		} else if(score >= 65) {
			return "#8C7853";		// Bronze
		} else {
			return "#FF0000";		// Plain
		}
	}


  	function buildTable(element_id, course_data) {
		// Create the table
		var table = $("<table />")
			.css("width", "100%")
			.css("margin-top", "20px")
			.addClass("table table-striped");

		// Create the header
		var thead = $(
			"<thead>" + 
				"<tr>" + 
					"<th>Topic</th>" + 
					"<th>Right Answers</th>" + 
					"<th>Wrong Ansers</th>" + 
				"</tr>" + 
			"</thead>"
		);


		var numAverages = course_data.averages.length;
		for(var i = 0 ; i < numAverages ; i++) {
			var average = course_data.averages[i];
			
			var row = $("<tr />");

			// Add the topic name
			if(average.is_parent == 1) {
				row.append("<td><strong>" + average.topic_name + "</strong></td>");
				row.append("<td><strong>"+average.right_answers+"</strong></td>");
				row.append("<td><strong>"+average.wrong_answers+"</strong></td>");
			} else {
				row.append("<td style='padding-left:20px'>" + average.topic_name + "</td>");
				row.append("<td>"+average.right_answers+"</td>");
				row.append("<td>"+average.wrong_answers+"</td>");
			}
			table.append(row);
		}

		// Build and add the table
		$(table).append(thead);
		$(element_id).html(table);
  	}
</script>