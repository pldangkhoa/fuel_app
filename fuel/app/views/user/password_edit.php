<?php if (isset($success) && $success === true) : ?>
	<p>Your password has been updated successfully !!!</p>
<?php else : ?>
<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" role="form" action="<?php echo Uri::create('user/password_edit', array(), array()); ?>" method="post">
			<div class="form-group">
				<label for="inputOldPassword" class="col-xs-4 control-label">old password: </label>
				<div class="col-xs-7">
					<input type="password" name="old_password" class="form-control" id="inputOldPassword" placeholder="old password">
				</div>
			</div>
			<hr>
			<div class="form-group">
				<label for="inputNewPassword" class="col-xs-4 control-label">new password: </label>
				<div class="col-xs-7">
					<input type="password" name="new_password" class="form-control" id="inputNewPassword" placeholder="password">
				</div>
			</div>
			<div class="form-group">
				<label for="inputConfirmNewPassword" class="col-xs-4 control-label">confirm password: </label>
				<div class="col-xs-7">
					<input type="password" name="confirm_new_password" class="form-control" id="inputConfirmNewPassword" placeholder="confirm new password">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-xs-7">
					<button type="submit" class="btn btn-primary col-xs-12">save</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php endif; ?>