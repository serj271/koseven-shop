<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'catalog' => array(
		'title' => __('Catalog'),
		'link' => Route::url('modules', array(
			'controller' => 'catalog_category',
		)),
		'sub' => array(),
	),
	'catalog_elements' => array(),
	'nomenclature' => array(),
);