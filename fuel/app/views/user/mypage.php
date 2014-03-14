<div class="row">
	<div class="col-xs-12">
		<dl class="dl-horizontal">
			<dt>name:</dt>
			<dd><?php echo $username; ?></dd>
			<dt>email:</dt>
			<dd><?php echo $email; ?></dd>
			<dt>gender:</dt>
			<dd><?php echo $gender; ?></dd>
			<dt>hobby:</dt>
			<dd><?php echo $hobbies; ?></dd>
			<dt>icon:</dt>
			<dd>
			<?php if (!empty($icon)) : ?>
				<img alt="icon" width="50px" height="50px" src="/files/<?php echo $icon; ?>">
			<?php endif; ?>
			</dd>
		</dl>
	</div>
</div>
