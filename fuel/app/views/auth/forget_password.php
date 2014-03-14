<div class="row myapp-top">
	<div class="col-xs-6 title">forget password</div>
	<div class="col-xs-6 text-right">
		<a href="/auth/login"><button type="button" class="btn btn-default">Go login form</button></a>
	</div>
</div>
<div class="row">
	<div class="col-sm-offset-2 col-xs-8">
		<?php if (!empty($error['success'])) : ?>
			<p class="error"><?php echo $error['success']; ?></p>
		<?php else: ?>
		<div class="row">
			<div class="col-xs-12">
				<form class="form-horizontal" role="form" action="<?php echo Uri::create('auth/forget_password', array(), array()); ?>" method="post">
					<div class="form-group">
						<label for="inputEmail" class="col-xs-4 control-label">Email: </label>
						<div class="col-xs-7">
							<input type="email" name="email" class="form-control" id="inputEmail" placeholder="your email">
							<span class="error"><?php echo !empty($error['email']) ? $error['email'] : ''; ?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-xs-7">
							<button type="submit" class="btn btn-default col-xs-12">Send Email</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>