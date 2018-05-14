<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Sessions extends Minion_Task {

	protected function _execute(array $params)
	{
		$db = Database::instance();

		// Get the table name from the ORM model
#		$table_name = ORM::factory('datalog')->table_name();

		// Create the base table

		// Change the row identifier,
		// because '_id' is meant to only be used for foreign keys
#		$datalog_cols = $db->list_columns($db->table_prefix().$table_name);
#		if (isset($datalog_cols['row_id']))
#		{
		$session = Session::instance();
				
		// Set session 
		$key = 'user_id';
		$value = 'username';
		$session->set($key, $value);
		$user = $session->get('user_id');
	
			Minion_CLI::write('Session connect '.$user);
			Minion_CLI::write('Session default type - '.Session::$default); 
#			Log::instance()->add(Log::NOTICE, Debug::vars(Kohana::$config->load('cart')->as_array()));
#			$sql = "ALTER TABLE ".$db->quote_table($table_name)."
#				CHANGE COLUMN ".$db->quote_column('row_id')."
#				".$db->quote_column('row_pk')." INT(12) NOT NULL";
#			$db->query(NULL, $sql);
#		}

	}

}
