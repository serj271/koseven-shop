<?php defined('SYSPATH') or die('No direct script access.');

class Task_User_Createuser extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'username'=>'',
		'password'=>''
	);

	protected function _execute(array $params)
	{
		if($params['username'] && $params['password']){
			$user = ORM::factory('User',array('username'=>$params['username']));		
			$id = $user->id;
			if($id){				
				Minion_CLI::write('user exists id -'.$id);
			} else {
				$user = ORM::factory('User');					
						$user->username = $params['username'];
						$user->email = $params['username'].'@test.ru';
						$user->password = $params['password'];
						$code = md5(uniqid(rand(),true));
						$code = substr($code,0,64);	    
						$user->one_password = $code;
						$user->save();					
				$user->add('roles', ORM::factory('Role', array('name' => 'login')));
	//	###		$users = implode(',',$this->getUsers());
		//		$success = $this->getAuth();			
				Minion_CLI::write('create '.$params['username'].' id --'.$user->id);			
			}
		} else {
			Minion_CLI::write('username  password required');
		}
		
	}
} // End Welcome
//  ./minion --help --task=createuser