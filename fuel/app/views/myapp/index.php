<div class="row myapp-top">
	<div class="col-xs-6 title"><?php echo $app_name; ?></div>
	<div class="col-xs-6 text-right">
		<?php if (!empty($user_info['icon'])) : ?>
			<img alt="icon" class="icon-small" src="<?php echo _ICON_PATH_.$user_info['icon']; ?>">
		<?php endif; ?>
		<span><?php echo $user_info['username']; ?></span>
		<a href="/user/mypage"><button type="button" class="btn btn-default">mypage</button></a>
		<button type="button" class="btn btn-default" id="logout-confirm">logout</button>
	</div>
</div>
<div id="confirm-box" style="display: none;"><p class="message">Logout?</p></div>
<div class="row add-comment">
	<form id="add-comment-form" class="form-horizontal" role="form" action="<?php echo Uri::create('myapp/addComment', array(), array()); ?>" method="post">
		<div class="form-group">
			<label for="inputComment" class="control-label col-xs-4">Add Comment: </label>
			<div class="col-xs-5">
				<input type="text" name="comment" class="form-control" id="inputComment" placeholder="new comment">
			</div>
			<button type="submit" class="btn btn-primary">send</button>
		</div>
	</form>
</div>
<div id="comments">
	<?php if (!empty($comments)) : ?>
		<?php foreach ($comments as $comment) : ?>
		<div class="row comment">
			<div class="col-xs-2 col-sm-offset-2 icon-medium">
				<?php if (!empty($comment['owner']['icon']) && !empty($comment['owner']['view_icon'])) : ?>
					<img alt="icon" class="img-circle" src="<?php echo _ICON_PATH_.$comment['owner']['icon']; ?>">
				<?php endif; ?>
				<span><?php echo $comment['owner']['username']; ?></span>
			</div>
			<div class="col-xs-7 comment-box">
				<span><?php echo $comment['body']; ?></span>
				<span class="time"><?php echo $comment['created_at']; ?></span>
			</div>
		</div>
		<?php endforeach; ?>
		<div id="read-more" class="row">
			<form id="load-comment-form" class="form-horizontal" role="form" action="<?php echo Uri::create('myapp/loadComment', array(), array()); ?>" method="post">
				<div class="form-group">
					<input type="hidden" name="offset" value="<?php echo $offset; ?>">
					<input type="hidden" name="total_record" value="<?php echo $num; ?>">
					<button type="submit" class="col-md-offset-6 col-xs-2 btn btn-default">Read More</button>
				</div>
			</form>
			<div class="row record">
				<div class="col-md-offset-5 col-xs-4"><?php echo $num.' record / '.$total.' record'; ?></div>
			</div>
			<script type="text/javascript">
				$( "#load-comment-form" ).submit(function( event ) {
					event.preventDefault();
					var $form = $( this ),
						offset = $form.find( "input[name='offset']" ).val(),
						total_record = $form.find( "input[name='total_record']" ).val(),
						url = $form.attr( "action" );
					var posting = $.post( url, { offset: offset,  total_record: total_record } );
					
					posting.done(function( data ) {
						$( "#read-more" ).remove();
						$( ".record" ).remove();
						$( "#comments" ).append( data );
					});
				});
			</script>
		</div>
	<?php endif; ?>
</div>

<script type="text/javascript">
$( "#add-comment-form" ).submit(function( event ) {
	event.preventDefault();
	var $form = $( this ),
		comment = $form.find( "input[name='comment']" ).val(),
		url = $form.attr( "action" );
	var posting = $.post( url, { comment: comment } );

	posting.done(function( data ) {
		$( "#inputComment" ).val("");
		$( "#comments" ).empty().html( data );
	});
});

$( "#logout-confirm" ).click(function() {
	$( "#confirm-box" ).dialog({
		resizable: false,
		height: 200,
		modal: true,
		buttons: {
			"Yes": function() {
				$( this ).dialog( "close" );
				location = "/auth/logout";
			},
			"Cancel": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
</script>