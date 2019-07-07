<?php defined('SYSPATH') or die('No direct script access.');

class Task_User_Getuser extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'username'=>''		
	);

	protected function _execute(array $params)
	{
		if($params['username']){
			$model = ORM::factory('User')
				->where('username','=',$params['username']);
			$user = $model->find();
			if($user->loaded()){
				Minion_CLI::write('find user '.$params['username'].' id --'.$user->id);
				$roles = $user->roles->find_all();
				foreach($roles as $role){
					Minion_CLI::write('role '.$role->name);
				}
			} else {
				Minion_CLI::write('user not found  '.$params['username']);	
			}	
		} else {
			Minion_CLI::write('username required');
		}
		
	}
}
//end Task_User_Getuser
//  ./minion --help --task=getuser --username=___