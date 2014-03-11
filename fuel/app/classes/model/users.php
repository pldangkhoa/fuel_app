<?php
namespace Model;
use \DB;

class Users extends \Model
{
	protected static $_mytable = 'users';
	
	public static function insertUser($data = null)
	{
		if ($data) {
			list($insert_id, $rows_affected) = DB::insert(static::$_mytable)
				->set(array('email' => $data['email'],
							'password' => $data['password'],
							'username' => $data['username'],
							'gender' => $data['gender'],
							'auth_code' => '',
							'created_date' => date("Y-m-d H:i:s")
				))->execute();
			if ($rows_affected != 0)
				return $insert_id;
		}
		return false;
	}
	
	public static function editUser($data = null, $user_id = null)
	{
		if ($data && $uid) {
			$query = DB::update(static::$_mytable)->set($data)->where('id', $uid)->execute();
			return true;
		}
		return false;
	}
	
	public static function getUserById($user_id)
	{
		if ($user_id) {
			$result = DB::select('*')->from(static::$_mytable)->where('id', $user_id)->execute()->as_array();
			
			if ($result) {
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
			$result = DB::select('id')->from(static::$_mytable)->where('id', $user_id)->and_where('password', md5($password))->execute();
			
			if ($result) {
				return true;
			}
		}
		
		return false;
	}
	
	public static function updatePassword($user_id = null, $password = null)
	{
		if ($user_id && $password) {
			$result = DB::update(static::$_mytable)->value('password', md5($password))->where('id', '=', $user_id)->execute();
			
			if ($result) {
				return true;
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
			$result = DB::update(static::$_mytable)->value('email', $email)->where('id', '=', $user_id)->execute();
			
			if ($result) {
				return true;
			}
		}
		
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}