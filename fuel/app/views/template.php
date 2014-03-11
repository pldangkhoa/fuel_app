<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array('bootstrap.css', 'layout.css')); ?>
</head>
<body>
	<div class="container">
		<?php echo $content; ?>
	</div>
</body>
</html>
