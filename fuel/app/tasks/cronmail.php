<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Tasks;
use \Model\users;
use \Model\hobbies;

class Cronmail
{

	public static function run()
	{
		$my_controller = new \Controller_Mycontroller();
		
		$users = Users::getUserCronmail();
		if ($users) {
			$subject = "Fuel App - Cron Mail";
			foreach ($users as $user) {
				if (!empty($user['hobbies'])) {
					$user['hobbies'] = implode(', ', Hobbies::getHobbiesByIds($user['hobbies']));
				}
				
				$to = $user['email'];
				$body = $user;
				$my_controller->sendmail($to, $subject, $body, $view = 'cronmail');
			}
		}
	}
}

