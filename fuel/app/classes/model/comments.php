<?php
namespace Model;
use \DB;
use \Model\users;

class Comments extends \Model_Crud
{
	protected static $_table_name = 'comments';

	public static function addComment($user_id = null, $body = null)
	{
		if ($user_id && $body) {
			list($insert_id, $rows_affected) = DB::insert(static::$_table_name)->set(array(
				'user_id' => $user_id,
				'body' => $body,
				'created_at' => \Date::forge()->get_timestamp()
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
			try {
				return DB::select()->from(static::$_table_name)->where('id', $id)->execute();
			} catch (Exception $e) {
				return false;
			}
		}
		
		return false;
	}

	public static function getAllComments()
	{
		$result = DB::select()->from(static::$_table_name)->execute()->as_array();
			
		if ($result) {
			foreach ($result as $key => $value) {
				$result[$key]['owner'] = Users::getUserById($value['user_id']);
				$result[$key]['created_at'] = date('Y/m/d H:i:s', $result[$key]['created_at']);
			}
			return $result;
		} else {
			return false;
		}
	}

	public static function getComments($id = null)
	{
		if ($id) {
			$result = DB::select()->from(static::$_table_name)->where('id', '<', $id)->order_by('id','desc')->limit(_COMMENT_LIMIT_)->execute()->as_array();
		} else {
			$result = DB::select()->from(static::$_table_name)->order_by('id','desc')->limit(_COMMENT_LIMIT_)->execute()->as_array();
		}
		
		if ($result) {
			foreach ($result as $key => $value) {
				$result[$key]['owner'] = Users::getUserById($value['user_id']);
				$result[$key]['created_at'] = date('Y/m/d H:i:s', $result[$key]['created_at']);
			}
			return $result;
		} else {
			return false;
		}
	}
	
	public static function countAllComments()
	{
		$result = DB::select('*')->from(static::$_table_name)->execute();
		
		return count($result);
	}
}