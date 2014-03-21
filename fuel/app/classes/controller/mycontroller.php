<?php

require_once COREPATH . '../app/classes/facebook/facebook.php';

use \Auth\Auth;
use Fuel\Core\Response;
use Model\Mymodel;

class Controller_Mycontroller extends Fuel\Core\Controller_Template
{

    protected $app_name = 'Fuel Auth App';
    protected $user_id;
    protected $user_info = array();
    protected $fb_instance;
    protected $fb_user;
    private $hasher = null;

    function __construct()
    {
        Config::load('app', true);
        Auth::_init();
        $this->init_fb();
    }

    public function init_auth()
    {
        if (Auth::check()) {
            $auth_id = Auth::get_user_id();
            $this->user_id = $auth_id[1];
            $this->user_info = Mymodel::getUserInfo($this->user_id);
        } else {
            Response::redirect('/auth/login');
        }
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUserInfo()
    {
        return $this->user_info;
    }

    public function init_fb()
    {
        $this->fb_instance = new Facebook(array(
            'appId' => _FB_APP_ID_,
            'secret' => _FB_SECRET_,
        ));

        $this->fb_user = $this->fb_instance->getUser();
    }

    public function getFbUser()
    {
        if (!empty($this->fb_user)) {
            try {
                return $this->fb_instance->api('/me');
            } catch (Exception $e) {
                return FALSE;
            }
        }

        return FALSE;
    }

    public function getFbLoginUrl()
    {
        return $this->fb_instance->getLoginUrl(array('scope' => 'email, read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos'));
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

    public function genCode($code = null)
    {
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
            $email->html_body(\View::forge('email/' . $view, $body));
        } else {
            $email->html_body(\View::forge('email/template', $body));
        }

        try {
            $email->send();
        } catch (\EmailValidationFailedException $e) {
            return FALSE;
        }

        return TRUE;
    }

    public function validate($fields = array())
    {
        $_properties = array(
            'username' => array(
                'fieldname' => 'username',
                'label' => 'User name',
                'rule' => 'trim|required|min_length[6]',
            ),
            'email' => array(
                'fieldname' => 'email',
                'label' => 'Email',
                'rule' => 'trim|required|valid_email',
            ),
            'confirm_email' => array(
                'fieldname' => 'confirm_email',
                'label' => 'Confirm Email',
                'rule' => 'trim|match_field[email]',
            ),
            'password' => array(
                'fieldname' => 'password',
                'label' => 'Password',
                'rule' => 'trim|required|min_length[6]',
            ),
            'confirm_password' => array(
                'fieldname' => 'confirm_password',
                'label' => 'Confirm Password',
                'rule' => 'trim|match_field[password]',
            ),
        );

        if (!empty($fields)) {
            $val = Validation::forge();

            foreach ($fields as $field) {
                $val->add_field($_properties[$field]['fieldname'], $_properties[$field]['label'], $_properties[$field]['rule']);
            }

            if ($val->run()) {
                return array('validated' => TRUE, 'success' => $val->validated());
            } else {
                return array('validated' => FALSE, 'success' => $val->validated(), 'error' => $val->error_message());
            }
        }

        return FALSE;
    }

}
