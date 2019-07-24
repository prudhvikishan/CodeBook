<h3 class="page-header"><?php echo $topic->name; ?> - Exam: Level <?php echo $exam->exam_type;?> Results </h3>
<!--<?php foreach ($badges as $p => $badge) { ?>
Congratulations!! you got 
<img height="100" width="100" src="<?= base_url(); ?><?= $badge->icon_path?>" />
<?php }?>

You have earned <?php echo $points?> points for this exam. -->
<!-- Plugin real content below for popup content when exam is in review -->

<div class="row mb">
	<?php if(count($badges) > 0) { ?>
	<div class='col-md-4 mb'>
		<div class='earned-content badges-earned'>
			<h5>Badges Earned</h5>
			<div class='badges'>
				<?php foreach($badges as $badge): ?>
					<i class='<?= $badge->icon_path; ?>'></i>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class='col-md-4'>
	<?php } else {  ?>
	<div class='col-md-6'>
	<?php }?>
		<div class='earned-content level-earned'>
			<h5>Score</h5>
			<div class='level'>
				<div class='level-reason'>
					<h6>Exam Complete!</h6>
					<p><?php echo $score?>%</p>
				</div>
			</div>
		</div>
	</div>
	<?php if(count($badges) > 0) { ?>
	<div class="col-md-4">
	<?php } else { ?>
	<div class="col-md-6">
	<?php } ?>
		<div class="earned-content points-earned">
			<h5>Points Earned</h5>
			<ul>
				<li>
					<div class="point-count"><?php echo $points;?></div>
					<div class="point-reason">
						<h6>Points for questions</h6>
						<p><?php echo $correct_count;?> questions answered correct.</p>
					</div>
				</li>
				<?php if($bonus != 0) {?>
				<li>
					<div class="point-count"><?php echo $bonus;?></div>
					<div class="point-reason">
						<h6>Points for completion</h6>
						<p>Bonus completion points.</p>
					</div>
				</li>
				<?php }?>
				<li class="total-point-count">
					<div class="point-count"><?php echo $points+$bonus; ?></div>
					<div class="point-reason">
						<h6>Total Points</h6>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-lg-12">

		<?php $count = 1;?> 
		<input type="hidden" name="count" id="count" value="<?php echo $count ?>"/>
		<input type="hidden" id="total_questions_count" name="total_questions_count" value="<?php echo $total_question_count ?>"/>


		<?php foreach ($questions as $m => $question) { ?>

		<section class="block exam-question">

			<h4>Question <?php echo $count;?></h4>

			<div class="body">

				<div class="answer-container" id="questionContainer_<?php echo $count;?>">

					<h5 class="question"><?= $count . ".) " . str_ireplace('<p>','',$question->question_text); ?></h5>
					<?php if($question->image_path != null): ?><img src='<?= base_url() . $question->image_path; ?>' class='question_image' /><?php endif; ?>
					<?php $choices = $question->getAnswers(); $is_correct = false; $l = 0;
					foreach ($choices as $k =>$choice){?>

					<div class="radio">
						<label>
							<input disabled type='radio' id='choice_<?php echo $count ?>' name='choice_<?php echo $count ?>' value='<?php echo $choice->question_answer_id ?>' <?php if($user_chosen_answers[$m] == $choice->question_answer_id) echo 'checked';?>  />
							<p><?php if($k+1 ==1){echo 'A';}else if($k+1 ==2){echo 'B';}else if($k+1 ==3){echo 'C';}else if($k+1 ==4){echo 'D';}else if($k+1 ==5){echo 'E';}?>) <?php echo str_ireplace('<p>','',$choice->answer_text); ?></p>

<?php if($correct_answers[$m] == $user_chosen_answers[$m]) $is_correct = true; 
if($correct_answers[$m] == $choice->question_answer_id){$l=$k+1;}?>
</label>
</div>

<?php }?>
<?php if($is_correct == false) { ?> <br><i class="fa fa-times-circle-o fa-2x" style="color:red"></i> Wrong. Correct answer is <?php if($l ==1){echo 'A';}else if($l ==2){echo 'B';}else if($l ==3){echo 'C';}else if($l ==4){echo 'D';}else if($l ==5){echo 'E';}?>.  <?php } else { ?>  <br> <i class="fa fa-check-circle-o fa-2x" style="color:green"></i> Correct. <?php } ?>

 <div style="padding-top:15px">
 	<a class="toggle-link toggler no-underline" href="#sol_<?php echo $question->question_id;?>" style="text-decoration: none">
     <span><i class="fa fa-chevron-down"></i> show explanation</span>
     <span style="display: none;"><i class="fa fa-chevron-up"></i> hide explanation</span>
    </a>
 </div>
 <div id="sol_<?php echo $question->question_id;?>" class="slide togglee" style="display: none;padding-top:20px">
       <?php echo $question->explanation; ?>
       <?php $topics= $question->getQuestionTopics(); if($topics != null && count($topics) > 0) {?>
       <span>Related Topics :</span>
      <?php foreach($topics as $t): ?>
      		<?php if($t->getParentTopic() == null){ ?>
      			<a href="<?= site_url('student/learning_map/'.encode($course_id).'#sub-topic-'. $t->topic_id); ?>"> <?php echo $t->name ?></a>
      			<?php } else {
      			$first = $t->getFirstContent();	?>
      			<a href="<?= base_url(); ?>content/review/<?php echo $first ? encode($first->content_id) : -1; ?>"><?php echo $t->name ?></a>
      			<?php } ?>
      <?php endforeach; ?>
       <?php } ?>
 </div>
</div>
</div>

</section>

<?php $count++; }?>

	 <section class="block leaderboard">
			<h4>
				Strength Meter
			</h4>
			<div class="body"> 
				<div class="tab-content">
					<div class="tab-pane active" id="leaderboard-all">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Sub Topic</th>
									<th>Total</th>
									<th>Correct</th>
									<th>Wrong</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($topicquestions as $tq): ?>
									<?php if($topic->topic_id != $tq->topic_id) { ?>
									<tr><?php if($tq->content_id != null) { ?>
										<td><a href="<?= site_url('content/review/'.encode($tq->content_id)); ?>"> <?= $tq->name; ?></a></td>
										<?php } else { ?>
										<td><a href="<?= site_url('student/learning_map/'.encode($course_id).'#sub-topic-'. $tq->topic_id); ?>"> <?= $tq->name; ?></a></td>
										<?php } ?>
										<td><?= $tq->total; ?></td>
										<td><?= $tq->correct; ?></td>
										<td><?= $tq->wrong; ?></td>
									</tr>
									<?php } ?>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>

<div class="center">
<a href="<?= site_url('student/learning_map/' .encode($course_id)); ?>" class="btn btn-secondary mb">Back to Course</a>
	<!-- <a id="bootbox-link" class="btn btn-secondary mb">Demo Popup</a> -->
</div>

</div>
</div>



<script>

$(document).ready(function() {

	//$("#bootbox-link").on('click', function() {
			<?php if($first_time) {?>

		var bootboxMessage = "";


		<?php if($level_changed) {?>
		bootboxMessage += "<div class='row mb'>";
		bootboxMessage += "<div class='col-md-12'>";

		bootboxMessage += "<div class='earned-content level-earned'>";
		bootboxMessage += "<h5>Level Up!</h5>";
		bootboxMessage += "<div class='level'>";
		bootboxMessage += "<div class='level-reason'>";
		bootboxMessage += "<h6>Congratulations!</h6>";
		bootboxMessage += "<p><i class='fa fa-fw fa-thumbs-up'></i> You're now level <?php echo $level;?>!</p>";
		bootboxMessage += "</div></div>";
		bootboxMessage += "</div>";

		bootboxMessage += "</div></div>";
		<?php } ?>
		
		bootboxMessage += "<div class='row mb'>";
		bootboxMessage += "<div class='col-md-12'>";

		bootboxMessage += "<div class='earned-content level-earned'>";
		bootboxMessage += "<h5>Exam Score</h5>";
		bootboxMessage += "<div class='level'>";
		bootboxMessage += "<div class='level-reason'>";
		bootboxMessage += "<h6>Exam Complete!</h6>";
		bootboxMessage += "<p><?= $score; ?>%</p>";
		bootboxMessage += "</div></div>";
		bootboxMessage += "</div>";

		bootboxMessage += "</div></div>";
		
		bootboxMessage += "<div class='row'>";
		<?php if(count($badges) > 0) {?>
		bootboxMessage += "<div class='col-md-6'><div class='earned-content badges-earned'>";
		bootboxMessage += "<h5>Badges Earned</h5>";
		bootboxMessage += "<div class='badges'>";
		// bootboxMessage += "<i class='fa fa-fw fa-star'></i>";
		<?php foreach($badges as $badge): ?>
			bootboxMessage += "<i class='<?= $badge->icon_path; ?>'></i>";
			bootboxMessage += "<h4><?= $badge->badge_name; ?> Badge</h4>";
		<?php endforeach; ?>
		bootboxMessage += "</div>";
		bootboxMessage += "</div></div>";
		bootboxMessage +="<div class='col-md-6'>";
		<?php } else {  ?>
		bootboxMessage +="<div class='col-md-12'>";
		<?php }?>
		bootboxMessage += "<div class='earned-content points-earned'>";
		bootboxMessage += "<h5>Points Earned</h5>";
		bootboxMessage += "<ul>";

		bootboxMessage += "<li>";
		bootboxMessage += "<div class='point-count'>";
		bootboxMessage += "<?php echo $points?>";
		bootboxMessage += "</div>";
		bootboxMessage += "<div class='point-reason'>";
		bootboxMessage += "<h6>Points for questions</h6>";
		bootboxMessage += "<p><?php echo $correct_count;?> questions answered correct.</p>";
		bootboxMessage += "</div>";
		bootboxMessage += "</li>";
		<?php if($bonus != 0) {?>
		bootboxMessage += "<li>";
		bootboxMessage += "<div class='point-count'>";
		bootboxMessage += "<?php echo $bonus;?>";
		bootboxMessage += "</div>";
		bootboxMessage += "<div class='point-reason'>";
		bootboxMessage += "<h6>Points for completion</h6>";
		bootboxMessage += "<p>Bonus completion points.</p>";
		bootboxMessage += "</div>";
		bootboxMessage += "</li>";
		<?php }?>

		bootboxMessage += "<li class='total-point-count'>";
		bootboxMessage += "<div class='point-count'>";
		bootboxMessage += "<?php echo $points+$bonus?>";
		bootboxMessage += "</div>";
		bootboxMessage += "<div class='point-reason'>";
		bootboxMessage += "<h6>Total Points</h6>";
		bootboxMessage += "</div>";
		bootboxMessage += "</li>";

		bootboxMessage += "</ul>";
		bootboxMessage += "</div></div>";

		bootbox.dialog({
			message: bootboxMessage,
			title: "<?php echo $topic->name; ?> - Exam: Level <?php echo $exam->exam_type;?>"
		});
		<?php }?>

//	});

});



$(function(){
    $(".toggler").click(function(e) {
        e.preventDefault();
        $(this).find("span").toggle();
		var collapse_content_selector = $(this).attr('href');					
		$(collapse_content_selector).slideToggle();
    });
});

</script>