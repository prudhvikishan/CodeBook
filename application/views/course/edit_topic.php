

<?= form_open() ?>


<input type='hidden' name='topic_id' value='<?= $this->topic->topic_id; ?>' />


<h2>Edit Topic</h2>
<label>Topic Name :<input type="text" size="50" name="topic_name" id="topic_name"  value="<?= $this->topic->name?>"/> </label>
<br/>
<label>Description :
	<textarea rows="4" cols="50" name="topic_description" id="topic_description"><?= $this->topic->description ?>
</textarea>
</label>
<br/>
<input type='submit' name='edit' value='Save Topic' />
<input type='submit' name='delete' value='Delete Topic' />

<?= "</form>" ?>


