<h3 class="page-header">Award Points</h3>
	 <?php if($this->session->flashdata("success_msg")){?>
          <div class="alert alert-success"><?php echo $this->session->flashdata("success_msg"); ?></div>
		<?php }?>

<section class="block track-head">
	<h4>Award Points - School Level</h4>
	<div class="body">
		<div class="row">
			<div class="col-md-12">
				<div class="container">
				<?php echo form_open(null, array("class"=>"form-signin")); ?>
					<div class="row">
						<div class="col-md-3">
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
						<div class="col-md-3">
							<div
								class="form-group <?php if( form_error('section') ) { echo 'has-error'; } ?>">
								<select class="form-control" name="section">
									<option value="0">Section</option>
    						 <?php foreach ($sections as $section) {?>
    						  <option value="<?php echo $section->school_section_id;?>" <?= set_select("section", $section->school_section_id); ?>><?php echo $section->section;?></option>
    						  <?php }?>
    						</select> <span class="help-block"><?php echo form_error('section'); ?>
								</span>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group <?php if( form_error('awardtype') ) { echo 'has-error'; } ?>">
								<select class="form-control" name="awardtype">
									<option value="0">Please select award type</option>
    						  <option value="weeklywinner" >Weekly Winner</option>
    						  <option value="captainaward" >Captain Award</option>
    						</select> <span class="help-block"><?php echo form_error('awardtype'); ?>
								</span>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<div class="input-group">
                    		  <input type="text" class="form-control" name="awarddate" id="awarddate" placeholder="Award Date(yyyy-mm-dd)" autofocus="">
                    			  <span class="input-group-addon"></span>
                    			</div>
							<span class="help-block"></span>
							</div>
						</div>
						<div class="col-md-3">
							<button class="btn btn-secondary btn-block" type="submit"
						name="award_school" value="award_school">Award</button>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="block track-head">
	<h4>Award Points - User</h4>
	<div class="body">
		<div class="row">
			<div class="col-md-12">
				<div class="container">
				<?php echo form_open(null, array("class"=>"form-signin")); ?>
				<div class="row">
				<?php foreach ($schools as $school) {?>
				<h4><?php echo $school->name?></h4> </br>
					<?php foreach($school->getUsers() as $a): ?>
					<input type='checkbox' name='user_ids[]' value='<?php echo $a->user_id?>'  /> <?php echo $a->getName()?>(<?php echo $a->getSection()?>)</br></br>
					<?php endforeach ?>
				<?php } ?>
				</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group <?php if( form_error('awardtype1') ) { echo 'has-error'; } ?>">
								<select class="form-control" name="awardtype1">
									<option value="0">Please select award type</option>
    						  <option value="weeklywinner" >Weekly Winner</option>
    						  <option value="captainaward" >Captain Award</option>
    						</select> <span class="help-block"><?php echo form_error('awardtype1'); ?>
								<?php if( form_error('user_ids') ) { echo 'Please select atleast one user.'; } ?></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							<div class="input-group">
                    		  <input type="text" class="form-control" name="awarddate" id="awarddate" placeholder="Award Date(yyyy-mm-dd)" autofocus="">
                    			  <span class="input-group-addon"></span>
                    			</div>
							<span class="help-block"></span>
							</div>
						</div>
						<div class="col-md-4">
							<button class="btn btn-secondary btn-block" type="submit"
						name="award_user" value="award_user">Award</button>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>









