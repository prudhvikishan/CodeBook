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
			<h4>Monitor Your Grades</h4>
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
							<div class='chart-view' id="reportcard-chart-<?= $course->course_id ?>">
								Loading data for <?= $course->name; ?>
							</div>
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
			$.get(base_url+"report_data/report_card/"+course_id, {}, function(data){
				buildGraph(element_id, data);
				buildTable(table_element_id, data);
			});

			// just build the legedn once 
			buildLegend(legend_element_id);
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

	function buildGraph(element_id, course_data) {

		$(element_id).html("");
		$(element_id).attr("data-chart-loaded", 1);

		// Prepare the graphs dimensions
		var margin = {top: 20, right: 20, bottom: 120, left: 40},
		width = $(element_id).width() - margin.left - margin.right,
		height = ($(element_id).width() / 1.92 ) - margin.top - margin.bottom;
		var xAxisCharacterLimit = 20;

		// Create X and Y Scales 
		var x = d3.scale.ordinal().rangeRoundBands([0, width], .1, .1);
		var y = d3.scale.linear().range([height, 0]);

		// Create X and Y Axes
		var xAxis = d3.svg.axis()
			.scale(x)
			.orient("bottom");

		var yAxis = d3.svg.axis()
			.scale(y)
			.orient("left")
			.ticks(10, "%");

		// Create and append the SVG element
		var svg = d3.select(element_id).append("svg")
			.attr("width", width + margin.left + margin.right)
			.attr("height", height + margin.top + margin.bottom)
			.append("g")
			.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

		// Set the domain on the scales
		x.domain(course_data.topics.map(function(d) { return d.name; }));
		y.domain([0, 1]);

	  	// Now do a nested binding to create the bar triples.
	  	var cellWidth = x.rangeBand();
	  	var holder = svg.selectAll(".topic_wrapper")
		    .data(course_data.topics)
		    .enter()
		    	.append("g")
		    	.attr("class", "topic_wrapper")
		    	.attr("transform", function(topic){ return "translate(" + x(topic.name) + ",0)"; });

		   	holder.selectAll(".bar")
			    .data(function(d, i) { return d.exam_attempts; })
			   	.enter()
			   		.append("rect")
			   		.attr("class", "bar")
			   		.style("fill", function(attempt){ return barColor(attempt.score); })
			   		.attr("height", function(attempt){ return height - y(attempt.score / 100.0); })
			   		.attr("width", cellWidth / 3.0)
			  		.attr("x", function(attempt){ return (cellWidth / 3.0) * (attempt.exam_type - 1); })
			  		.attr("y", function(attempt) { return y(attempt.score / 100.0); });

		  	var labelEnter = holder.selectAll(".barLabel, .scoreLabel")
		  		.data(function(d, i){ return d.exam_attempts; })
		  		.enter();

		  		labelEnter.append("text")
		  			.attr("class", "barLabel")
		  			.text(function(d){ return "Level " + d.exam_type })
		  			.attr("transform", "rotate(90)translate(0,-5)")
		  			.attr("y", function(attempt){ return -1 * (cellWidth / 3.0) * (attempt.exam_type - 1); })
		  			.attr("x", height - 5)
		  			.style("text-anchor", "end");

		  		labelEnter.append("text")
		  			.attr("class", "scoreLabel")
		  			.text(function(d) { return parseFloat(d.score).toFixed(1); })
		  			.attr("x", function(attempt){ return ((cellWidth / 3.0) * (attempt.exam_type - 1)); })
		  			.attr("y", function(attempt){ return y(attempt.score / 100.0) - 1 });

		// Render the Axes
  		svg.append("g")
	  		.attr("class", "x axis")
	  		.attr("transform", "translate(0," + height + ")")
	  		.call(xAxis)
	  		.selectAll("text")
	  			.attr("transform", "translate(10,10)rotate(65)")
	  			.style("text-anchor", "start")
	  			.text(function(d){ return (d.length > xAxisCharacterLimit ? d.substr(0, xAxisCharacterLimit) + "..." : d); });

  		svg.append("g")
	  		.attr("class", "y axis")
	  		.call(yAxis)
	  		.append("text")
	  		.attr("transform", "rotate(-90)")
	  		.attr("y", 6)
	  		.attr("dy", ".71em")
	  		.style("text-anchor", "end")
	  		.text("Percentage");

	  	// Now build the average line
		var avgLineFunction = d3.svg.line()
			.x(function(d) { return (cellWidth / 8.0) + x(d.topic_name) + ((cellWidth / 3.0) * (d.exam_type - 1)) })
			.y(function(d) { return y(d.average / 100.0); })
			.interpolate("basis");
  		
  		var lineGraph = svg.append("path")
			.attr("d", avgLineFunction(course_data.averages.filter(function(d){ return d.average !== 0; })))
			.attr("stroke", "blue")
			.attr("stroke-width", 2)
			.attr("fill", "none");

		// Now build the high score line
		// var maxLineFunction = d3.svg.line()
		// 	.x(function(d) { return (cellWidth / 8.0) + x(d.topic_name) + ((cellWidth / 3.0) * (d.exam_type - 1)) })
		// 	.y(function(d) { return y(d.high_score / 100.0); })
		// 	.interpolate("basis");
  		
  // 		var lineGraph = svg.append("path")
		// 	.attr("d", maxLineFunction(course_data.averages.filter(function(d){ return d.high_score !== 0; })))
		// 	.attr("stroke", "lightgreen")
		// 	.attr("stroke-width", 2)
		// 	.attr("fill", "none");

  	}

  	function buildLegend(element_id) {
  		$(element_id).html("");
  		var scoreCutoffs = [65, 75, 90, 100];

		var margin = {top: 20, right: 20, bottom: 20, left: 20},
			width = $(element_id).width() - margin.left - margin.right,
			height = 75 - margin.top - margin.bottom;
		
		// Create and append the SVG element
		var svg = d3.select(element_id).append("svg")
			.attr("width", width + margin.left + margin.right)
			.attr("height", height + margin.top + margin.bottom)
			.append("g")
			.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

		var segmentWidth = (width / (scoreCutoffs.length + 1));

		// Draw 4 boxes for each score grouping
		var scoreLow = 0;
		for(var i = 0 ; i < scoreCutoffs.length ; i++) {
			var scoreHigh = scoreCutoffs[i];

			svg.append("rect")
				.attr("class", "score_cutoff_" + i)
				.attr("width", segmentWidth)
				.attr("height", height / 2.0)
				.attr("x", segmentWidth * i)
				.style("fill", barColor((scoreHigh + scoreLow) / 2.0));

			svg.append("text")
				.attr("class", "score_cutoff_label_" + i)
				.attr("width", segmentWidth)
				.attr("height", height / 2.0)
				.attr("x", (segmentWidth * i) + (segmentWidth / 2.0))
				.attr("y", height)
				.style("text-anchor", "middle")
				.text( i == 0 ? "less than " + scoreCutoffs[0] : "between " + scoreCutoffs[i-1] + " and " + scoreCutoffs[i]);

			scoreLow = scoreHigh;
		}

		// TODO: Draw the line which explains the average line
		svg.append("line")
			.attr("x1", segmentWidth * (scoreCutoffs.length+1) )
		    .attr("y1", (height / 4.0) )
		    .attr("x2", segmentWidth * scoreCutoffs.length )
		    .attr("y2", (height / 4.0) )
		    .attr("stroke", "blue")
			.attr("stroke-width", 2);

		svg.append("text")
				.attr("width", segmentWidth)
				.attr("height", height / 2.0)
				.attr("x", (segmentWidth * (scoreCutoffs.length)) + (segmentWidth / 2.0))
				.attr("y", height)
				.style("text-anchor", "middle")
				.text("Class Average");
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
					"<th>Level 1 Score</th>" + 
					"<th>Level 1 Average Score</th>" + 
					"<th>Level 2 Score</th>" + 
					"<th>Level 2 Average Score</th>" + 
					"<th>Level 3 Score</th>" + 
					"<th>Level 3 Average Score</th>" + 
				"</tr>" + 
			"</thead>"
		);

		// Loop over the topics and add rows
		var topics = course_data.topics;
		var topicCount = topics.length;
		for(var i = 0 ; i < topicCount; i++) {
			var topic = topics[i];

			// Create the row
			var row = $("<tr />");

			// Add the topic name
			row.append("<td>" + topic.name + "</td>");

			// Add the columns
			row.append("<td class='topic-"+topic.topic_id+"-level-1' > -- </td>");
			row.append("<td class='topic-"+topic.topic_id+"-level-1-average' > -- </td>");
			row.append("<td class='topic-"+topic.topic_id+"-level-2' > -- </td>");
			row.append("<td class='topic-"+topic.topic_id+"-level-2-average' > -- </td>");
			row.append("<td class='topic-"+topic.topic_id+"-level-3' > -- </td>");
			row.append("<td class='topic-"+topic.topic_id+"-level-3-average' > -- </td>");

			// Loop over the attempts and load in the scores.
			var numAttempts = topic.exam_attempts.length;
			for(var attempt = 0 ; attempt < numAttempts ; attempt++) {
				$(".topic-" + topic.topic_id + "-level-" + topic.exam_attempts[attempt].exam_type, row).html(topic.exam_attempts[attempt].score);
			}

			// Add the row to the table
			table.append(row);
		}

		// Loop over the averages and add them to the table
		var numAverages = course_data.averages.length;
		for(var i = 0 ; i < numAverages ; i++) {
			var average = course_data.averages[i];
			if(average.average !== 0) {
				$(".topic-"+average.topic_id+"-level-"+average.exam_type+"-average", table).html(average.average);
			}
		}

		// Build and add the table
		$(table).append(thead);
		$(element_id).html(table);
  	}
</script>