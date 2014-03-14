<?php
namespace Model;
use \DB;
use \Model\users;

class Hobbies extends \Model
{
	protected static $_mytable = 'hobbies';
	
	public static function getHobbyById($id)
	{
		if ($id) {
			try {
				return DB::select()->from(static::$_mytable)->where('id', $id)->execute()->as_array();
			} catch (Exception $e) {
				return false;
			}
		}
		
		return false;
	}
	
	public static function getAllHobbies()
	{
		try {
			return DB::select()->from(static::$_mytable)->execute()->as_array();
		} catch (Exception $e) {
			return false;
		}
		
		return false;
	}
	
	public static function getHobbiesByIds($ids = array())
	{
		if ($ids && is_array($ids)) {
			$result = DB::select('name')->from(static::$_mytable)->where('id', 'in', $ids)->order_by('order','asc')->execute()->as_array();
			if ($result) {
				foreach ($result as $key => $value) {
					$result[$key] = $value['name'];
				}
				return $result;
			} else {
				return false;
			}
		}
		
		return false;
	}
	
}