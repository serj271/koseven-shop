<?php defined('SYSPATH') or die('No direct script access.');

$module_type = Kohana::$config->load('catalog.mode');

if ($module_type == 'page') {
	$config = array (
		'catalog_element' => array(
			'uri_callback' => '/<element_uri>-<element_id>.html(?<query>)',
			'regex' => array(
				'element_uri' => '[^/.,;?\n]+',
				'element_id' => '[0-9]++'
			),
			'defaults' => array(
				'directory' => 'modules',
				'controller' => 'catalog',
				'action' => 'detail',
			)
		),
		'catalog' => array(
			'uri_callback' => array('Helper_Catalog', 'route'),
			'regex' => '(/<category_uri>)(?<query>)',
			'defaults' => array(
				'directory' => 'modules',
				'controller' => 'catalog',
				'action' => 'index',
			)
		),
	);
} else {
	$config = array (
		'catalog_element' => array(
			'uri_callback' => 'catalog/element(/<element_uri>)',
			'regex' => array(
				'element_uri' => '[^/.,;?\n]+',
#				'element_uri' => '[0-9]+',
#				'element_id' => '[0-9]+'
			),
			'defaults' => array(
				'directory'=>'catalog',
				'controller' => 'element',
				'action' => 'index'
			)
		),
		'catalog' => array(
			'uri_callback' => array('Helper_Catalog', 'route_root'),
			'regex' => 'catalog/<category_uri>(?<query>)',
			'defaults' => array(
//				'directory' => 'admin/modules/catalog',
				'directory' => 'catalog',
				'controller' => 'category',
				'action' => 'index',
			)
		),
	);
}

return $config;
