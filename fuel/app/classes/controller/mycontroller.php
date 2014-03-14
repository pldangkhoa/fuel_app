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

class Controller_Mycontroller extends Controller_Template
{
	protected $app_name = 'Fuel Auth App';
	private $hasher = null;
	
	function __construct() {
		Auth::_init();
	}
	
	/**
	 * Default password hash method
	 *
	 * @param   string
	 * @return  string
	 */
	public function hash_password($password)
	{
		return base64_encode($this->hasher()->pbkdf2($password, \Config::get('auth.salt'), \Config::get('auth.iterations', 10000), 32));
	}

	/**
	 * Returns the hash object and creates it if necessary
	 *
	 * @return  PHPSecLib\Crypt_Hash
	 */
	public function hasher()
	{
		is_null($this->hasher) and $this->hasher = new \PHPSecLib\Crypt_Hash();

		return $this->hasher;
	}
	
	public function genCode($code = null) {
		if ($code) {
			return md5($code . \Config::get('auth.salt') . uniqid() . time());
		} else {
			return md5(\Config::get('auth.salt') . uniqid() . time());
		}
	}
	
	public function sendmail($from, $to, $subject, $body, $view = null)
	{
		$email = Email::forge();
		$email->from($from);
		$email->to($to);
		$email->subject($subject);
		
		if ($view) {
			$email->html_body(\View::forge('email/'.$view, $body));
		} else {
			$email->html_body(\View::forge('email/template', $body));
		}
		
		try {
			$email->send();
		} catch(\EmailValidationFailedException $e) {
		    return false;
		}
		
		return true;
	}
}
