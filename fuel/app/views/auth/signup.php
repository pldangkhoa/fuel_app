<div class="row myapp-top">
	<div class="col-xs-6 title"><?php echo $app_name; ?></div>
	<div class="col-xs-6 text-right">
		<a href="/auth/login"><button type="button" class="btn btn-default">Go login form</button></a>
	</div>
</div>
<div class="row">
	<div class="col-sm-offset-2 col-xs-8 box">
		<div class="row fb-box">
			<div class="col-sm-offset-1 col-xs-10"><button class="btn btn-primary col-xs-12">Facebook on Signup</button></div>
		</div>
		<div class="row login-box">
			<div class="col-xs-12">
				<form class="form-horizontal" role="form" action="<?php echo Uri::create('auth/signup', array(), array()); ?>" method="post">
					<div class="form-group">
						<label for="inputUsername" class="col-xs-4 control-label">username: </label>
						<div class="col-xs-7">
							<input type="text" name="username" class="form-control" id="inputUsername" placeholder="username">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail" class="col-xs-4 control-label">Email: </label>
						<div class="col-xs-7">
							<input type="email" name="email" class="form-control" id="inputEmail" placeholder="your email">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword" class="col-xs-4 control-label">password: </label>
						<div class="col-xs-7">
							<input type="password" name="password" class="form-control" id="inputPassword" placeholder="password">
						</div>
					</div>
					<div class="form-group">
						<label for="inputConfirmPassword" class="col-xs-4 control-label">confirm password: </label>
						<div class="col-xs-7">
							<input type="password" name="confirm_password" class="form-control" id="inputConfirmPassword" placeholder="confirm password">
						</div>
					</div>
					<div class="form-group">
						<label for="inputGender" class="col-xs-4 control-label">gender: </label>
						<div class="col-xs-8">
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
						<div class="col-sm-offset-4 col-xs-7">
							<button type="submit" class="btn btn-default col-xs-12">Signup!!</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>