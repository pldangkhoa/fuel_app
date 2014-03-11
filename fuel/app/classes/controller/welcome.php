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

use \Model\comments;
use \Model\users;

class Controller_Welcome extends Controller_Mycontroller
{

	public function action_index()
	{
		$ret = Comments::getAllComments();
		
		var_dump($ret);
		//return Response::forge(View::forge('welcome/index'));
	}
	
	
}
