<div class="row">
	<div class="col-xs-6">
		<p>Fuel Auth App</p>
	</div>
	<div class="col-xs-6">
		<p class="text-right"><a href="/auth/login">Go login form</a></p>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-sm-offset-3"><button class="btn btn-default col-xs-7">Facebook on Signup</button></div>
		</div>
	</div>
	<div class="col-xs-12">
		<form class="form-horizontal" role="form" action="<?php echo Uri::create('auth/signup', array(), array()); ?>" method="post">
			<div class="form-group">
				<label for="inputUsername" class="col-xs-4 control-label">username: </label>
				<div class="col-xs-4">
					<input type="text" name="username" class="form-control" id="inputUsername" placeholder="username">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail" class="col-xs-4 control-label">Email: </label>
				<div class="col-xs-4">
					<input type="email" name="email" class="form-control" id="inputEmail" placeholder="your email">
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-xs-4 control-label">password: </label>
				<div class="col-xs-4">
					<input type="password" name="password" class="form-control" id="inputPassword" placeholder="password">
				</div>
			</div>
			<div class="form-group">
				<label for="inputConfirmPassword" class="col-xs-4 control-label">confirm password: </label>
				<div class="col-xs-4">
					<input type="password" name="confirm_password" class="form-control" id="inputConfirmPassword" placeholder="confirm password">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-xs-4">
					<div class="checkbox-inline">
						<label>
							<input type="radio" name="gender" id="gender1" value="1" checked> male
						</label>
					</div>
					<div class="checkbox-inline">
						<label>
							<input type="radio" name="gender" id="gender2" value="2"> female
						</label>
					</div>
					<div class="checkbox-inline">
						<label>
							<input type="radio" name="gender" id="gender3" value="0"> none
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3">
					<button type="submit" class="btn btn-default col-xs-7">Signup!!</button>
				</div>
			</div>
		</form>
	</div>
</div>