<?php if (!empty($success)) : ?>
	<p>Your email has been updated successfully !!!</p>
<?php else : ?>
<div class="row">
	<div class="col-xs-12">
		<form class="form-horizontal" role="form" action="<?php echo Uri::create('user/email_edit', array(), array()); ?>" method="post">
			<div class="form-group">
				<label for="inputNewEmail" class="col-xs-4 control-label">new email: </label>
				<div class="col-xs-7">
					<input type="email" name="new_email" class="form-control" id="inputNewEmail" placeholder="new email">
					<span class="error"><?php echo !empty($error['new_email']) ? $error['new_email'] : ''; ?></span>
				</div>
			</div>
			<div class="form-group">
				<label for="inputConfirmNewEmail" class="col-xs-4 control-label">confirm new email: </label>
				<div class="col-xs-7">
					<input type="email" name="confirm_new_email" class="form-control" id="inputConfirmNewEmail" placeholder="confirm new email">
					<span class="error"><?php echo !empty($error['confirm_new_email']) ? $error['confirm_new_email'] : ''; ?></span>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-xs-7">
					<button type="submit" class="btn btn-primary col-xs-12">send</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php endif; ?>