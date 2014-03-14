<?php

use \Model\users;
use \Model\hobbies;

class Controller_User extends Controller_Mycontroller
{

	public $template = 'user/layout';
	protected $user_id;
	protected $user_info = array();
	protected $segments = array();

	public function __construct()
	{
		if (!Auth::check()) {
			Response::redirect('/auth/login');
		}
		
		$this->segments = Uri::segments();
		
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
		$data['controller'] = $this->segments[0];
		$data['action'] = $this->segments[1];
		
		$hobby_ids = json_decode($this->user_info['hobbies']);
		$hobbies = Hobbies::getHobbiesByIds($hobby_ids);
	//	$hobbies = implode(', ', $hobbies);
		
	//	$hobbies = explode(',', $string)
		
	//	var_dump($hobby_ids);
		
		
		$data['user_info'] = $this->user_info;
		
		$this->template->title = 'mypage';
		$this->template->data = $data;
		$this->template->content = View::forge('user/mypage', $this->user_info);
	}

	public function action_user_info_edit()
	{
		$data = array();
		$data['controller'] = $this->segments[0];
		$data['action'] = $this->segments[1];
		$data['user_info'] = $this->user_info;
		
		if (Input::method() == 'POST') {
			$val = Validation::forge();
			$val->add_field('username', 'Username', 'trim|required|min_length[6]');
			$val->add_field('gender', 'Gender', 'required');
			$val->add_field('cronmail', 'Cronmail', 'required');
			$val->add_field('hobby', 'Hobby', 'required');
			
			if ($val -> run()) {
				
				$config = array(
					'path' => DOCROOT.'files',
					'randomize' => true,
					'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
					'max_size'    => 1024000,
					'auto_rename' => false,
					'overwrite'   => true
				);
				
				Upload::process($config);
				
				if (Upload::is_valid()) {
					Upload::save();
					$icon_data = Upload::get_files();
				}
				
				$post = Input::post();
				$data['username'] = $post['username'];
				$data['gender'] = $post['gender'];
				$data['cronmail'] = $post['cronmail'];
				if (isset($icon_data)) {
					$data['icon'] = $this->user_id . '.' . $icon_data[0]['extension'];
					rename(DOCROOT.'files/'.$icon_data[0]['saved_as'], DOCROOT.'files/'.$data['icon']);
				}
				
				if (isset($post['hobby'])) {
					$data['hobbies'] = json_encode($post['hobby']);
				}
				
				var_dump($data);
				
				try {
					Users::editUser($this->user_id, $data);
					
					
				} catch (Exception $e) {
					var_dump("error");
				}
			} else {
				//show error
			}
				
		} else {
			//$form->validation()->error();
			//$this->template->error = 101;
		}	
		
		
		$data['user_info'] = $this->user_info;
		
		$this->template->title = 'user_info_edit';
		$this->template->data = $data;
		$this->template->content = View::forge('user/user_info_edit', $data);
	}
	
	
	public function action_signout()
	{	
		$data = array();
		$data['controller'] = $this->segments[0];
		$data['action'] = $this->segments[1];
		$data['user_info'] = $this->user_info;
		
		if (Input::method() == 'POST') {
			if (Input::post('signout') == 1) {
				Auth::dont_remember_me();
				Auth::logout();
				
				// send mail
				$from = 'khoa@gmail.com';
				$to = $this->user_info['email'];
				$subject = 'Fuel app - Signout';
				$body = $data['user_info'];
				$this->sendmail($from, $to, $subject, $body, $view = 'signout');
				
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
		$data['controller'] = $this->segments[0];
		$data['action'] = $this->segments[1];
		$data['user_info'] = $this->user_info;
		$data['success'] = false;
		
		if (Input::method() == 'POST') {
			$val = Validation::forge();
			$val->add_field('new_email', 'New Email', 'trim|required|valid_email');
			$val->add_field('confirm_new_email', 'Confirm New Email', 'trim|match_field[new_email]');
			
			if ($val -> run()) {
				$new_email = (string) trim($val->validated('new_email'));
				
				$user = Users::find_one_by('email', $new_email);
				if ($user) {
					$data['error']['new_email'] = 'Your email is used.';
				} else {
					if (Users::updateEmail($this->user_id, $new_email)) {
						// send mail
						$from = 'khoa@gmail.com';
						$to = $new_email;
						$subject = 'Fuel app - Email edit';
						$body = $data['user_info'];
						$this->sendmail($from, $to, $subject, $body, $view = 'email_edit');
						
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
		$data['controller'] = $this->segments[0];
		$data['action'] = $this->segments[1];
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
					$from = 'khoa@gmail.com';
					$to = $this->user_info['email'];
					$subject = 'Fuel app - Password edit';
					$body = $data['user_info'];
					$this->sendmail($from, $to, $subject, $body, $view = 'password_edit');
					
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
	
}
