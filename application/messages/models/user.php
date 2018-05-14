<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'username' =>array
    (	
//	'not_empty'=>'NOT'
	'not_empty'     => ':field поле не должно быть пустым',	
    ),
    'password_confirm' => array(
	'matches' => 'The password fields did not match.',
    ),
    'password'=>array(
	'not_empty' => ':field поле пустое '
    ),
);
