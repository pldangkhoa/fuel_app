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
		$data = Comments::getAllComments();
		
		var_dump($data);
		
		$this->template->title = 'mypage';
		$this->template->content = View::forge('mypage', $data);
		
		
	}
	
	
}
