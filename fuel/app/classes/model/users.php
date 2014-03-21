<?php

namespace Model;

use Fuel\Core\DB;

class Users extends \Fuel\Core\Model_Crud
{

    protected static $_table_name = 'users';

    public static function insertUser($data = null)
    {
        if ($data) {
            list($insert_id, $rows_affected) = DB::insert(static::$_table_name)
                            ->set(array('email' => $data['email'],
                                'password' => $data['password'],
                                'username' => $data['username'],
                                'gender' => $data['gender'],
                                'group' => 2,
                                'last_login' => 0,
                                'login_hash' => '',
                                'created_at' => \Date::forge()->get_timestamp(),
                                'auth_code' => $data['auth_code']
                            ))->execute();
            if ($rows_affected != 0) {
                return $insert_id;
            }
        }

        return FALSE;
    }

    public static function checkInValidEmail($email = null)
    {
        if ($email) {
            $result = DB::select()->from(static::$_table_name)->where('email', '=', $email)->execute();

            if ($result->count() <= 0) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public static function editUser($user_id = null, $data = null)
    {
        if ($user_id && $data) {
            try {
                return DB::update(static::$_table_name)->set($data)->where('id', $user_id)->execute();
            } catch (Exception $exc) {
                return FALSE;
            }
        }
        return FALSE;
    }

    public static function updateUser($user_id = null, $data = null)
    {
        if ($user_id && $data) {
            try {
                return DB::update(static::$_table_name)->set($data)->where('id', $user_id)->execute();
            } catch (Exception $exc) {
                return FALSE;
            }
        }
        return FALSE;
    }

    public static function getUserById($user_id)
    {
        if ($user_id) {
            $result = DB::select('*')->from(static::$_table_name)->where('id', $user_id)->execute()->as_array();

            if ($result) {
                //         $result[0]['hobbies'] = json_decode($result[0]['hobbies']);
                return $result[0];
            }
        }

        return FALSE;
    }

    public static function updatePassword($user_id = null, $old_password = null, $new_password = null)
    {
        if ($user_id && $old_password && $new_password) {

            if (Users::checkPassword($user_id, $old_password)) {
                try {
                    return DB::update(static::$_table_name)->value('password', $new_password)->where('id', '=', $user_id)->execute();
                } catch (Exception $exc) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    public static function checkPassword($user_id = null, $password = null)
    {
        if ($user_id && $password) {
            try {
                return DB::select('id')->from(static::$_table_name)->where('id', $user_id)->and_where('password', $password)->execute();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

    public static function updateEmail($user_id = null, $email = null)
    {
        if ($user_id && $email) {
            try {
                return DB::update(static::$_table_name)->value('email', $email)->where('id', '=', $user_id)->execute();
            } catch (Exception $exc) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public static function checkEmail($user_id = null, $email = null)
    {
        if ($user_id && $email) {
            try {
                return DB::select('id')->from(static::$_table_name)->where('id', $user_id)->and_where('email', $email)->execute();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

    public static function getEmailByUserId($user_id = null)
    {
        if ($user_id) {
            try {
                return DB::select('email')->from(static::$_table_name)->where('id', $user_id)->execute()->as_array();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

    public static function getEmailsByUserIds($user_ids = array())
    {
        if (!empty($user_ids)) {
            try {
                return DB::select('email')->from(static::$_table_name)->where('id', 'in', (array) $user_ids)->execute()->as_array();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

    public static function getUsersByUserIdsAndCronmail($user_ids = array())
    {
        if (!empty($user_ids)) {
            try {
                return DB::select_array(array('username', 'email'))->from(static::$_table_name)->where('id', 'in', (array) $user_ids)->and_where('cronmail', 1)->execute()->as_array();
            } catch (Exception $exc) {
                return FALSE;
            }
        }

        return FALSE;
    }

}
