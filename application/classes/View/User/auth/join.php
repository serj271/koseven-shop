<?php defined('SYSPATH') or die('No direct script access.');
/** 
 * Login view model
 */
class View_User_Auth_Join {
	
	/**
	 * @var	array
	 */
	public $errors;

	/**
	 * @var	array
	 */
	public $values = array();

	public $captcha_image;
	/**
	 * @return	array	Values with CSRF token included
	 */
	public function values()
	{
		return array('token' => Security::token()) + $this->values;
	}
//	public function action()
//	{
//		return $this->request->controller()
//	}	
	public function labelUsername(){
	    return __('Username');
	
	}

	public function labelEmail(){
	    return 'Email';
	
	}


	public function labelPassword(){
	    return __('Password');
	
	}

	public function labelConfirm(){
	    return __('Password repeat');
	
	}


	public function labelSubmit(){
	    return 'Join';
	
	}

	public function confirm(){
//	    return Arr::path($values, '_external.password_confirm');
	}

	public function passwordConfirm(){
	    return Arr::path($this->errors, '_external.password_confirm');	
	}
	
//	public function captchaWidth(){
//		return '11';
//	}
	
	public function captcha(){		
		return function($text) {
//			Log::instance()->add(Log::NOTICE, Debug::vars($text));
			return "<img src=".URL::site('captcha/'.Captcha::$config['group'])." width=".Captcha::$config['width']." height=".Captcha::$config['height']." class='aptcha' / >";
		};
	}
	
	public function labelCaptcha(){
		return __("Captcha");
	} 
	
}


