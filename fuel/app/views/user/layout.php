<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array('bootstrap.css', 'layout.css')); ?>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-6"><?php echo $title; ?></div>
			<div class="col-xs-6"><a href="/">Go Back App</a></div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<?php echo $content; ?>
			</div>
		</div>
		<footer>
			
		</footer>
	</div>
</body>
</html>
