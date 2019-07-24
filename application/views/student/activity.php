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

<h3 class="page-header">Recent Activity</h3>
<div class="row">
	<div class="col-md-12">
		
		<section class="block leaderboard">
			<h4>Monitor Your Work</h4>
			<div class="body">
				<!-- Filter Options -->
				<div class="filter-options">
					<ul class="nav">
						<li><a href="#activity-7days" data-timeframe="7days" data-toggle="tab">Past 7 Days</a></li>
						<li><a href="#activity-thismonth" data-timeframe="thismonth" data-toggle="tab">This Month</a></li>
						<li><a href="#activity-thisyear" data-timeframe="thisyear" data-toggle="tab">This Year</a></li>
						<li><a href="#activity-lastmonth" data-timeframe="lastmonth" data-toggle="tab">Last Month</a></li>
						<li><a href="#activity-lastyear" data-timeframe="lastyear" data-toggle="tab">Last Year</a></li>
					</ul>
				</div>

				<div class='row' id="legend"></div>

				<!-- Report Card Graph Panes -->
				<div class="tab-content">
					<div class="tab-pane active" style="text-align:center;" id="reportcard-landing">
						Choose a time frame above to see your activity chart.
					</div>
					<div class="tab-pane" id="activity-7days">
						<div class='chart-view' id="activity-chart-7days">
							Loading data for Past 7 Days
						</div>
					</div>
					<div class="tab-pane" id="activity-thismonth">
						<div class='chart-view' id="activity-chart-thismonth">
							Loading data for This Month
						</div>
					</div>
					<div class="tab-pane" id="activity-thisyear">
						<div class='chart-view' id="activity-chart-thisyear">
							Loading data for This Year
						</div>
					</div>
					<div class="tab-pane" id="activity-lastmonth">
						<div class='chart-view' id="activity-chart-lastmonth">
							Loading data for Last Month
						</div>
					</div>
					<div class="tab-pane" id="activity-lastyear">
						<div class='chart-view' id="activity-chart-lastyear">
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
			var element_id = "#activity-chart-"+timeFrame;
			console.log("Load graph for " + timeFrame);

			// Dont draw the grap multiple times
			// if($(element_id).attr("data-chart-loaded") == 1) {
			// 	return ;
			// }

			// Go get the report card data for this course
			$.get(base_url+"report_data/activity_chart/"+timeFrame, {}, function(data){
				buildGraph("#activity-chart-"+timeFrame, data.startDate, data.endDate, data.results);
			}, "json");
		}); 

		$("ul.nav li a[data-toggle=tab]")[0].click();

		function buildGraph(element_id, start, end, results) {
			start = new Date(start);
			start = start.setDate(start.getDate() - 1);
			end = new Date(end);

			var element = $(element_id);
			element.html("");
			element.attr("data-chart-loaded", 1);

			var data = [];
			var types= [];
			for(var date in results) {
				var obj = { "date":date, "times":[] };
				for(var type in results[date]) {
					typeName = convertTypeName(type);
					if(types.indexOf(typeName) < 0) {
						types.push(typeName);
					}
					obj.times.push({"date":date, "type":typeName, "time": parseInt(results[date][type]) / 1000.0 / 60.0});
				}
				data.push(obj);
			}

			// Prepare the graphs dimensions
			var margin = {top: 20, right: 20, bottom: 120, left: 40},
			width = $(element_id).width() - margin.left - margin.right,
			height = ($(element_id).width() / 1.92 ) - margin.top - margin.bottom;
			var xAxisCharacterLimit = 20;

			// Scales
			var x = d3.time.scale().domain([start, end]).rangeRound([0, width]);
			var days = (end - start) / (1000 * 60 * 60 * 24);
			var nextDay = new Date(start);
			nextDay.setDate(nextDay.getDate() + 1);
			var barWidth = x(nextDay) - x(start);
			var minY = d3.min(data, function(d){ return d.times.reduce(function(previousValue, d2){ return {"time": parseFloat(previousValue.time) + parseFloat(d2.time)}; }).time } );
			var maxY = d3.max(data, function(d){ return d.times.reduce(function(previousValue, d2){ return {"time": parseFloat(previousValue.time) + parseFloat(d2.time)}; }).time } );
			var y = d3.scale.linear().domain([ 0, maxY ]).range([height, 0]);
			var colorScale = d3.scale.category20().domain(types);

			// Axes
			var xAxis = d3.svg.axis()
				.scale(x)
				.tickFormat(d3.time.format('%b %d %Y'))
				.orient("bottom");
			if(days <= 35) { 
				xAxis.ticks(d3.time.days, 1);
			}

			var yAxis = d3.svg.axis()
				.scale(y)
				.orient("left");

			// Create and append the SVG element
			var svg = d3.select(element_id).append("svg")
				.attr("width", width + margin.left + margin.right)
				.attr("height", height + margin.top + margin.bottom)
				.append("g")
				.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

		  	// Render the data
		  	var dateStacks = {};
		  	svg.selectAll(".bars")
		  		.data(data)
		  		.enter()
		  		.append("g")
		  			.attr("class", "bars")
		  			.selectAll(".innerBar")
		  			.data(function(d){ return d.times; })
	  				.enter()
	  				.append("rect")
	  					.attr("class", "innerBar")
	  					.attr("x", function(d){ return x(d.date); })
	  					.attr("y", function(d, i){ 
	  						if(!dateStacks[d.date]) {
	  							dateStacks[d.date] = 0;
	  						}
	  						var offset = dateStacks[d.date];
	  						console.log(d.time, y(d.time));
	  						dateStacks[d.date] += height - y(d.time);
	  						return height - dateStacks[d.date] - 1; 
	  					})
	  					.attr("fill", function(d){ return colorScale(d.type); })
	  					.attr("height", function(d){ return height - y(d.time); })
	  					.attr("width", barWidth)
	  					.on("mouseenter", function(d){

	  					})
	  					.on("mouseleave", function(d){

	  					});

	  		// Render the Axes
	  		svg.append("g")
		  		.attr("class", "x axis")
		  		.attr("transform", "translate(0," + height + ")")
		  		.call(xAxis)
	  			.selectAll("text")
		  			.attr("transform", "translate(10,10)rotate(65)")
		  			.style("text-anchor", "start");

	  		svg.append("g")
		  		.attr("class", "y axis")
		  		.call(yAxis)
		  		.append("text")
		  		.attr("transform", "rotate(-90)")
		  		.attr("y", 6)
		  		.attr("dy", ".71em")
		  		.style("text-anchor", "end")
		  		.text("Time (minutes)");

		  	// Render a legend
		  	renderLegend(element, types, colorScale);
		}

		function renderLegend(element, types, colorScale) {
			$(".legend").remove();
			var legend = $("<div class='legend' />");
			$(element).prepend(legend);
			var margin = {top: 20, right: 20, bottom: 20, left: 20},
			width = $(element).width() - margin.left - margin.right,
			height = 75 - margin.top - margin.bottom;
		
			// Create and append the SVG element
			var svg = d3.select(".legend").append("svg")
				.attr("width", width + margin.left + margin.right)
				.attr("height", height + margin.top + margin.bottom)
				.append("g")
				.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

			var segmentWidth = (width / types.length);

			// Draw 4 boxes for each score grouping
			var scoreLow = 0;
			for(var i = 0 ; i < types.length ; i++) {			
				svg.append("rect")
					.attr("class", "type_" + i)
					.attr("width", segmentWidth)
					.attr("height", height / 2.0)
					.attr("x", segmentWidth * i)
					.style("fill", colorScale(types[i]));

				svg.append("text")
					.attr("class", "type_label" + i)
					.attr("width", segmentWidth)
					.attr("height", height / 2.0)
					.attr("x", (segmentWidth * i) + (segmentWidth / 2.0))
					.attr("y", height)
					.style("text-anchor", "middle")
					.text( types[i] );
			}
		};

		function convertTypeName(slug) {
			switch(slug) {
				case "inline_html":
					return "Notes";
				case "video":
					return "Video";
				case "questions":
					return "Exams";
				default:
					return slug;
			}
		}

	});

</script>