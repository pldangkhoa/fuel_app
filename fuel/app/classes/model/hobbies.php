<?php

namespace Model;

use Fuel\Core\DB;
use Model\Users;

class Hobbies extends \Fuel\Core\Model_Crud
{

    protected static $_table_name = 'hobbies';

    public static function getHobbyById($id)
    {
        if ($id) {
            try {
                return DB::select()->from(static::$_table_name)->where('id', $id)->execute()->as_array();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

    public static function getAllHobbies()
    {
        try {
            return DB::select()->from(static::$_table_name)->execute()->as_array();
        } catch (Exception $exc) {
            return FALSE;
        }

        return FALSE;
    }

    public static function getHobbiesByIds($ids = array())
    {
        if (!empty($ids) && is_array($ids)) {
            $result = DB::select('name')->from(static::$_table_name)->where('id', 'in', $ids)->order_by('order', 'asc')->execute()->as_array();
            if ($result) {
                foreach ($result as $key => $value) {
                    $result[$key] = $value['name'];
                }
                return $result;
            } else {
                return FALSE;
            }
        }

        return FALSE;
    }

    public static function getHobbiesNameByIds($ids = array())
    {
        if (!empty($ids) && is_array($ids)) {
            try {
                return DB::select('name')->from(static::$_table_name)->where('id', 'in', $ids)->order_by('order', 'asc')->execute()->as_array();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

}
