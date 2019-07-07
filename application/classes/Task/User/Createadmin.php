<?php defined('SYSPATH') or die('No direct script access.');

class Task_User_Createadmin extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);

	protected function _execute(array $params)
	{
		$user = ORM::factory('User',array('username'=>'test'));		
		$id = $user->id;
		if($id){				
#			$user = ORM::factory('user');					
#					$user->username = 'test';
#					$user->email = 'test@test.ru';
#					$user->password = 1;	
#					$user->id_listing = '0007606';
#					$code = md5(uniqid(rand(),true));
#					$code = substr($code,0,64);	    
#					$user->one_password = $code;
#					$user->save();					
			$user->add('roles', ORM::factory('Role', array('name' => 'admin')));
#	###		$users = implode(',',$this->getUsers());
	//		$success = $this->getAuth();			
			Minion_CLI::write('admin role test id --'.$user->id);			
		}
	}
} // End 
//  ./minion --help --task=createadmin