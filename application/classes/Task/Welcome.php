<?php defined('SYSPATH') or die('No direct script access.');

class Task_Welcome extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);
	protected function _execute(array $params)
	{
		Minion_CLI::write('hello '.$params['foo'].' world!'.Request::$client_ip);
		Log::instance()->add(Log::NOTICE, Debug::vars(Security::token(),Security::check(Security::token())));
	}

} // End Welcome
//  ./minion --help --task=welcome