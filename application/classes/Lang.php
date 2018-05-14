<?php defined('SYSPATH') OR die('No direct script access.');

class Lang {
	/** Config */
	private $_config;

	/** Cached info message */
	private $info;

	/** Cached error message */
	private $error;

	public function __construct() {
		$this->_config = Kohana::$config->load('flag');
//		Log::instance()->add(Log::NOTICE, Debug::vars($this->_config));
//		Kohana::$log->add(Debug::vars($username), 'Message class instantiated.');
	}

	public static function instance() {
		static $instance;
		if ( ! isset($instance))
		{
			$instance = new Lang;
		}
		return $instance;
	}

	public function set($lang='en-us') {
		$session = Session::instance($this->_config['session_type']);
		$session->set('lang', $lang);
	}

	public function get() {
			$session = Session::instance($this->_config['session_type']);
			$lang = $session->get('lang', FALSE);
			if ($lang == FALSE)
			{
			    $lang = 'ru';
			}
			return $lang;		
	}




}

