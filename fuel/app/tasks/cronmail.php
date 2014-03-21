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

use Controller_Mycontroller;
use Model\Mymodel;

class Cronmail
{

    public static function run()
    {
        $subject = "Fuel App - Cron Mail";

        $my_controller = new \Controller_Mycontroller();

        $cron_config = \Fuel\Core\Config::get('app.cronmail');
        $today = date('D');
        $hobby_ids = $cron_config[$today];
        if (!empty($hobby_ids)) {
            if ($data = Mymodel::getUsersCronmail($hobby_ids)) {
                foreach ($data as $value) {
                    $my_controller->sendmail($value['email'], $subject, $value, $view = 'cronmail');
                }
            }
        }
    }

}
