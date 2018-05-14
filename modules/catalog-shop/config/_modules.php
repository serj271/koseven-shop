<?php defined('SYSPATH') or die('No direct access allowed.');

$module_type = (Kohana::$config->load('catalog.mode') == 'page' ? Helper_Module::MODULE_SINGLE : Helper_Module::MODULE_HIDDEN);

return array
(
	'catalog' => array(
		'alias' => 'greor-catalog',
		'name' => 'Catalog module',
		'type' => $module_type,
		'controller' => 'catalog_category'
	),
);