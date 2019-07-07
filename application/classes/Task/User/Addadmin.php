<?php defined('SYSPATH') or die('No direct script access.');

class Task_User_Addadmin extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'id'=>''
	);	
	
	protected function getAuth($name = '', $password)
	{
		$success = Auth::instance()->login($name, $password, TRUE);
		if($success){
			return 'ok'; 
		} else {
			return 'fail';
		}		
	}
	
	protected function _execute(array $params)
	{		
		if($params['id']){
			Minion_CLI::write('id user -  '.$params['id']);
			$model = ORM::factory('User',$params['id']);
			$success = $model->has('roles',array(2));
			if($success){
				Minion_CLI::write('has roles admin');
			} else {
				Minion_CLI::write('not has roles admin');
				if($model->loaded()){
					$model->add('roles', ORM::factory('Role', array('name' => 'admin')));
					Minion_CLI::write('roles added admin');
				} else {
					Minion_CLI::write('not exists user');
				}				
			}
		} else {
			Minion_CLI::write('require id user --id=?');
		}
	}
	

} // End Welcome
//  ./minion --help --task=authtest --id=