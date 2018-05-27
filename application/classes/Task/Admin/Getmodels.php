<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Admin_Getmodels extends Minion_Task {

	protected function _execute(array $params)
	{
		$db = Database::instance();

		// Get the table name from the ORM model
#		$table_name = ORM::factory('datalog')->table_name();
		/* Message::set(Message::ERROR, 'test error');
		$messages = Message::get();
//		Log::instance()->add(Log::NOTICE, Debug::vars($messages));
		$errors = $messages['error'];
		foreach($errors as $error){
			Minion_CLI::write($error);	
		} */
		$model_directory = APPPATH.'classes/Model';
		$scan_result = scandir( $model_directory );
			
			
//		Minion_CLI::write('ok'.$model_directory);
//		Log::instance()->add(Log::NOTICE, Debug::vars($this->dirToArray($model_directory)));
		$views = Kohana::list_files('classes/Model');
//		Log::instance()->add(Log::NOTICE, Debug::vars(strncmp('jome','//',2)));
//		Log::instance()->add(Log::NOTICE, Debug::vars($views));
		$models = Kohana::$config->load('adminmodel.models');
		Log::instance()->add(Log::NOTICE, Debug::vars($models));
	}
	protected function dirToArray($dir) { 
	   
	   $result = array(); 

	   $cdir = scandir($dir); 
	   foreach ($cdir as $key => $value) 
	   { 
		  if (!in_array($value,array(".",".."))) 
		  { 
			 if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
			 { 
				$result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
			 } 
			 else 
			 { 
				$result[] = $value; 
			 } 
		  } 
	   } 
	   
	   return $result; 
	} 
}
