<?php defined('SYSPATH') or die('No direct script access.');

class Task_User_Getall extends Minion_Task {

	protected $_options = array(
		// param name => default value
				
	);

	protected function _execute(array $params)
	{
		
		$model = ORM::factory('User');
			
		$users = $model->find_all();
//		Log::instance()->add(Log::NOTICE, Debug::vars($users));
		
		if(count($users)>0){				
			foreach($users as $user){
				
				Minion_CLI::write('user  id '.$user->id.' username '.$user->username);
				$roles = $user->roles->find_all();
				foreach($roles as $role){
					Minion_CLI::write('role '.$role->name);
				}
			}
		} else {
			Minion_CLI::write('users not found  ');	
		}	
		
	}
}
//end Task_User_Getuser
//  ./minion --help --task=getuser --username=___