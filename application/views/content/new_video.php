
<?= form_open_multipart() ?>

<?php if($this->content->content_id): ?>
	<input type='hidden' name='edit_content_id' value='<?= $this->content->content_id; ?>' />
<?php endif ?>

<input type='hidden' name='content_type' value='video' />

<div class="row questsection">
	<div class="col-md-6 ">
		<p class="headerfont">Content Title</p>
		<hr class="style-three"/>
		<input type='text' name='content_name' value='<?= $this->content->name; ?>' />
	</div>
	<div class="col-md-6">
		<p class="headerfont">Content Description</p>
		<hr class="style-three"/>
		<textarea name="content_description" data-preview-artifact-id="content_editor_preview" style="width:100%;"><?= $this->content->description; ?></textarea>
	</div>
</div>

<!-- form inputs here... -->


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
		<?php foreach($this->content->getTopics() as $topic): ?>
			<span class='topic-wrap'>
				<input type='hidden' name='topics[]' value='<?= $topic->topic_id ?>' />
				<span class='label label-default'><?= $topic->name; ?> <a class="remove-tag">&times;</a></span>
			</span>
		<?php endforeach; ?>
		<a href='#' class='btn btn-default add-topic'>+</a>
	</div>
</div>

<div class="row questsection">
	<div class="col-md-12">
		<span class="headerfont">Files</span>
		<table style='border-collapse:collapse; border:1px solid black;'>
			<tr><td>MP4</td><td><input type='file' name='content_mp4' /></td><td>View</td><td>Delete</td></tr>
			<tr><td>WEBM</td><td><input type='file' name='content_webm' /></td><td>View</td><td>Delete</td></tr>
		</table>
	</div>
</div>

<div class="row questsection">
	<div class="col-md-6 ">
		<p class="headerfont">Is Hosted Externally?</p>
		<hr class="style-three"/>
		<input type='checkbox' name='is_hosted_external' id='is_hosted_external' <?php if($this->content->is_hosted_external){ ?> checked <?php } ?> />
	</div>
	<div class="col-md-6">
		<p class="headerfont">External URL</p>
		<hr class="style-three"/>
		<textarea name="embed_html" data-preview-artifact-id="content_editor_preview" style="width:100%;"><?= $this->content->embed_html; ?></textarea>
	</div>
</div>


<hr class="style-three"/>

<?php if($this->content->content_id): ?>
	<input class='btn btn-orange' type='submit' name='edit_content' value='Update' />
<?php else: ?>
	<input class='btn btn-orange' type='submit' name='new_content' value='Create' />
<?php endif ?>

<?= "</form>" ?>

<script type="text/javascript">

$( document ).ready( function() {

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