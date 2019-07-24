<h3 class="page-header">Award Points</h3>

<?php if($this->session->flashdata("success_msg")){?>
<div class="alert alert-success">

<?php echo $this->session->flashdata("success_msg"); ?></div>

<?php }?>

<section class="block track-head">
	<h4>Send Email - School Level</h4>
	<div class="body">
		<div class="row">
			<div class="col-md-12">
				<div class="container">
				<?php echo form_open(null, array("class"=>"form-signin")); ?>
					<div class="row">
						<div class="col-md-4">
							<div
								class="form-group <?php if( form_error('school') ) { echo 'has-error'; } ?>">
								<select class="form-control" name="school">
									<option value="0">Please select your school</option>
    						 <?php foreach ($schools as $school) {?>
    						  <option value="<?php echo $school->school_id;?>" <?= set_select("school", $school->school_id); ?>><?php echo $school->name;?></option>
    						  <?php }?>
    						</select> <span class="help-block"><?php echo form_error('school'); ?>
								</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<input type="text" name="subject" id="subject"
								placeholder="Email subject" />
						</div>
					</div>
					</br> </br>
					<div class="row">
						<div class="row questsection">
							<div class="col-md-12">
								<div class='editor'>
									<textarea class="choice_editor" id="email" name="email"
										data-preview-artifact-id="question_choice_a_preview"></textarea>
								</div>
							</div>

						</div>
					</div>
					</br> </br>
					<div class="col-md-3">
						<button class="btn btn-secondary btn-block" type="submit"
							name="send_school" value="send_school">Send Email</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	</div>
</section>

<section class="block track-head">
	<h4>Send Email - User</h4>
	<div class="body">
		<div class="row">
			<div class="col-md-12">
				<div class="container">
				<?php echo form_open(null, array("class"=>"form-signin")); ?>
					<div class="row">
					<?php foreach ($schools as $school) {?>
						<h4>
						<?php echo $school->name?></h4>
						</br>
					<?php foreach($school->getUsers() as $a): ?>
					<input type='checkbox' name='user_ids[]' value='<?php echo $a->email?>'  /> <?php echo $a->getName()?></br></br>
					<?php endforeach ?>
				<?php } ?>
				</div>
					<div class="row">
						<div class="col-md-4">
							<input type="text" name="subject" id="subject"
								placeholder="Email subject" />
						</div>
					</div>
					</br> </br>
					<div class="row">
						<div class="row questsection">
							<div class="col-md-12">
								<div class='editor'>
									<textarea class="choice_editor" name="email1"
										data-preview-artifact-id="question_choice_a_preview"></textarea>
								</div>
							</div>
						</div>
					</div>
					</br> </br>
					<div class="col-md-4">
						<button class="btn btn-secondary btn-block" type="submit"
							name="send_user" value="send_user">Send Email</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	</div>
</section>









