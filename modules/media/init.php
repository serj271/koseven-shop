<?php defined('SYSPATH') or die('No direct script access.');

Route::set('Media', 'media/(<uid>/)<filepath>', array(
		'filepath' => '.*', // Pattern to match the file path
		'uid' => '[0-9]+',     // Match the unique string that is not part of the media file
	))
	->defaults(array(
		'controller' =>'Media',
		'action'     => 'serve',
//		'uid'	=> NULL
	));
	
	