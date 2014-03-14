<?php

use \Model\users;

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
		$this->template->title = 'mypage';
		$this->template->user_info = $this->user_info;
		$this->template->content = View::forge('user/mypage', $this->user_info);
	}

	public function action_user_info_edit()
	{
		$data = array();
		
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
		$this->template->user_info = $this->user_info;
		$this->template->content = View::forge('user/user_info_edit', $data);
	}
	
	
	public function action_signout()
	{	
		if (Input::method() == 'POST') {
			if (Input::post('signout') == 1) {
				Auth::dont_remember_me();
				Auth::logout();
				
				// send mail
				$from = 'khoa@gmail.com';
				$to = $this->user_info['email'];
				$subject = 'Fuel app - Signout';
				$body = 'You have been signout!!!';
				$this->sendmail($from, $to, $subject, $body);
				
				Response::redirect('/auth/login');
			}
		}
		
		$this->template->title = 'signout';
		$this->template->user_info = $this->user_info;
		$this->template->content = View::forge('user/signout');
	}

	public function action_email_edit()
	{
		$data = array();
		$data['success'] = false;
		
		$this->template->title = 'email edit';
		$this->template->user_info = $this->user_info;
		
		
		if (Input::method() == 'POST') {
			$val = Validation::forge();
			$val->add_field('new_email', 'New Email', 'trim|required|min_length[6]');
			$val->add_field('confirm_new_email', 'Confirm New Email', 'trim|match_field[new_email]');
			
			if ($val -> run()) {
				$new_email =(string) trim(Input::post('new_email'));
				
				if (Users::updateEmail($this->user_id, $new_email)) {
					$data['success'] = true;
					
					// send mail
					
				} else {
					//$error = 101;
				}
					
			} else {
				//$form->validation()->error();
				//$this->template->error = 101;
			}	
		}
		
		$this->template->content = View::forge('user/email_edit', $data);
	}

	public function action_password_edit()
	{
		$data = array();
		$data['success'] = false;
		
		if (Input::method() == 'POST') {
			$val = Validation::forge();
			$val->add_field('old_password', 'Old Password', 'trim|required|min_length[6]');
			$val->add_field('new_password', 'New Password', 'trim|required|min_length[6]');
			$val->add_field('confirm_new_password', 'Confirm New Password', 'trim|match_field[new_password]');
			
			if ($val->run()) {
				$fields = $val->validated();
				
				$old_password = $this->hash_password($fields['old_password']);
				$new_password = $this->hash_password($fields['new_password']);
				
				if (Users::updatePassword($this->user_id, $old_password, $new_password)) {
					$data['success'] = true;
					
					// send mail
					
				} else {
					$error = 101;
				}
					
			} else {
				$error = array();
				$errors = $val->error();
				foreach ($errors as $k => $v) {
					$error[$k]['rule'] = $v->field;
				}
			var_dump($val->error('old_password')->get_message());
			}	
		}
		
		$this->template->title = 'password edit';
		$this->template->user_info = $this->user_info;
		$this->template->content = View::forge('user/password_edit', $data);
	}
	
}
