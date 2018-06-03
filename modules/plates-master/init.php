<?php defined('SYSPATH') OR die('No direct access allowed.');

define('PLATES_PATH', realpath(__DIR__.DIRECTORY_SEPARATOR.'src').DIRECTORY_SEPARATOR);

/**
 * Test route
Route::set('jade-test', 'jadetest')
	->defaults(array(
		'directory' => 'Jade',
		'controller' => 'Test',
		'action' => 'index'
	));
 */

spl_autoload_register(function($class){
	Kohana::auto_load($class, 'src');
}, false);

//include Kohana::find_file('vendor', 'mustache/src/Mustache/Autoloader');
//Mustache_Autoloader::register();

//require('vendor/autoload.php');

