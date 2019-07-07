<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'username' =>array
    (	
//	'not_empty'=>'NOT'
	'not_empty'     => ':field pole require',	
    ),
    'password_confirm' => array(
	'matches' => 'The password fields did not match.',
    ),
    'password'=>array(
	'not_empty' => ':field pole is empty'
    ),
);
