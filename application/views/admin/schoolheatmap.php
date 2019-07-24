<style>
  rect.bordered {
    stroke: #E6E6E6;
    stroke-width:2px;   
  }

  text.mono {
    font-size: 9pt;
    font-family: Consolas, courier;
    fill: #aaa;
  }

  text.axis-workweek {
    fill: #000;
  }

  text.axis-worktime {
    fill: #000;
  }
</style>

<h3 class="page-header">Admin Reports</h3>

<section class="block track-head">
	<h4>School Heatmap</h4>
	<div class="body">
    <div class="row">
      <div class='col-md-3'>
        Choose School<br />
        <select class='form-control' id="school-selector">
          <option value='all'>All</option>
          <?php foreach($this->schools as $school): ?>
            <option value='<?= $school->school_id; ?>'><?= $school->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class='col-md-3'>
        Choose Class<br />
        <select class='form-control' id="section-selector">
          <option value='all'>All</option>
          <?php foreach($this->sections as $section): ?>
            <option value='<?= $section->school_section_id; ?>'><?= $section->section; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class='col-md-3'>
        Choose Course<br />
        <select class='form-control' id="course-selector">
          <option value='all'>All</option>
          <?php foreach($this->courses as $course): ?>
            <option value='<?= $course->course_id; ?>'><?= $course->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class='col-md-3'>
        <br />
        <button class='btn btn-primary' id="update-button">Update</button>
      </div>  
    </div>  

		<div class="row">
			<div class="col-md-12">
				<div id="graph"></div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript" src="<?= base_url(); ?>js/d3.js"></script>
<script type="text/javascript">
  $(function(){
    $("#update-button").on("click", function(){
      drawReport();
    })
  });

  function drawReport() {
    // Get the school and section
    var school = $("#school-selector").val();
    school = school === "all" ? null : school;
    var section = $("#section-selector").val();
    section = section === "all" ? null : section;
    var course = $("#course-selector").val();
    course = course === "all" ? null : course;

    // Set up some stuff
    var graph = $("#graph");
    var margin = { top: 10, right: 10, bottom: 200, left: 140 },
      width = $(graph).parent().width() - margin.left - margin.right,
      height = ($(graph).parent().width() * 0.75) - margin.top - margin.bottom,
      colors      = ["#ffffd9","#edf8b1","#c7e9b4","#7fcdbb","#41b6c4","#1d91c0","#225ea8","#253494","#081d58"].reverse(),
      fontColors  = ["#000000","#000000","#000000","#000000","#000000","#000000","#ffffff","#ffffff","#ffffff"].reverse(),
      buckets = 9;

    // Go get the data.
    var url = "<?php echo base_url() ?>report_data/school_heatmap_data/" + (school === null ? 0 : school) + "/" + (section === null ? 0 : section) + "/" + (course === null ? 0 : course);
    console.log("[UPDATE]", url);
    $.get(
      url, 
      {}, 
      function(data){
        // Compute the max/min scores and build the color scale.
        var scoreExtent = d3.extent(data, function(d){ return parseFloat(d.score); });
        scoreExtent = [0,100];
        var colorScale = d3.scale.quantile()
              .domain(scoreExtent)
              .range(colors);
        var fontColorScale = d3.scale.quantile()
              .domain(scoreExtent)
              .range(fontColors);

        // Figure out how many students there are, figure out the grid cell height and create the scale for the y-axis.
        var students = d3.set(data.map(function(d){ return d.firstname + " " + d.lastname; })).values();
        var gridHeight = (height / students.length);
        
        // Figure out how man exams there are, figure out the grid cell width and create the scale for the x-axis.
        var exams = d3.set(data.map(function(d){ return examName(d); })).values();
        var gridWidth = (width / exams.length);

        if(gridHeight > gridWidth) {
          gridWidth = gridHeight;
        }
        if(gridWidth > gridHeight) {
          gridHeight = gridWidth;
        }

        gridHeight = Math.min(50, gridHeight);
        gridWidth  = Math.min(50, gridWidth);

        height = gridHeight * students.length;
        width = gridWidth * exams.length;

        var y = d3.scale.ordinal().rangeRoundBands([0, height], .1).domain(students);
        var x = d3.scale.ordinal().rangeRoundBands([0, width], .1).domain(exams);

        var padding = gridHeight * 0.05;

        // Clear out the old graph.
        graph.html("");

        // Build the svg.
        var svg = d3.select("#graph").append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

        // Draw the X-Axis
        var examLabels = svg.selectAll(".examLabel")
              .data(exams)
              .enter().append("text")
                .attr("class", "examLabel")
                .attr("data-exam", function(d){ return d; })
                .attr("x", height )
                .attr("y", function (d) { return -1 * x(d) - (gridWidth / 4.0); })
                .text(function (d) { return d; })
                .attr("transform", "rotate(90)");

        // Draw the Y-Axis
        var studentLabels = svg.selectAll(".studentLabel")
              .data(students)
              .enter().append("text")
                .attr("class", "studentLabel")
                .attr("data-student", function(d){ return d; })
                .attr("x", 0)
                .attr("y", function (d) { return y(d) + (gridHeight / 2.0); })
                .attr("text-anchor", "end")
                .text(function (d) { return d; });

        // Draw the data.
        var gridCells = svg.selectAll(".gridCell")
          .data(data)
          .enter();

        gridCells.append("rect")
            .attr("class", "gridCell")
            .attr("x", function(d){ return x(examName(d)); })
            .attr("y", function(d){ return y(d.firstname + " " + d.lastname); })
            .attr("width", gridWidth - (padding))
            .attr("height", gridHeight - (2 * padding))
            .attr("fill", function(d){ return colorScale(d.score); })
            .on("mouseenter", function(d){
              $(this).css("stroke", "black");
              $("[data-student='" + d.firstname + " " + d.lastname + "']").css("font-weight", "bold");
              $("[data-exam='" + examName(d) + "']").css("font-weight", "bold");
            })
            .on("mouseleave", function(d){
              $(this).css("stroke", "none");
              $("[data-student='" + d.firstname + " " + d.lastname + "']").css("font-weight", "normal");
              $("[data-exam='" + examName(d) + "']").css("font-weight", "normal");
            });

        gridCells.append("text")
              .text(function(d){ return parseFloat(d.score).toFixed(2); })
              .attr("x", function(d){ return x(examName(d)); })
              .attr("y", function(d){ return y(d.firstname + " " + d.lastname); })
              .attr("font-size", 12)
              .attr("text-anchor", "middle")
              .attr("dy", (gridHeight / 2.0) + 2)
              .attr("dx", (gridWidth / 2.0) - 3)
              .style("width", gridWidth - padding)
              .style("height", gridHeight - (2 * padding) )
              .style("fill", function(d){ return fontColorScale(d.score); })
              .attr("pointer-events", "none");
      }, 
      "json"
    );
  }

  function examName(d) {
    return d.topic_name.substring(0, 12) + " - (Level " + d.exam_type + ")";
  }
</script>