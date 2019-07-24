

<?= form_open() ?>

	<input type='hidden' name='course_id' value='<?= $this->course->course_id; ?>' />
	<input type='hidden' name='topic_id' value='<?= $this->topic->topic_id; ?>' />


<h2>Add Topic</h2>
<label>Topic Name :<input type="text" size="50" name="topic_name" id="topic_name" /> </label>
<br/>
<label>Description :
	<textarea rows="4" cols="50" name="topic_description" id="topic_description">
</textarea>
</label>
<br/>
<input type='submit' name='save' value='Save Topic' />

<?= "</form>" ?>