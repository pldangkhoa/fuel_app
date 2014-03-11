<?php
namespace Model;
use \DB;
use \Model\users;

class Comments extends \Model
{
	protected static $_mytable = 'comments';
	
	public static function addComment($user_id = null, $body = null)
	{
		if ($user_id && $body) {
			list($insert_id, $rows_affected) = DB::insert(static::$_mytable)->set(array(
				'user_id' => $user_id,
				'body' => $body,
				'created_date' => date("Y-m-d H:i:s")
			))->execute();
			
			if ($rows_affected != 0) {
				return $insert_id;
			}
		}
		return false;
	}
	
	public static function getCommentById($id)
	{
		if ($id) {
			$result = DB::select()->from(static::$_mytable)->where('id', $id)->execute();
			
			if ($result) {
				return $result;
			}
		}
		
		return false;
	}
	
	public static function getAllComments()
	{
		$result = DB::select()->from(static::$_mytable)->execute()->as_array();;
			
		if ($result) {
			foreach ($result as $key => $value) {
				$result[$key]['owner'] = Users::getUserById($value['user_id']);
			}
			return $result;
		} else {
			return false;
		}
	}
	
	public static function getCommentsByOffset($limit = null, $offset = null)
	{
		if ($limit && $offset) {
			$result = DB::select()->from(static::$_mytable)->limit($limit)->offset($offset)->execute();
		} else {
			$result = DB::select()->from(static::$_mytable)->limit(10)->offset(0)->execute();
		}
		
		if ($result) {
			return $result;
		} else {
			return false;
		}
	}
	
}