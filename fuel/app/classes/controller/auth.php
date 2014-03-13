<?php

use \Model\users;

class Controller_Auth extends Controller_Mycontroller
{

	public function action_index()
	{
		Response::redirect('/auth/login');
	}

	public function action_login()
	{
		if (Auth::check()) {
			Response::redirect('/');
		}
		
		if (Input::method() == 'POST') {
			$val = Validation::forge();
			$val->add_field('email', 'Email', 'trim|required');
			$val->add_field('password', 'Password', 'trim|required|min_length[6]');
			
			if ($val -> run()) {
				if (Auth::instance()->login(Input::post('email'), Input::post('password'))) {
					if (Input::post('remember', false)) {
						Auth::remember_me();
					} else {
						Auth::dont_remember_me();
					}
					Response::redirect('/');
				} else {
					echo "error";
				}
			} else {
				//$form->validation()->error();
			}	
		}
		
		$this->template->title = 'login';
		$this->template->content = View::forge('auth/login');
	}

	public function action_logout()
	{
		Auth::dont_remember_me();
		Auth::logout();
		Response::redirect('/auth/login');
	}

	public function action_signup()
	{
		$data = array();
		
		$val = Validation::forge();
		$val->add_field('username', 'User name', 'trim|required|min_length[6]');
		$val->add_field('email', 'Email', 'trim|required');
		$val->add_field('password', 'Password', 'trim|required|min_length[6]');
		$val->add_field('confirm_password', 'Confirm Password', 'trim|match_field[password]');
		$val->add_field('gender', 'Gender', 'trim|required');
		
		if ($val -> run()) {
			$user = array(
				'username'        	=> (string) trim(Input::post('username')),
				'password'        	=> $this->hash_password((string) trim(Input::post('password'))),
				'email'           	=> strtolower(trim(Input::post('email'))),
				'gender'			=> (int)(Input::post('gender'))
			);
			
			// insert user
			$ret = Users::insertUser($user);
			if ($ret) {
				Response::redirect('/');
			}
		} else {
			//$form->validation()->error();
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
