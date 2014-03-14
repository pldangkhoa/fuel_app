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
		<div class="row myapp-top">
			<div class="col-xs-6 title">mypage</div>
			<div class="col-xs-6 text-right">
				<a href="/"><button type="button" class="btn btn-default">Go Back App</button></a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<div>
					<img alt="icon" width="100px" height="100px" src="/files/<?php echo $user_info['icon']; ?>">
					<span><?php echo $user_info['username']; ?></span>
				</div>
				
				<div class="menu">
					<span>menu</span>
					<ul>
						<li><a href="/user/mypage">user_info</a></li>
						<li><a href="/user/user_info_edit">user_edit_info</a></li>
						<li><a href="/user/email_edit">email_edit</a></li>
						<li><a href="/user/password_edit">password_edit</a></li>
						<li><a href="/user/signout">signout</a></li>
					</ul>
				</div>
			</div>
			<div class="col-xs-8">
				<?php echo $content; ?>
			</div>
		</div>
	</div>
</body>
</html>
