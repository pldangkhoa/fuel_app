<?php

use \Model\users;

class Controller_Auth extends Controller_Mycontroller
{

	public function action_index()
	{
		
		
		var_dump("action_index");
	}

	public function action_login()
	{
		$data = array();
		
		var_dump($_POST);
		
		$val = Validation::forge();
		$val->add_field('email', 'Email', 'trim|required|min_length[6]');
		$val->add_field('password', 'Password', 'trim|required');

		if ($val -> run()) {
			$email = strtolower(trim(Input::post('email')));
			$password = trim(Input::post('password'));
			$password = md5($password);
			
			//
			
		}
		
		$this->template->title = 'login';
		$this->template->content = View::forge('auth/login', $data);
	}

	public function action_signup()
	{
		$data = array();
		
		$val = Validation::forge();
		$val->add_field('username', 'User name', 'trim|required|min_length[6]');
		$val->add_field('email', 'Email', 'trim|required');
		$val->add_field('password', 'Password', 'trim|required|min_length[6]');
		$val->add_field('confirm_password', 'Confirm Password', 'trim|required|min_length[6]');
		$val->add_field('gender', 'Gender', 'trim|required');

		if ($val -> run()) {
			$data['username'] = trim(Input::post('username'));
			$data['email'] = strtolower(trim(Input::post('email')));
			$data['password'] = md5(trim(Input::post('password')));
			$data['gender'] = (int)(Input::post('gender'));
			
			$ret = Users::insertUser($data);
			if ($ret) {
				Response::redirect('/');
			}
			
		} else {
			
		}
		
		$this->template->title = 'signup';
		$this->template->content = View::forge('auth/signup', $data);
	}

	public function action_thank_you_signup()
	{
		
		
		var_dump("action_thank_you_signup");
	}

	public function action_activation_complete()
	{
		
		
		var_dump("action_activation_complete");
	}

	public function action_forget_password()
	{
		
		
		var_dump("action_forget_password");
	}

	public function action_new_password()
	{
		
		
		var_dump("action_new_password");
	}
	
}
