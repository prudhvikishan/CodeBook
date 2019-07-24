<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/datepicker.css">
<script type="text/javascript" src="<?= base_url(); ?>js/bootstrap-datepicker.js"></script>

<h3 class="page-header">Admin Reports</h3>

<section class="block track-head">
	<h4>User Activity</h4>
	<div class="body">

		<div class="row">
			<div class='col-md-6'>
				<strong>Choose Course</strong>
				<select id="course-selection" class="form-control">
					<option value="-1">All Courses</option>
					<?php foreach($this->courses as $course): ?>
						<option value="<?= $course->course_id ?>"><?= $course->name ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class='col-md-6'>
				<strong>Choose Time Frame</strong>
				<div class='row'>
					<div class='col-md-6'><input type='text' name='startDate' class='form-control datepicker' placeholder="Start Date" /></div>
					<div class='col-md-6'><input type='text' name='endDate' class='form-control datepicker' placeholder="End Date" /></div>
				</div>
			</div>
		</div>

		<hr>

		<div class="row">
			<div class="col-md-12">

				<table id="maintable" class='table table-bordered dt'>
					<thead>
						<tr>
							<th>User Id</th>
							<th>Name</th>
							<th>Email</th>
							<th>Content (minutes)</th>
							<th>Videos (minutes)</th>
							<th>Exams (minutes)</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>

			</div>
		</div>
	</div>
</section>

<script>
$(function(){
	var startDate = null;
	var endDate = null;
	var course = null;

	function buildTable(data) {
		var table = $("#maintable");
		var tbody = $("tbody", table);

		tbody.html("");
		for(var i in data) {
			var row = data[i];
			var tr = $("<tr />");
			tr.append("<td>" + row.user_id + "</td>");
			tr.append("<td><a href='" + base_url + "admin/user/" + row.user_id + "'>" + row.name + "</a></td>");
			tr.append("<td>" + row.email + "</td>");
			tr.append("<td>" + (row.inline_html ? prepareTime(row.inline_html) : 0) + "</td>");
			tr.append("<td>" + (row.video ? prepareTime(row.video) : 0) + "</td>");
			tr.append("<td>" + (row.exams ? prepareTime(row.exams) : 0) + "</td>");
			tbody.append(tr);
		}
	}

	function prepareTime(time) {
		return (parseFloat(time) / 1000.0 / 60.0).toFixed(2);
	}

	function refreshTableData() {
		$.get(base_url + "admin/users_data/" + (course ? course : "-1") + (startDate ? "/" + startDate.getTime() / 1000.0 : "/") + (endDate ? "/" + endDate.getTime() / 1000.0 : ""), {}, function(data){
			buildTable(data);
		}, "json");
	}
	refreshTableData();

	// Bind events
	$("#course-selection").on("change", function(){
		course = $(this).val();
		console.log("Set Course", course);
		refreshTableData();
	});

	// Bind the Date Pickers
	$(".datepicker").datepicker();
	$(".datepicker").on("changeDate", function(evt){
		$(evt.target).datepicker("hide");
		if($(this).attr("name") === "startDate") {
			startDate = evt.date;
		} else if($(this).attr("name") === "endDate") {
			endDate = evt.date;
		}

		refreshTableData();
	});
});
</script>

<script>
	$(document).ready(function() {

		$('.dt').dataTable();

	});
</script>