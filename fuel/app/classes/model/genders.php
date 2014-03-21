<?php

namespace Model;

use Fuel\Core\DB;

class Genders extends \Fuel\Core\Model_Crud
{

    protected static $_table_name = 'genders';

    public static function getGenderById($id)
    {
        if ($id) {
            try {
                return DB::select('name')->from(static::$_table_name)->where('id', $id)->execute()->as_array();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

    public static function getAllGenders()
    {
        try {
            return DB::select()->from(static::$_table_name)->execute()->as_array();
        } catch (Exception $exc) {
            return FALSE;
        }

        return FALSE;
    }

    public static function getIdByName($name = null)
    {
        if ($name) {
            try {
                return DB::select('id')->from(static::$_table_name)->where('name', '=', $name)->execute()->as_array();
            } catch (Exception $exc) {
                return false;
            }
        }

        return FALSE;
    }

}
