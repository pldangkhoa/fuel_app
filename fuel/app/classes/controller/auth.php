<?php

use \Model\users;

class Controller_Auth extends Controller_Mycontroller
{
	public function action_index()
	{
		\Response::redirect('/auth/login');
	}

	public function action_login()
	{
		$this->template->title = 'login';
		$data = array();
		$data['app_name'] = $this->app_name;
		
		if (\Auth::check()) {
			\Response::redirect('/');
		}
		
		if (\Input::method() == 'POST') {
			$val = \Validation::forge();
			$val->add_field('email', 'Email', 'trim|required|valid_email');
			$val->add_field('password', 'Password', 'trim|required|min_length[6]');
			
			if ($val->run()) {
				$email = trim($val->validated('email'));
				$password = trim($val->validated('password'));
				
				if (\Auth::instance()->login($email, $password)) {
					if (\Input::param('remember', false)) {
						\Auth::remember_me();
					} else {
						\Auth::dont_remember_me();
					}
					\Response::redirect('/');
				} else {
					$data['error']['login_fail'] = 'Your username or password are not correct!!!';
				}
			} else {
				$data['error'] = $val->error_message();
			}
		}
		
		$this->template->content = \View::forge('auth/login', $data);
	}

	public function action_logout()
	{
		\Auth::dont_remember_me();
		\Auth::logout();
		\Response::redirect('/auth/login');
	}

	public function action_signup()
	{
		$this->template->title = 'signup';
		$data = array();
		$data['app_name'] = $this->app_name;
		
		if (\Input::method() == 'POST') {
			$val = \Validation::forge();
			$val->add_field('username', 'User name', 'trim|required|min_length[6]');
			$val->add_field('email', 'Email', 'trim|required|valid_email');
			$val->add_field('password', 'Password', 'trim|required|min_length[6]');
			$val->add_field('confirm_password', 'Confirm Password', 'trim|match_field[password]');
			$val->add_field('gender', 'Gender', 'required');
			
			if ($val->run()) {
				$user = array(
					'username'	=> (string) trim($val->validated('username')),
					'password'	=> $this->hash_password((string) trim($val->validated('password'))),
					'email'		=> strtolower(trim($val->validated('email'))),
					'gender'	=> (int)($val->validated('gender')),
					'auth_code'	=> $this->genCode(trim($val->validated('username')))
				);
				
				if (Users::checkInValidEmail($user['email'])) {
					// insert user
					if (Users::insertUser($user)) {
						// send mail
						$from = 'khoa@gmail.com';
						$to = $user['email'];
						$subject = 'Fuel app - Signup';
						$body = $user;
						$this->sendmail($from, $to, $subject, $body, $view = 'signup');
						
						\Response::redirect('/auth/thank_you_signup');
					} else {
						$data['error']['signup_fail'] = 'Sign up error.';
					}
				} else {
					$data['error']['signup_fail'] = 'Your email is invalid.';
				}
			} else {
				$data['error'] = $val->error_message();
			}
		}
		
		$this->template->content = \View::forge('auth/signup', $data);
	}

	public function action_thank_you_signup()
	{
		$this->template->title = 'thank_you_signup';
		$this->template->content = View::forge('auth/thank_you_signup');
	}

	public function action_activation_complete()
	{
		$data = array();
		
		$segments = Uri::segments();
		$auth_code = !empty($segments[2]) ? $segments[2] : null;
		
		$user = Users::find_one_by('auth_code', $auth_code);
		if ($user) {
			$user->auth_code = null;
			$user->actived = 1;
			$user->save();
		} else {
			$data['error'] = 'Activation is failed!';
		}
		
		$this->template->title = 'activation_complete';
		$this->template->content = View::forge('auth/activation_complete', $data);
	}

	public function action_forget_password()
	{
		$data = array();
		
		if (\Input::method() == 'POST') {
			$val = \Validation::forge();
			$val->add_field('email', 'Email', 'trim|required|valid_email');
			
			if ($val->run()) {
				$email = trim($val->validated('email'));
				$user = Users::find_one_by('email', $email);
				if ($user) {
					$data['auth_code'] = $this->genCode($email);
					
					$user->auth_code = $data['auth_code'];
					$user->save();
					
					// send mail
					$from = 'khoa@gmail.com';
					$to = $email;
					$subject = 'Fuel app - Forget password';
					$body = $data;
					$this->sendmail($from, $to, $subject, $body, $view = 'forget_password');
					
					$data['error']['success'] = 'We sent you an email.';
					
				} else {
					$data['error']['email'] = 'Your email is invalid.';
				}
			} else {
				$data['error'] = $val->error_message();
			}
		}
		
		$this->template->title = 'forget password';
		$this->template->content = View::forge('auth/forget_password', $data);
	}

	public function action_new_password()
	{
		$data = array();
		$segments = Uri::segments();
		$data['auth_code'] = !empty($segments[2]) ? $segments[2] : null;
		
		$user = Users::find_one_by('auth_code', $data['auth_code']);
		if ($user) {
			if (\Input::method() == 'POST') {
				$val = Validation::forge();
				$val->add_field('new_password', 'New Password', 'trim|required|min_length[6]');
				$val->add_field('confirm_new_password', 'Confirm New Password', 'trim|match_field[new_password]');
				
				if ($val->run()) {
					$password = $this->hash_password(trim($val->validated('new_password')));
					
					$user->auth_code = null;
					$user->password = $password;
					$user->save();
					
					\Response::redirect('/auth/change_password_success');
					
				} else {
					$data['error'] = $val->error_message();
				}
			}
		} else {
			$data['error']['auth_code'] = 'Auth code is not correct.';
		}
		
		$this->template->title = 'new password';
		$this->template->content = View::forge('auth/new_password', $data);
	}
	
	public function action_change_password_success()
	{
		$this->template->title = 'change_password_success';
		$this->template->content = View::forge('auth/change_password_success');
	}
}
