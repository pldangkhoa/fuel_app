<?php

namespace Model;

use Fuel\Core\DB;

class Userhobby extends \Fuel\Core\Model_Crud
{

    protected static $_table_name = 'user_hobby';

    public static function insertByUserId($user_id = null, $data = array())
    {
        if ($user_id && $data) {
            try {
                $query = DB::insert(static::$_table_name)->columns(array('user_id', 'hobby_id'));
                foreach ($data as $value) {
                    $query->values($value);
                }
                $query->execute();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

    public static function deleteByUserId($user_id = null)
    {
        if ($user_id) {
            try {
                return DB::delete(static::$_table_name)->where('user_id', $user_id)->execute();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

    public static function getHobbyIdsByUserId($user_id = null)
    {
        if ($user_id) {
            try {
                return DB::select('hobby_id')->from(static::$_table_name)->where('user_id', $user_id)->distinct(true)->execute()->as_array();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

    public static function getUserIdsByHobbyId($hobby_id = null)
    {
        if ($hobby_id) {
            try {
                return DB::select('user_id')->from(static::$_table_name)->where('hobby_id', $hobby_id)->distinct(true)->execute()->as_array();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

    public static function getUserIdsByHobbyIds($hobby_ids = array())
    {
        if (!empty($hobby_ids)) {
            try {
                return DB::select('user_id')->from(static::$_table_name)->where('hobby_id', 'in', $hobby_ids)->distinct(true)->execute()->as_array();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

}
