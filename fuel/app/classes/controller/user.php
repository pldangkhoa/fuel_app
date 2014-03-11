<?php

use \Model\users;

class Controller_User extends Controller_Mycontroller
{

	public function action_index()
	{
		
		var_dump("action_index");
	}

	public function action_mypage()
	{
		$user_id = 1;
		$ret = Users::getUserById($user_id);
		var_dump($ret);
	}

	public function action_user_info_edit()
	{
		
		var_dump("action_user_info_edit");
	}
	
	
	public function action_signout()
	{
		
		var_dump("action_signout");
	}

	public function action_email_edit()
	{
		
		var_dump("action_email_edit");
	}

	public function action_password_edit()
	{
		
		var_dump("action_password_edit");
	}
}
