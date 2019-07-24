<?= form_open(); ?>
	<?= $this->announcement->announcement_id != null ? "<input type='hidden' name='edit_announcement_id' value='".$this->announcement->announcement_id."' />" : ""; ?>
	<h1><?= $this->announcement->announcement_id == null ? "New" : "Edit"; ?> Announcement</h1>
	<div class='row'>
		<div class='col-md-6'>
			<label for="title">Title:</label>
			<input type='text' name='title' id="title" value='<?= $this->announcement->title; ?>' size="75" />
		</div>
	</div>

	<div class='row'>
		<div class='col-md-6'>
			<label for="content">Content:</label>
			<textarea name='content' id="content" rows="10" cols="75"><?= $this->announcement->content; ?></textarea>
		</div>
	</div>
	<Hr />
	<div class='row'>
		<div class='col-md-6'>
			<input type='submit' class='btn btn-primary' name='submit_announcement' value='<?= $this->announcement->announcement_id == null ? "Create" : "Update"; ?>' />
		</div>
	</div>

<?= "</form>"; ?>