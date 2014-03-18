<?php
use \Model\users;
use \Model\genders;

class Controller_Auth extends Controller_Mycontroller
{
	public function action_index()
	{
		\Response::redirect('/auth/login');
	}

	public function action_login()
	{
		$data = array();
		$data['app_name'] = $this->app_name;
		$data['loginUrl'] = $this->getFbLoginUrl();
		
		if (\Auth::check()) {
			\Response::redirect('/');
		}
		
		//check facebook
		$get = Input::get();
		if ( !empty($get['code']) && !empty($get['state'])) {
			$user_profile = $this->getFbUser();
			if ( !empty($user_profile) ) {
				$data['username'] = $user_profile['username'];
				$data['email'] = $user_profile['email'];
				$id_gender = Genders::getIdByName(ucfirst($user_profile['gender']));
				$data['gender'] = !empty($id_gender) ? $id_gender[0]['id'] : 3;
				
				// check email
				$user = Users::find_one_by('email', $data['email']);
				if ($user) {
					if (\Auth::force_login($user->id)) {
						\Response::redirect('/');
					} else {
						$data['error']['login_fail'] = 'Your account has not actived.';
					}
				} else {
					\Response::redirect('/auth/signup'.'?username='.$data['username'].'&email='.$data['email'].'&gender='.$data['gender']);
				}
			}
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
		
		$this->template->title = 'login';
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
		$data = array();
		$data['base_url'] = 'http://'.$_SERVER['HTTP_HOST'];
		$data['app_name'] = $this->app_name;
		$data['genders'] = Genders::getAllGenders();
		$data['loginUrl'] = $this->getFbLoginUrl();
		
		$get = \Input::get();
		if (!empty($get)) {
			$data['user'] = array(
				'username' => !empty($get['username']) ? $get['username'] : null,
				'email' => !empty($get['email']) ? $get['email'] : null,
				'gender' => !empty($get['gender']) ? $get['gender'] : null,
			);
		}
		
		//check facebook
		if ( !empty($get['code']) && !empty($get['state'])) {
			$user_profile = $this->getFbUser();
			if ( !empty($user_profile) ) {
				$id_gender = Genders::getIdByName(ucfirst($user_profile['gender']));
				$gender = !empty($id_gender) ? $id_gender[0]['id'] : 3;
				$data['user'] = array(
					'username' => $user_profile['username'],
					'email' => $user_profile['email'],
					'gender' => $gender,
				);
			}
		}
		
		if (\Input::method() == 'POST') {
			$val = \Validation::forge();
			$val->add_field('username', 'User name', 'trim|required|min_length[6]');
			$val->add_field('email', 'Email', 'trim|required|valid_email');
			$val->add_field('password', 'Password', 'trim|required|min_length[6]');
			$val->add_field('confirm_password', 'Confirm Password', 'trim|match_field[password]');
			$val->add_field('gender', 'Gender', 'required');
			
			if ($val->run()) {
				$post = $val->validated();
				
				$user = array(
					'username'	=> (string) trim($post['username']),
					'password'	=> $this->hash_password((string) trim($post['password'])),
					'email'		=> strtolower(trim($post['email'])),
					'gender'	=> in_array($post['gender'], array(1, 2)) ? $post['gender'] : 3,
					'auth_code'	=> $this->genCode(trim($post['email']))
				);
				
				if (Users::find_one_by('email',$user['email'])) {
					$data['error']['email'] = 'Your email is invalid.';
				} else {
					if (Users::insertUser($user)) {
						// send mail
						$to = $user['email'];
						$subject = 'Fuel app - Signup';
						$body = $user;
						$this->sendmail($to, $subject, $body, $view = 'signup');
						
						\Response::redirect('/auth/thank_you_signup');
					} else {
						$data['error']['signup_fail'] = 'Sign up error.';
					}
				}
			} else {
				$data['error'] = $val->error_message();
			}
			
			$data['user'] = $val->validated();
		}
		
		$this->template->title = 'signup';
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
		$auth_code = !empty(\Request::active()->method_params[0]) ? \Request::active()->method_params[0] : null;
		
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
		$data['base_url'] = 'http://'.$_SERVER['HTTP_HOST'];
		
		if (\Input::method() == 'POST') {
			$val = \Validation::forge();
			$val->add_field('email', 'Email', 'trim|required|valid_email');
			
			if ($val->run()) {
				$email = trim($val->validated('email'));
				$user = Users::find_one_by('email', $email);
				if ($user) {
					$data['password_code'] = $this->genCode($email);
					$user->password_code = $data['password_code'];
					$user->save();
					
					// send mail
					$to = $email;
					$subject = 'Fuel app - Forget password';
					$body = $data;
					$this->sendmail($to, $subject, $body, $view = 'forget_password');
					
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
		$data['password_code'] = !empty(\Request::active()->method_params[0]) ? \Request::active()->method_params[0] : null;
		
		$user = Users::find_one_by('password_code', $data['password_code']);
		if ($user) {
			if (\Input::method() == 'POST') {
				$val = Validation::forge();
				$val->add_field('new_password', 'New Password', 'trim|required|min_length[6]');
				$val->add_field('confirm_new_password', 'Confirm New Password', 'trim|match_field[new_password]');
				
				if ($val->run()) {
					$password = $this->hash_password(trim($val->validated('new_password')));
					
					$user->password_code = null;
					$user->password = $password;
					$user->save();
					
					$data['error']['success'] = 'Your password has been changed.';
				} else {
					$data['error'] = $val->error_message();
				}
			}
		} else {
			$data['error']['password_code'] = 'Auth code is not correct.';
		}
		
		$this->template->title = 'new password';
		$this->template->content = View::forge('auth/new_password', $data);
	}
}