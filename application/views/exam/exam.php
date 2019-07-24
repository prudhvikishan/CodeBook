<h3 class="page-header"><?php echo $topic->name; ?> - Exam: Level <?php echo $exam->exam_type;?></h3>

<div class="row" id="page">
	<div class="col-lg-12">

		<form name="exam-form" id="exam-form" method="post" action="<?= base_url(); ?>exam/showResults/<?= encode($user_exam_attempt_id) ?>/<?= encode($no_of_questions) ?>/<?= encode($exam_id) ?>/<?=encode($topic->topic_id) ?>" >
			
			<section class="block exam-question">
				<?php $count = 1;?> 
				<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id ?>"/>
				<input type="hidden" name="exam_id" id="exam_id" value="<?php echo $exam_id ?>"/>
				<input type="hidden" name="user_exam_attempt_id" id="user_exam_attempt_id" value="<?php echo $user_exam_attempt_id ?>"/>
				<input type="hidden" name="topic_id" id="topic_id" value="<?php echo $topic->topic_id ?>"/>
				<input type="hidden" name="count" id="count" value="<?php echo $count ?>"/>
				<input type="hidden" id="total_questions_count" name="total_questions_count" value="<?php echo $no_of_questions ?>"/>
				
				<h4>Question <span id="current-question"><?php echo $count;?></span> of <?php echo $no_of_questions?></h4>

				<div class="body">

					 <?php  foreach ($questions as $m => $question) { ?>
					 <?php  $userchoice = 0 ;foreach($userchosenanswers as $l => $userchosenanswer) {
					 	if($userchosenanswer->question_id == $question->question_id){
					 		$userchoice = $userchosenanswer->chosen_answer_id;
					 	}	
					 }?>
					 <div id="questionContainer_<?php echo $count;?>" class="question-container">
						<input type="hidden" id="question_id_<?php echo $count ?>" name="question_id_<?php echo $count ?>" value="<?php echo $question->question_id?>"/>
						<input type="hidden" name="question_no" value="<?php echo $count ?>"/>

						<h5 class="question"><?= $count . ".) " . str_ireplace('<p>','',$question->question_text); ?></h5>
						<?php if($question->image_path != null): ?><img src='<?= base_url() . $question->image_path; ?>' class='question_image' /><?php endif; ?>
						<?php $choices = $question->getAnswers(); 
							foreach ($choices as $k =>$choice){?>
							<div class="radio">
								<label>
									<input type='radio' class='choice' id='choice_<?php echo $count ?>' name='choice_<?php echo $count ?>' value='<?php echo $choice->question_answer_id ?>' <?php if($userchoice == $choice->question_answer_id){ ?> checked <?php }?> />
							    	<p><?php if($k+1 ==1){echo 'A';}else if($k+1 ==2){echo 'B';}else if($k+1 ==3){echo 'C';}else if($k+1 ==4){echo 'D';}else if($k+1 ==5){echo 'E';}?>) <?php echo str_ireplace('<p>','',$choice->answer_text); ?></p>
								</label>
							</div>
						<?php }?>
					</div>

					<?php 
						$count++;
					}?>


					<div class="question-actions">
						<input class="btn btn-secondary btn-sm" type='button' style="display:none" id="back" name='back' value='back' />&nbsp;
						<input class="btn btn-secondary btn-sm" type='button' name='next' id="next" value='next' />
						<input class="btn btn-secondary btn-sm" type='submit' style="display:none" id="submit" name='submit' value='Submit' />
					</div>
					
				</div>

			</section>

		</form>
	</div>
</div>


<script src="<?= base_url(); ?>js/jquery.js"></script>

<script type="text/javascript">

	$(document).ready(function(){
		var count = $("#count").val();
		if(count >= $("#total_questions_count").val()) {
			if(count === 0) {
				$("#page").html("An error has occurred, this exam has no questions.");
			} else {
				$("#page").html("This exam has already been completed.");
			}
		}

		// prepare the metrics for question timing
		var activeQuestion = count;
		var activeQuestionStartTime = new Date();

		if($("#count").val() == 1){
			$("#questionContainer_"+$("#count").val()).show();
		}

		$("#next").click(function(){ 
			$("#page .error").remove();
			var count = $("#count").val();
			var no_of_questions = $("#total_questions_count").val();
			$("#questionContainer_"+count).hide();
			$("#questionContainer_"+(Number(count)+1)).show();
			saveUserSelection(count);
			count = Number(count)+1;
			$("#count").val(count);
			$('#current-question').html(count);
			if(count > 1 && count <= no_of_questions){
				$("#back").show();
			}
			if(count == no_of_questions){
				$("#next").hide();
				$("#submit").show();
			}

			// stop the timer on the currect question and activate it for the next one.
			var old_question_id = $("#question_id_" + activeQuestion).val();
			var endTime = new Date();
			Tracker.trackEvent("question_time", "Question", old_question_id, endTime - activeQuestionStartTime);

			// Activate the next question
			activeQuestion = count;
			activeQuestionStartTime = new Date();
		});

		$("#back").click(function(){ 
			$("#page .error").remove();
			var count = $("#count").val();
			var no_of_questions = $("#total_questions_count").val();
			$("#questionContainer_"+Number(count)).hide();
			$("#questionContainer_"+(Number(count)-1)).show();
			saveUserSelection(count);
			count = Number(count)-1;
			$("#count").val(count);
			$('#current-question').html(count);
			if(Number(count) == 1 ){
				$("#back").hide();
			} else {
				$("#back").show();
			}
			if(Number(count) != no_of_questions){
				$("#next").show();
			} else {
				$("#next").show();
			}

			var old_question_id = $("#question_id_" + activeQuestion).val();
			var endTime = new Date();
			Tracker.trackEvent("question_time", "Question", old_question_id, endTime - activeQuestionStartTime);

			// Activate the next question
			activeQuestion = count;
			activeQuestionStartTime = new Date();
		});

		$("#submit").click(function(){ 
			var count = $("#count").val();
			saveUserSelection(count);
			var qtncount = parseInt($("#total_questions_count").val());
			saveUserSelection(qtncount);
			var sel_choices = $("input.choice:checked").map(function () {return this.value;}).get();
			console.log(sel_choices);
			if(sel_choices.length < qtncount){
				$("#page .error").remove();
				$("#page").prepend('<div class="col-md-12"><div class="alert alert-danger">You have not completed all questions.</div></div>');
				return false;
			}
		});

		// Make sure we track the question time when they leave the page
		$(window).bind('beforeunload', function() { 
			var old_question_id = $("#question_id_" + activeQuestion).val();
			var endTime = new Date();
			Tracker.trackEvent("question_time", "Question", old_question_id, endTime - activeQuestionStartTime, false);
		});
	});

function saveUserSelection( qtncount){
	var sel_choices = $("input[name=choice_"+qtncount+"]:checked").map(function () {return this.value;}).get().join(",");
	if(sel_choices.length > 0){
		$.ajax({
			url: "<?= base_url(); ?>exam/saveUserExamQuestion",
			type: "post",
			data: { 
				user_id : $("#user_id").val(), 
				exam_id : $("#exam_id").val(),
				question_id : $("#question_id_"+qtncount).val(), 
				user_exam_attempt_id : $("#user_exam_attempt_id").val(),
				choice : sel_choices
			},
			success: function(){
						//alert("success");
						//$("#result").html('Submitted successfully');
					},
					error:function(){
						//alert("failure");
						//$("#result").html('There is error while submit');
					}
				});
	}

}

</script>



