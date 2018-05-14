<?php defined('SYSPATH') or die('No direct script access.');
/** 
 * Login view model
 */
class View_User_Auth_Login {
	
	/**
	 * @var	array
	 */
	public $errors;

	/**
	 * @var	array
	 */
	public $values = array();

	/**
	 * @return	array	Values with CSRF token included
	 */
	public function values()
	{
		return array('token' => Security::token()) + $this->values;
	}
	
	public function charset(){
	    return 'utf-8';
	}

}
