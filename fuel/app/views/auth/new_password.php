<div class="row myapp-top">
	<div class="col-xs-6 title">new password</div>
	<div class="col-xs-6 text-right">
		<a href="/auth/login"><button type="button" class="btn btn-default">Go login form</button></a>
	</div>
</div>
<div class="row">
	<div class="col-sm-offset-2 col-xs-8">
		<div class="row">
			<div class="col-xs-12">
				<form class="form-horizontal" role="form" action="<?php echo Uri::create('auth/new_password', array(), array()); ?>" method="post">
					<div class="form-group">
						<label for="inputPassword" class="col-xs-4 control-label">password: </label>
						<div class="col-xs-7">
							<input type="password" name="password" class="form-control" id="inputPassword" placeholder="new password">
						</div>
					</div>
					<div class="form-group">
						<label for="inputConfirmPassword" class="col-xs-4 control-label">confirm password: </label>
						<div class="col-xs-7">
							<input type="password" name="confirm_password" class="form-control" id="inputConfirmPassword" placeholder="confirm password">
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
	</div>	
</div>