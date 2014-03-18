<?php
use \Model\users;
use \Model\genders;
use \Model\hobbies;

class Controller_User extends Controller_Mycontroller
{

	public $template = 'user/layout';
	protected $user_id;
	protected $user_info = array();

	public function __construct()
	{
		if (!Auth::check()) {
			Response::redirect('/auth/login');
		}
		
		$auth_id = Auth::get_user_id();
		$this->user_id = $auth_id[1];
		$this->user_info = Users::getUserById($this->user_id);
	}

	public function action_index()
	{
		Response::redirect('/user/mypage');
	}

	public function action_mypage()
	{
		$data = array();
		$action = \Request::active()->action;
		
		$this->user_info['gender'] = Genders::find_by_pk($this->user_info['gender'])->name;
		
		if (!empty($this->user_info['hobbies'])) {
			$this->user_info['hobbies'] = implode(', ', Hobbies::getHobbiesByIds($this->user_info['hobbies']));
		}
		
		$user_info = $this->user_info;
		$data = compact('action', 'user_info');
		
		$this->template->title = 'mypage';
		$this->template->data = $data;
		$this->template->content = View::forge('user/mypage', $this->user_info);
	}

	public function action_user_info_edit()
	{
		$data = array();
		$user = array();
		$data['action'] = \Request::active()->action;
		$data['user_info'] = $this->user_info;
		$data['genders'] = Genders::getAllGenders();
		$data['hobbies'] = Hobbies::getAllHobbies();
		
		if (Input::method() == 'POST') {
			$val = Validation::forge();
			$val->add_field('username', 'Username', 'trim|required|min_length[6]');
			$val->add_field('gender', 'Gender', 'required');
			$val->add_field('view_icon', 'View icon', 'valid_string[numeric]');
			$val->add_field('cronmail', 'Cronmail', 'required');
			$val->add('hobby', 'Hobby');
			
			if ($val->run()) {
				
				$post = $val->validated();
				$user['username'] = trim($post['username']);
				$user['gender'] = in_array($post['gender'], array(1, 2)) ? $post['gender'] : 3;
				$user['view_icon'] = empty($post['view_icon']) ? 1 : 0;
				$user['cronmail'] = empty($post['cronmail']) ? 0 : 1;
				$user['modified_at'] = \Date::forge()->get_timestamp();
				if (isset($post['hobby']) && is_array($post['hobby'])) {
					$user['hobbies'] = json_encode($post['hobby']);
				} else {
					$user['hobbies'] = null;
				}
				
				Upload::process();
				if (Upload::is_valid()) {
					Upload::save();
					$icon_data = Upload::get_files();
					
					if ($icon_data) {
						$user['icon'] = $this->user_id.'_'.$icon_data[0]['saved_as'];
						rename(DOCROOT.'files/'.$icon_data[0]['saved_as'], DOCROOT.'files/'.$user['icon']);
					}
				}
				
				if (Users::editUser($this->user_id, $user)) {
					$data['user_info'] = Users::getUserById($this->user_id);
				} else {
					$data['error'] = 'Updated error.';
				}
			} else {
				$data['error'] = $val->error_message();
			}
		}
		
		$this->template->title = 'user_info_edit';
		$this->template->data = $data;
		$this->template->content = View::forge('user/user_info_edit', $data);
	}

	public function action_signout()
	{	
		$data = array();
		$data['action'] = \Request::active()->action;
		$data['user_info'] = $this->user_info;
		
		if (Input::method() == 'POST') {
			if (Input::post('signout') == 1) {
				Auth::dont_remember_me();
				Auth::logout();
				
				// send mail
				$to = $this->user_info['email'];
				$subject = 'Fuel app - Signout';
				$body = $data['user_info'];
				$this->sendmail($to, $subject, $body, $view = 'signout');
				
				Response::redirect('/auth/login');
			}
		}
		
		$this->template->title = 'signout';
		$this->template->data = $data;
		$this->template->content = View::forge('user/signout');
	}

	public function action_email_edit()
	{
		$data = array();
		$data['action'] = \Request::active()->action;
		$data['user_info'] = $this->user_info;
		$data['success'] = false;
		
		if (Input::method() == 'POST') {
			if (\Input::post('check_password') == 1) {
				$data['check_password'] = 1;
			}
			
			$val = Validation::forge();
			$val->add_field('new_email', 'New Email', 'trim|required|valid_email');
			$val->add_field('confirm_new_email', 'Confirm New Email', 'trim|match_field[new_email]');
			
			if ($val->run()) {
				$new_email = (string) strtolower(trim($val->validated('new_email')));
				
				$user = Users::find_one_by('email', $new_email);
				if ($user) {
					$data['error']['new_email'] = 'Your email is used.';
				} else {
					if (Users::updateEmail($this->user_id, $new_email)) {
						// send mail
						$to = array($new_email, $this->user_info['email']);
						$subject = 'Fuel app - Email edit';
						$body = $data['user_info'];
						$this->sendmail($to, $subject, $body, $view = 'email_edit');
						
						$data['success'] = 'Your email has been changed.';
					} else {
						$data['error']['success'] = 'Update email error.';
					}
				}	
			} else {
				$data['error'] = $val->error_message();
			}
		}
		
		$this->template->title = 'email edit';
		$this->template->data = $data;
		$this->template->content = View::forge('user/email_edit', $data);
	}

	public function action_password_edit()
	{
		$data = array();
		$data['action'] = \Request::active()->action;
		$data['user_info'] = $this->user_info;
		$data['success'] = false;
		
		if (Input::method() == 'POST') {
			$val = Validation::forge();
			$val->add_field('old_password', 'Old Password', 'trim|required|min_length[6]');
			$val->add_field('new_password', 'New Password', 'trim|required|min_length[6]');
			$val->add_field('confirm_new_password', 'Confirm New Password', 'trim|match_field[new_password]');
			
			if ($val->run()) {
				$old_password = $this->hash_password(trim($val->validated('old_password')));
				$new_password = $this->hash_password(trim($val->validated('new_password')));
				
				$users = Users::find_by(array('id' => $this->user_id, 'password' => $old_password));
				if ($users) {
					foreach ($users as $user) {
						$user->password = $new_password;
						$user->save();
						
						$data['success'] = 'Your password has been changed.';
					}
					
					// send mail
					$to = $this->user_info['email'];
					$subject = 'Fuel app - Password edit';
					$body = $data['user_info'];
					$this->sendmail($to, $subject, $body, $view = 'password_edit');
					
				} else {
					$data['error']['old_password'] = 'Your old password is not correct.';
				}	
			} else {
				$data['error'] = $val->error_message();
			}	
		}
		
		$this->template->title = 'password edit';
		$this->template->data = $data;
		$this->template->content = View::forge('user/password_edit', $data);
	}
	
	public function action_check_password() {
		$data = array();
		$data['success'] = false;
		
		if (Input::method() == 'POST') {
			$val = Validation::forge();
			$val->add_field('password', 'Password', 'trim|required|min_length[6]');
			
			if ($val -> run()) {
				$password = $this->hash_password(trim($val->validated('password')));
				if (Users::find_by(array('id' => $this->user_id, 'password' => $password))) {
					$data['success'] = true;
				} else {
					$data['success'] = false;
					$data['error']['password'] = 'Password is not correct.';
				}
			} else {
				$data['error'] = $val->error_message();
			}
		}
		
		return json_encode($data);
	}
}