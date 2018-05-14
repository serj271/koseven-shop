<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Db_Create extends Minion_Task {

	protected function _execute(array $params)
	{
		$db = Database::instance();

		Minion_CLI::write('DB connect');
		$config = Kohana::$config->load('database');
		$host = $config['default']['connection']['host'];
		$username = $config['default']['connection']['username'];
		$database = $config['default']['connection']['database'];
		$password = '123456s';
		
/* 
		$host = "localhost";
		$username = "username";
		$password = "password"; */

		// Create connection
		$conn = new mysqli($host, $username, $password);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		// Create database
		$sql = "CREATE DATABASE $database";
		if ($conn->query($sql) === TRUE) {
			echo "Database created successfully";
			Minion_CLI::write("Database created successfully");
		} else {
			echo "Error creating database: " . $conn->error;
			Minion_CLI::write("Error creating database: " . $conn->error);
		}

$conn->close();
		
		Minion_CLI::write('DB host - '.$host);
	}

}
