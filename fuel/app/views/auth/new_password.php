<div class="row myapp-top">
	<div class="col-xs-6 title">new password</div>
	<div class="col-xs-6 text-right">
		<a href="/auth/login"><button type="button" class="btn btn-default">Go login form</button></a>
	</div>
</div>
<div class="row">
	<div class="col-sm-offset-2 col-xs-8">
		<?php if (empty($error['auth_code'])) : ?>
		<div class="row">
			<div class="col-xs-12">
				<form class="form-horizontal" role="form" action="<?php echo Uri::create('auth/new_password/'.$auth_code, array(), array()); ?>" method="post">
					<div class="form-group">
						<label for="inputNewPassword" class="col-xs-4 control-label">password: </label>
						<div class="col-xs-7">
							<input type="password" name="new_password" class="form-control" id="inputNewPassword" placeholder="new password">
							<span class="error"><?php echo !empty($error['new_password']) ? $error['new_password'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputConfirmNewPassword" class="col-xs-4 control-label">confirm password: </label>
						<div class="col-xs-7">
							<input type="password" name="confirm_new_password" class="form-control" id="inputConfirmNewPassword" placeholder="confirm new password">
							<span class="error"><?php echo !empty($error['confirm_new_password']) ? $error['confirm_new_password'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-xs-7">
							<button type="submit" class="btn btn-default col-xs-12">Send</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php else : ?>
		<p class="error"><?php echo $error['auth_code']; ?></p>
		<?php endif; ?>
	</div>	
</div>