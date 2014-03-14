<div class="row myapp-top">
	<div class="col-xs-6 title"><?php echo $app_name; ?></div>
	<div class="col-xs-6 text-right">
		<?php if (!empty($user_info['icon'])) : ?>
			<img alt="icon" width="50px" height="50px" src="/assets/img/<?php echo $user_info['icon']; ?>">
		<?php endif; ?>
		<span><?php echo $user_info['username']; ?></span>
		<a href="/user/mypage"><button type="button" class="btn btn-default">mypage</button></a>
		<button type="button" class="btn btn-default" id="logout-confirm">logout</button>
	</div>
</div>
<div id="confirm-box" style="display: none;">Logout?</div>
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
	<?php foreach ($comments as $comment) : ?>
	<div class="row comment">
		<div class="col-xs-2 col-sm-offset-2"><?php echo $comment['owner']['username']?></div>
		<div class="col-xs-6 comment-box">
			<span><?php echo $comment['body']; ?></span>
			<span class="time"><?php echo $comment['created_date']; ?></span>
		</div>
	</div>
	<?php endforeach; ?>
	<div id="read-more" class="row">
		<form id="load-comment-form" class="form-horizontal" role="form" action="<?php echo Uri::create('myapp/loadComment', array(), array()); ?>" method="post">
			<div class="form-group">
				<input type="hidden" name="offset" value="<?php echo $offset;?>">
				<button type="submit" class="col-md-offset-6 col-xs-2 btn btn-default">Read More</button>
			</div>
		</form>
		
		<script type="text/javascript">
			$( "#load-comment-form" ).submit(function( event ) {
				event.preventDefault();
				var $form = $( this ),
					offset = $form.find( "input[name='offset']" ).val(),
					url = $form.attr( "action" );
				var posting = $.post( url, { offset: offset } );
		
				posting.done(function( data ) {
					$( "#read-more" ).remove();
					$( "#comments" ).append( data );
				});
			});
		</script>
	</div>
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
				location = "auth/logout";
			},
			"Cancel": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
</script>