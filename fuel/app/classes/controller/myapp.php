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

class Controller_Myapp extends Controller_Mycontroller
{

	public function __construct()
	{
		if (!Auth::check()) {
			Response::redirect('/auth/login');
		}
	}

	public function action_index()
	{
		$data = array();
		
		$data['app_name'] = $this->app_name;
		$user_id = Auth::get_user_id();
		
		//get user info
		$data['user_info'] = Users::getUserById($user_id[1]);
		
		
		$data['comments'] = Comments::getCommentsByOffset();
		$data['offset'] = count($data['comments']);
		
		$this->template->title = 'myapp';
		$this->template->content = View::forge('myapp/index', $data);
	}
	
	public function action_addComment()
	{
		$data = array();
		
		$user_id = Auth::get_user_id();
		
		if (Input::method() == 'POST') {
			$val = Validation::forge();
			$val->add_field('comment', 'Comment', 'trim|required');
			
			if ($val -> run()) {
				Comments::addComment($user_id[1], Input::post('comment'));
			} else {
				//$form->validation()->error();
			}
		}
		
		$data['comments'] = Comments::getCommentsByOffset();
		$data['offset'] = count($data['comments']);
		
		return new Response(View::forge('myapp/comment', $data));
	}
	
	public function action_loadComment()
	{
		$data = array();
		
		if (Input::method() == 'POST') {
			$val = Validation::forge();
			$val->add_field('offset', 'Offset', 'trim|required');
			
			if ($val -> run()) {
				$data['comments'] = Comments::getCommentsByOffset(2, Input::post('offset'));
				$data['offset'] = count($data['comments']) + Input::post('offset');
			} else {
				//$form->validation()->error();
			}
		}
		
	//	$data['comments'] = Comments::getCommentsByOffset(10, Input::post('offset'));
		
		return new Response(View::forge('myapp/comment', $data));
	}
}
