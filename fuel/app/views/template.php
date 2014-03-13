<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array('bootstrap.css', 'layout.css','ui-lightness/jquery-ui-1.10.4.custom.css')); ?>
	<?php echo Asset::js(array('jquery-1.10.2.js', 'jquery-ui-1.10.4.custom.js')); ?>
</head>
<body>
	<div class="container">
		<?php echo $content; ?>
	</div>
</body>
</html>
