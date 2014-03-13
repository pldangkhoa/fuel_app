<?php

use \Model\users;

class Controller_User extends Controller_Mycontroller
{

	public $template = 'user/layout';

	public function __construct()
	{
		if (!Auth::check()) {
			Response::redirect('/auth/login');
		}
	}

	public function action_index()
	{
		Response::redirect('/user/mypage');
	}

	public function action_mypage()
	{
		$data = array();
		$user_id = Auth::get_user_id();
		$data = Users::getUserById($user_id[1]);
		
		$this->template->title = 'mypage';
		$this->template->content = View::forge('user/mypage', $data);
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
