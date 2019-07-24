

<?= form_open() ?>


<input type='hidden' name='course_id' value='<?= $this->course->course_id; ?>' />


<h2>Edit Course</h2>
<label>Course Name :<input type="text" size="50" name="course_name" id="course_name"  value="<?= $this->course->name?>"/> </label>
<br/>
<label>Description :
	<textarea rows="4" cols="50" name="course_description" id="course_description"><?= $this->course->description ?>
</textarea>
</label>
<br/>
<input type='submit' name='edit' value='Save Course' />
<input type='submit' name='delete' value='Delete Course' />

<?= "</form>" ?>


