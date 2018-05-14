<?php defined('SYSPATH') or die('No direct script access.');

class View_User_Main_Index {



    public function message(){
	return 'Hello!';	

    }   


	public function buttons()
	{
		return array(
			array(
				'class' => 'large',
				'text' => 'Logout',
				'url' => Route::url('user', array(
					'directory' =>'user',
					'controller' => 'auth',
					'action' 		=> 'logout',
//					'id'		=> Security::token()
				)),
			),
		);
	}













	
}
