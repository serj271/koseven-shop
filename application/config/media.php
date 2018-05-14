<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'styles' => array(
        'directory'       => DOCROOT.'media/css/',
        'extension'       => 'css',
    ),
    'scripts' => array(
        'directory'       => 'js/',
        'extension'       => 'js',
    ),
    'images' => array(
        'directory'       => DOCROOT.'media/img/',
        'extension'       => array('png', 'jpg', 'jpeg', 'gif', 'ico', 'svg'),
    ),
);