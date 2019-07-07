<?php defined('SYSPATH') or die('No direct script access.');

class Task_User_Authuser extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'name'   => '',
		'password'=>''
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
		if($params['name'] && $params['password']){
			$user = ORM::factory('User')
				->where('username','=',$params['name'])
				->find();
			$id = $user->id;
			if($id){			
				$success = Auth::instance()->login($params['name'],$params['password'], TRUE);
				if($success){
					Minion_CLI::write('user name login success--');
				} else {
					Minion_CLI::write('user name login false--');
				}
			} else {
				Minion_CLI::write('not user');
			}
	//		$users = $model_user->find_all();
	//		$success = Auth::instance()->login('test@test.ru','1', TRUE);
	//		foreach($users as $user){
	//			$success = $this->getAuth($user->username,'1');
	//			Minion_CLI::write('user name --'.$user->username.$success );
	//			Log::instance()->add(Log::NOTICE , Debug::vars($model->has('roles',array(1))));
	//			$model->has('roles',array(1));
	//			Auth::instance()->logout('test@test.ru');
	//			var_dump($user);
	//		}		
	//		Log::instance()->add(Log::NOTICE , Debug::vars(count(ORM::factory('Role',['name'=>'login'])->find_all())));
		}else {
			Minion_CLI::write('require name password user --name=?');
		}
	}
	

} // End Welcome
//  ./minion --help --task=authtest