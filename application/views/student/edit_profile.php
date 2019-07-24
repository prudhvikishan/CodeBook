<h3 class="page-header">Settings</h3>

<div class="row">
	<div class="col-md-12">
		<?php if($this->session->flashdata("success_msg")){?>
        	<div class="alert alert-success"><?php echo $this->session->flashdata("success_msg"); ?></div>
		<?php }?>
	</div>
</div>

<div class="row">

	<div class="col-md-12">

		<section class="block">
			<h4>User Settings</h4>
			<div class="body">
<?= form_open_multipart() ?>
					<div class="form-group">
						<label for="email">Email address / Username</label>
						<p><?php echo $this->user->email; ?> </p>
					</div>
					<div class="form-group <?php if( form_error('firstname') ) { echo 'has-error'; } ?>">
						<label for="firstname">First Name</label>
						<input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $this->user->firstname; ?>">
						<span class="help-block"><?php echo form_error('firstname'); ?></span>
					</div>
					<div class="form-group <?php if( form_error('lastname') ) { echo 'has-error'; } ?>">
						<label for="lastname">Last Name</label>
						<input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $this->user->lastname; ?>" >
						<span class="help-block"><?php echo form_error('lasttname'); ?></span>
					</div>
					<div class="form-group">
						<label for="imageUpload">Profile Picture</label>
						<input type="file" id="imageUpload" name="imageUpload">
						<p class="help-block">Must be 200px by 200px.</p>
					</div>
					<div class="form-group <?php if( form_error('password') ) { echo 'has-error'; } ?>">
						<label for="password">New Password</label>
						<input type="password" class="form-control" id="password" name="password" >
						<span class="help-block"><?php echo form_error('password'); ?></span>
					</div>
					<button type="submit" name="save_changes" value="save_changes" class="btn btn-secondary">Save Changes</button>
				</form>
			</div>
		</section>

	</div>

</div>