
<div class="col-xs-4">
	<div>
		<img alt="icon" width="100px" height="100px" src="/assets/img/<?php echo $icon; ?>">
	</div>
	<div class="menu">
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
	<p>name: <?php echo $username; ?></p>
	<p>email: <?php echo $email; ?></p>
	<p>gender: <?php echo $gender; ?></p>
	<p>hobby: <?php echo $hobbies; ?></p>
	<p>icon: <img alt="icon" width="50px" height="50px" src="/assets/img/<?php echo $icon; ?>"></p>
</div>