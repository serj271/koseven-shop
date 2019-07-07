<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Auth_User {
//    protected $username;

    public function types(){
		return array(
#			'enterprise'=>'select',
			'email'=>'text',
			'username'=>'text',
			'password'=>'text',			
		);
    }
    public function controls(){
	    return array(
			'username'=>'',
			'email'=>'',
			'password'=>'',			
	    );    
    }



} // End User Model