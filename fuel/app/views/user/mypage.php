<div class="row">
	<div class="col-xs-12">
		<dl class="dl-horizontal info">
			<dt>name:</dt>
			<dd><?php echo $username; ?></dd>
			<dt>email:</dt>
			<dd><?php echo $email; ?></dd>
			<dt>gender:</dt>
			<dd><?php echo $gender; ?></dd>
			<dt>hobby:</dt>
			<dd><?php echo !empty($hobbies) ? $hobbies : ''; ?></dd>
			<dt>icon:</dt>
			<dd>
			<?php if (!empty($icon)) : ?>
				<img alt="icon" class="icon-small" src="<?php echo _ICON_PATH_.$icon; ?>">
			<?php endif; ?>
			</dd>
		</dl>
	</div>
</div>