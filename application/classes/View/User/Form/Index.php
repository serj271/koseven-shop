<?php

class View_User_Form_Index
{

    public $results;
 
 	public $values = array();
	
	public $usernameError;
	public $errors;

	public function values()
	{
		return array('token' => Security::token()) + $this->values;
	}
 
   
}