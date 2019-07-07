<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'default' => array(
		'type'       => 'MySQLi',
//		'type'       => 'PDO',
		'connection' => array(
			/**
			 * The following options are available for PDO:
			 *
			 * string   dsn         Data Source Name
			 * string   username    database username
			 * string   password    database password
			 * boolean  persistent  use persistent connections?
			 */
			'host'       => 'localhost',
			'username'   => 'user_db',
			'password'   => '123456s',
//			'password'   => 'H1x1P2k4', 			
			'database'   => 'koseven_shop',
			'persistent' => FALSE,
			'port'       => NULL,
			'socket'     => NULL,
			'params'     => NULL,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
	'pdo' => array(
//		'type'       => 'MySQLi',
		'type'       => 'PDO',
		'connection' => array(
			/**
			 * The following options are available for PDO:
			 *
			 * string   dsn         Data Source Name
			 * string   username    database username
			 * string   password    database password
			 * boolean  persistent  use persistent connections?
			 */
			'host'       => 'localhost',
			'username'   => 'user_db',
			'password'   => '123456s',
			'database'   => 'koseven_shop',
			'persistent' => FALSE,
			'port'       => NULL,
			'socket'     => NULL,
			'params'     => NULL,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),	
);