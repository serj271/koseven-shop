<?php defined('SYSPATH') or die('No direct script access.');

class Task_User_Addlogin extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
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
			$success = $model->has('roles',array(1));
			if($success){
				Minion_CLI::write('has roles login');
			} else {
				Minion_CLI::write('not has roles login');
				if($model->loaded()){
					$model->add('roles', ORM::factory('Role', array('name' => 'login')));
					Minion_CLI::write('roles added');
				} else {
					Minion_CLI::write('not exists user');
				}
				
			}
		} else {
			Minion_CLI::write('describe id user --id=?');
		}
//		
//		$users = $model_user->find_all();
//		$success = Auth::instance()->login('test@test.ru','1', TRUE);
//		foreach($users as $user){
//			$success = $this->getAuth($user->username,'1');
//			Minion_CLI::write('user name --'.$user->username.$success );
	//		Log::instance()->add(Log::NOTICE , Debug::vars($model->has('roles',array(1))));
//			Minion_CLI::write($params['id']);
//			$model->has('roles',array(1));
//			Auth::instance()->logout('test@test.ru');
//			var_dump($user);
//		}		
//		Log::instance()->add(Log::NOTICE , Debug::vars(count(ORM::factory('Role',['name'=>'login'])->find_all())));
	}
	

} // End Welcome
//  ./minion --help --task=authtest --id=