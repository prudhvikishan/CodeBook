
<?= form_open_multipart() ?>

<?php if($this->question->question_id): ?>
	<input type='hidden' name='edit_question_id' value='<?= $this->question->question_id; ?>' />
<?php endif ?>
<?php if($this->question->getAnswers() != null): ?>
	<?php foreach($this->question->getAnswers() as $a): ?>
	<input type='hidden' name='edit_question_answer_ids[]' value='<?= $a->question_answer_id ?>' />
<?php endforeach ?>
<?php endif; ?>




<div class="row questsection">
	<div class="col-md-6">
		<p class="headerfont">Question</p>
		<hr class="style-three"/>
		<div class='editor'><textarea class="question_editor" name="new_question_text" data-preview-artifact-id="question_editor_preview"><?= $this->question->question_text; ?></textarea></div>
	</div>
	<div class="col-md-6 ">
		<p class="headerfont">Preview</p>
		<hr class="style-three"/>
		<div class='preview' id="question_editor_preview"></div>
	</div>
</div>


<div class="row questsection">
	<div class="col-md-6">
		<p class="headerfont">Image</p>
		<hr class="style-three"/>
		<div class='editor'><input type='file' name='question_image' /></div>
	</div>
	<div class="col-md-6 ">
		<p class="headerfont">Current Image</p>
		<hr class="style-three" />
		<div class='preview'>
			<?php if($this->question->image_path): ?>
				<img src='<?= base_url() . $this->question->image_path; ?>' />
				<input type='hidden' name='existing_image' value='<?= $this->question->image_path; ?>' />
				<a href='#' class="remove_image">Remove</a>
			<?php else: ?>
				None
			<?php endif; ?>
		</div>
	</div>
</div>


<br /><br />

<?php $choices = $this->question->getAnswers(); ?>
<div class="row questsection">
	<div class="col-md-6">
		<div class="headerfont">Choice A <span class="pull-right"><input type='checkbox' name='new_question_answer_correct[]' value='0' <?= $choices[0]->is_correct == 1 ? "checked=checked" : "" ?> /> Correct Choice</span></div>
		<hr class="style-three"/>
		<div class='editor'><textarea class="choice_editor" name="new_question_choices[]" data-preview-artifact-id="question_choice_a_preview" ><?= $choices[0]->answer_text ?></textarea></div>
	</div>
	<div class="col-md-6">
		<p class="headerfont">Preview</p>
		<hr class="style-three"/>
		<div class='preview' id="question_choice_a_preview"></div>
	</div>
</div>

<div class="row questsection">
	<div class="col-md-6">
		<div class="headerfont">Choice B <span class="pull-right"><input type='checkbox' name='new_question_answer_correct[]' value='1' <?= $choices[1]->is_correct == 1 ? "checked=checked" : "" ?> /> Correct Choice</span></div>
		<hr class="style-three"/>
		<div class='editor'><textarea class="choice_editor" name="new_question_choices[]" data-preview-artifact-id="question_choice_b_preview" ><?= $choices[1]->answer_text ?></textarea></div>
	</div>
	<div class="col-md-6">
		<p class="headerfont">Preview</p>
		<hr class="style-three"/>
		<div class='preview' id="question_choice_b_preview"></div>
	</div>
</div>
<div class="row questsection">
	<div class="col-md-6">
		<div class="headerfont">Choice C <span class="pull-right"><input type='checkbox' name='new_question_answer_correct[]' value='2' <?= $choices[2]->is_correct == 1 ? "checked=checked" : "" ?> /> Correct Choice</span></div>
		<hr class="style-three"/>
		<div class='editor'><textarea class="choice_editor" name="new_question_choices[]" data-preview-artifact-id="question_choice_c_preview" ><?= $choices[2]->answer_text ?></textarea></div>
	</div>
	<div class="col-md-6">
		<p class="headerfont">Preview</p>
		<hr class="style-three"/>
		<div class='preview' id="question_choice_c_preview"></div>
	</div>
</div>

<div class="row questsection">
	<div class="col-md-6">
		<div class="headerfont">Choice D <span class="pull-right"><input type='checkbox' name='new_question_answer_correct[]' value='3' <?= $choices[3]->is_correct == 1 ? "checked=checked" : "" ?> /> Correct Choice</span></div>
		<hr class="style-three"/>
		<div class='editor'><textarea class="choice_editor" name="new_question_choices[]" data-preview-artifact-id="question_choice_d_preview" ><?= $choices[3]->answer_text ?></textarea></div>
	</div>
	<div class="col-md-6">
		<p class="headerfont">Preview</p>
		<hr class="style-three"/>
		<div class='preview' id="question_choice_d_preview"></div>
	</div>
</div>

<div class="row questsection">
	<div class="col-md-6">
		<p class="headerfont">Solution</p>
		<hr class="style-three"/>
		<div class='editor'><textarea class="question_editor" name="new_question_explanation" data-preview-artifact-id="question_explanation_preview" ><?= $this->question->explanation ?></textarea></div>
	</div>
	<div class="col-md-6">
		<p class="headerfont">Preview</p>
		<hr class="style-three"/>
		<div class='preview' id="question_explanation_preview"></div>
	</div>
</div>

<div class="row questsection">
	<div class="col-md-2">
		<span class="headerfont">Type</span>
	</div>
	<div class="col-md-10">
		<input type="checkbox" name="question_types[]" value="practice" <?= $this->question->practice_question == 1 ? "checked=checked" : "" ?> /><span class="artifact">Practice</span>
		<input type="checkbox" name="question_types[]" value="exam" <?= $this->question->exam_question == 1 ? "checked=checked" : "" ?> /><span class="artifact">Exam</span>  
	</div>
</div>
<div class="row questsection">
	<div class="col-md-2">
		<span class="headerfont">Difficulty</span>
	</div>
	<div class="col-md-10">
		<input type="radio" name="question_difficulty" value="0" <?= $this->question->difficulty == 0 ? "checked=checked" : "" ?>/><span class="artifact">Easy</span>
		<input type="radio" name="question_difficulty" value="1" <?= $this->question->difficulty == 1 ? "checked=checked" : "" ?>/><span class="artifact">Medium</span> 
		<input type="radio" name="question_difficulty" value="2" <?= $this->question->difficulty == 2 ? "checked=checked" : "" ?>/><span class="artifact">Hard</span>
	</div>
</div>
<div class="row questsection">
	<div class="col-md-2">
		<span class="headerfont">Topics</span>
	</div>
	<div class="col-md-10 all-topics">
		<?php if($this->default_topic): ?>
			<span class='topic-wrap'>
				<input type='hidden' name='topics[]' value='<?= $this->default_topic->topic_id ?>' />
				<span class='label label-default'><?= $this->default_topic->name; ?> <a class="remove-tag">&times;</a></span>
			</span>
		<?php endif; ?>
		<?php foreach($this->question->getQuestionTopics() as $topic): ?>
			<span class='topic-wrap'>
				<input type='hidden' name='topics[]' value='<?= $topic->topic_id ?>' />
				<span class='label label-default'><?= $topic->name; ?> <a class="remove-tag">&times;</a></span>
			</span>
		<?php endforeach; ?>
		<a href='#' class='btn btn-default add-topic'>+</a>
	</div>
</div>

<hr class="style-three"/>

<?php if($this->question->question_id): ?>
	<input class='btn btn-orange' type='submit' name='edit_question' value='Update' />
	<?php if($this->isadmin) {?>
			<input class='btn btn-orange' type='submit' name='delete_question' value='Delete' />
		<?php }?>
<?php else: ?>
	<input class='btn btn-orange' type='submit' name='new_question' value='Create' />
<?php endif ?>

<?= "</form>" ?>

<script type="text/javascript">

$( document ).ready( function() {
	Formula.createBigEditor(".question_editor");
	Formula.createSmallEditor(".choice_editor");

	$("a.add-topic").on("click", function(){
		$('#add-topic-modal').modal({});
	});

	$("#add-topic-modal .btn.btn-primary").on("click", function(){
		// get the id of the selected tag
		var topic_id = $("#add-topic-modal select[name=topic_select] option:selected").val();
		var topic = $("#add-topic-modal select[name=topic_select] option:selected").text();
		
		// ensure this id hasnt already been added
		if($(".topic-wrap input[type=hidden]").filter(function() { return $(this).val() == topic_id; }).length > 0)
		{
			$("#add-topic-modal span.error").html("That tag is already added.<br />");
			return ;
		}

		// append the elements to the dom
		$(".all-topics").prepend("<span class='topic-wrap'>" + 
				"<input type='hidden' name='topics[]' value='"+topic_id+"' />" + 
				"<span class='label label-default'>"+topic+" <a class='remove-tag'>&times;</a></span>" + 
			"</span>"
		);

		$("a.remove-tag").off("click");
		$("a.remove-tag").on("click", function(){
			$(this).closest(".topic-wrap").fadeOut(200, function(){ $(this).remove(); });
		});

		// close the modal
		$('#add-topic-modal').modal('hide');
	});

	$("a.remove-tag").on("click", function(){
		$(this).closest(".topic-wrap").fadeOut(200, function(){ $(this).remove(); });
	});

	$("a.remove_image").on("click", function(){
		$(this).parent().html("");
		return false;
	});
});

</script>

<!-- ADD TOPIC MODAL -->
<div class="modal fade" id="add-topic-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Topic</h4>
      </div>
      <div class="modal-body">
      	<span class='error'></span>
        Choose Topic: 
        <select name='topic_select'>
        	<?php  foreach($this->topics as $topic):  ?>
        		<option value='<?= $topic->topic_id ?>'><?= $topic->name; ?></option>
        	<?php endforeach; ?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Add Topic</button>
      </div>
    </div>
  </div>
</div>