<?php
namespace Model;
use \DB;

class Users extends \Model
{
	protected static $_mytable = 'users';
	
	public static function insertUser($data = null)
	{
		if ($data) {
			if ($data['email']) {
				$result = DB::select()->from(static::$_mytable)->where('email', '=', $data['email'])->execute();
				
				if ($result->count() > 0) {
					return false;
				}
			} else {
				return false;
			}
			
			list($insert_id, $rows_affected) = DB::insert(static::$_mytable)
				->set(array('email' => $data['email'],
							'password' 			=> $data['password'],
							'username' 			=> $data['username'],
							'gender' 			=> $data['gender'],
							'group'           	=> 2,
							'profile_fields'  	=> serialize(array()),
							'last_login'      	=> 0,
							'login_hash'      	=> '',
							'created_at'      	=> \Date::forge()->get_timestamp(),
							'auth_code' 		=> '',
							'created_date' 		=> date("Y-m-d H:i:s")
				))->execute();
			if ($rows_affected != 0)
				return $insert_id;
		}
		return false;
	}
	
	public function checkValidUser($email = null)
	{
		if ($email) {
			$result = DB::select()->from(static::$_mytable)->where('email', '=', $email)->execute();
			
			if ($result->count() > 0) {
				return false;
			} else {
				return true;
			}
		}
		
		return false;
	}
	
	public static function editUser($user_id = null, $data = null)
	{
		if ($user_id && $data) {
			try {
				DB::update(static::$_mytable)->set($data)->where('id', $user_id)->execute();
			} catch (Exception $e) {
				return false;
			}
		}
		return false;
	}
	
	public static function getUserById($user_id)
	{
		if ($user_id) {
			$result = DB::select('*')->from(static::$_mytable)->where('id', $user_id)->execute()->as_array();
			
			if ($result) {
				
		//		$hobbies = json_decode($result[0]['hobbies']);
				
				return $result[0];
			}
		}
		
		return false;
	}
	
	public static function login($data = null) {
		if ($data) {
			$result = DB::select()
						->from(static::$_mytable)
						->where('email', $data['email'])
						->and_where('password', $data['password'])
						->execute()
						->as_array();
			if ($result)
				return $result;
		}
		
		return false;
	}
	
	public static function checkPassword($user_id = null, $password = null)
	{
		if ($user_id && $password) {
			$result = DB::select('id')->from(static::$_mytable)->where('id', $user_id)->and_where('password', $password)->execute();
			
			if ($result) {
				return true;
			}
		}
		
		return false;
	}
	
	public static function updatePassword($user_id = null, $old_password = null, $new_password = null)
	{
		if ($user_id && $old_password && $new_password) {
			
			if (Users::checkPassword($user_id, $old_password)) {
				try {
					return DB::update(static::$_mytable)->value('password', $new_password)->where('id', '=', $user_id)->execute();
				} catch (Exception $e) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	public static function checkEmail($user_id = null, $email = null)
	{
		if ($user_id && $email) {
			$result = DB::select('id')->from(static::$_mytable)->where('id', $user_id)->and_where('email', $email)->execute();
			
			if ($result) {
				return true;
			}
		}
		
		return false;
	}
	
	public static function updateEmail($user_id = null, $email = null)
	{
		if ($user_id && $email) {
			try {
				return DB::update(static::$_mytable)->value('email', $email)->where('id', '=', $user_id)->execute();
			} catch (Exception $e) {
				return true;
			}
		}
		
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}