<div class="row myapp-top">
	<div class="col-xs-6 title"><?php echo $app_name; ?></div>
	<div class="col-xs-6 text-right">
		<a href="/auth/signup"><button type="button" class="btn btn-default">Sign up</button></a>
	</div>
</div>
<div class="row">
	<fieldset class="col-sm-offset-2 col-xs-8 box">
		<legend>login</legend>
		<div class="row fb-box">
			<div class="col-sm-offset-1 col-xs-10"><button class="btn btn-primary col-xs-12">Facebook Login</button></div>
		</div>
		<div class="row login-box">
			<div class="col-xs-12">
				<form class="form-horizontal" role="form" action="<?php echo Uri::create('auth/login', array(), array()); ?>" method="post">
				<?php if (!empty($error['login_fail'])) : ?>
					<div class="form-group">
						<span class="error col-sm-offset-4"><?php echo $error['login_fail']; ?></span>
					</div>
				<?php endif; ?>
					<div class="form-group">
						<label for="inputEmail" class="col-xs-4 control-label">Email: </label>
						<div class="col-xs-7">
							<input type="email" name="email" class="form-control" id="inputEmail" placeholder="your email">
							<span class="error"><?php echo !empty($error['email']) ? $error['email'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword" class="col-xs-4 control-label">password: </label>
						<div class="col-xs-7">
							<input type="password" name="password" class="form-control" id="inputPassword" placeholder="password">
							<span class="error"><?php echo !empty($error['password']) ? $error['password'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-xs-8">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember" value="1"> remember me
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-xs-10">
							<button type="submit" class="btn btn-default col-xs-12">login</button>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-12 text-center">
							<a href="/auth/forget_password" class="text-center">forget password?</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</fieldset>	
</div>