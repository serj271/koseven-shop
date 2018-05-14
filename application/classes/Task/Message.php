<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Message extends Minion_Task {

	protected function _execute(array $params)
	{
		$db = Database::instance();

		// Get the table name from the ORM model
#		$table_name = ORM::factory('datalog')->table_name();
		Message::set(Message::ERROR, 'test error');
		$messages = Message::get();
//		Log::instance()->add(Log::NOTICE, Debug::vars($messages));
		$errors = $messages['error'];
		foreach($errors as $error){
			Minion_CLI::write($error);	
		}
			
		

	}

}
