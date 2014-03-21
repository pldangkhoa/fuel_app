<?php

namespace Model;

use Fuel\Core\DB;
use Model\Users;
use Model\Genders;
use Model\Hobbies;
use Model\Userhobby;
use Model\Comments;

class Mymodel
{

    public static function getUserInfo($user_id = null)
    {
        if ($user_id) {
            if ($user = Users::getUserById($user_id)) {
                if ($hobbies = Userhobby::getHobbyIdsByUserId($user_id)) {
                    foreach ($hobbies as $value) {
                        $user['hobbies'][] = $value['hobby_id'];
                    }
                }

                return $user;
            }
        }

        return FALSE;
    }

    public static function editUserInfo($user_id = null, $user_data = array(), $hobbies = array())
    {
        $data = array();
        if ($user_id && !empty($user_data)) {
            if (Users::updateUser($user_id, $user_data)) {
                if (!empty($hobbies)) {
                    foreach ($hobbies as $hobby) {
                        $data['hobbies'][] = array($user_id, $hobby);
                    }
                    UserHobby::deleteByUserId($user_id);
                    UserHobby::insertByUserId($user_id, $data['hobbies']);
                } else {
                    UserHobby::deleteByUserId($user_id);
                }

                return TRUE;
            }
        }

        return FALSE;
    }

    public static function getHobbiesName($hobby_ids = array())
    {
        $data = array();
        if (!empty($hobby_ids)) {
            if ($hobbies = Hobbies::getHobbiesNameByIds($hobby_ids)) {
                foreach ($hobbies as $hobby) {
                    $data[] = $hobby['name'];
                }
                return implode(', ', $data);
            }
        }

        return FALSE;
    }

    public static function getUsersCronmail($hobby_ids = array())
    {
        if (!empty($hobby_ids)) {
            if ($hobby_name = Mymodel::getHobbiesName($hobby_ids)) {
                if ($user_ids = Userhobby::getUserIdsByHobbyIds($hobby_ids)) {
                    foreach ($user_ids as $value) {
                        $ids[] = $value['user_id'];
                    }
                    if ($data = Users::getUsersByUserIdsAndCronmail($ids)) {
                        foreach ($data as $key => $value) {
                            $data[$key]['hobbies'] = $hobby_name;
                        }

                        return $data;
                    }
                }
            }
        }

        return FALSE;
    }

}
