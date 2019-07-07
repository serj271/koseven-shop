<?php

class View_User_Parse_Upload
{

    public $results;
 
 	public $values = array();
	
	public $usernameError;
	public $errors;

	public function values()
	{
		return array('token' => Security::token()) + $this->values;
	}
 
	public function action(){
		return 'upload';
	}
}