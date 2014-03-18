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

require_once COREPATH . '../app/classes/facebook/facebook.php';

class Controller_Mycontroller extends Controller_Template
{
	protected $app_name = 'Fuel Auth App';
	private $hasher = null;
	protected $fb_instance;
	protected $fb_user;
	
	function __construct() {
		Auth::_init();
		$this->init_fb();
		View::set_global('base_url',  'http://'.$_SERVER['HTTP_HOST']);
	}

	public function init_fb()
	{
		$this->fb_instance = new Facebook(array(
			'appId'  => _FB_APP_ID_,
			'secret' => _FB_SECRET_,
		));
		
		$this->fb_user = $this->fb_instance->getUser();
	}

	public function getFbUser()
	{
		if ( ! empty($this->fb_user)) {
			try {
				return $this->fb_instance->api('/me');
			} catch (Exception $e) {
				return false;
			}	
		}
		
		return false;
	}

	public function getFbLoginUrl()
	{
		return $this->fb_instance->getLoginUrl(array( 'scope' => 'email, read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos'));
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
	
	public function sendmail($to, $subject, $body, $view = null)
	{
		$email = Email::forge();
		$email->from(_MAIL_FROM_);
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
