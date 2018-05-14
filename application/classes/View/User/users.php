<?php

class View_User_Users
{
	public $values = array();
#    public $labelUsername;
    public $username;
    public $password;

	public function values()
	{
		return array('token' => Security::token()) + $this->values;
	}

/*    
    public function bolder()
    {
	return function($text, $renderer)	
	{
//	    Log::instance()->add(Log::NOTICE, Debug::vars($renderer));
	    return '<b>'.call_user_func($renderer, $text).'</b>';		
	};    
    }
*/
    public function colors()
    {
	return array('red','blue','green');
    }

    public function linkUser()
    {
	return function($text)
	{
//	    return "<a href='#'>".$text."</a>";
	    return HTML::anchor('personalviewerproperty/id/'.$text, $text);
	};
    
    }
    
    public function name()
    {
	return function($text)
	{
	    return '<span>'.$text.'</span>';
	};
    
    }

   
}