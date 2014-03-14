<?php if (!empty($comments)) : ?>
	<?php foreach ($comments as $comment) : ?>
	<div class="row comment">
		<div class="col-xs-2 col-sm-offset-2"><?php echo $comment['owner']['username']?></div>
		<div class="col-xs-6 comment-box">
			<span><?php echo $comment['body']; ?></span>
			<span class="time"><?php echo $comment['created_date']; ?></span>
		</div>
	</div>
	<?php endforeach; ?>
<?php endif; ?>
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