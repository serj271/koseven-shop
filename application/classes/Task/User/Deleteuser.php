<?php defined('SYSPATH') or die('No direct script access.');

class Task_User_Deleteuser extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'id'   => '',
	);

	protected function _execute(array $params)
	{
		if($params['id']){
			$user = ORM::factory('User',$params['id']);		
			$id = $user->id;
			if($id){			
				$user->delete();
				Minion_CLI::write('delete user id -'.$id.'- to delete');
			} else {
				Minion_CLI::write('not user');
			}
			
	###		$users = implode(',',$this->getUsers());
	//		$success = $this->getAuth();
	//		$user = ORM::factory('user',array('username'=>'test'));		
		}else {
			Minion_CLI::write('require id user --id=?');
		}
	}

} // End Welcome
//  ./minion --help