
<p><label>Do you really want to leave?</label></p>
<div class="col-xs-12">
	<form class="form-horizontal" role="form" action="<?php echo Uri::create('user/signout', array(), array()); ?>" method="post">
		<div class="form-group">
			<div class="col-sm-offset-1 col-xs-10">
				<input type="hidden" name="signout" value="1">
				<button type="submit" class="btn btn-default col-xs-2">Yes</button>
				<a href="/user/mypage"><button type="button" class="btn btn-default col-sm-offset-1 col-xs-2">No</button></a>
			</div>
		</div>
	</form>
	
</div>