<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'a2' => array(
		'resources' => array(
			'catalog_category_controller' => 'module_controller',
			'catalog_element_controller' => 'module_controller',
			'catalog_search_controller' => 'module_controller',
			'catalog_category' => 'module',
			'catalog_element' => 'module',
		),
		'rules' => array(
			'allow' => array(
				'controller_category_access' => array(
					'role' => 'main',
					'resource' => 'catalog_category_controller',
					'privilege' => 'access',
				),
				'controller_element_access' => array(
					'role' => 'main',
					'resource' => 'catalog_element_controller',
					'privilege' => 'access',
				),
				'controller_search_access' => array(
					'role' => 'main',
					'resource' => 'catalog_search_controller',
					'privilege' => 'access',
				),
				
				'catalog_category_add' => array(
					'role' => 'main',
					'resource' => 'catalog_category',
					'privilege' => 'add',
				),
				'catalog_category_edit' => array(
					'role' => 'main',
					'resource' => 'catalog_category',
					'privilege' => 'edit',
				),
				'catalog_category_fix' => array(
					'role' => 'main',
					'resource' => 'catalog_category',
					'privilege' => 'fix_positions',
				),
				'catalog_category_export' => array(
					'role' => 'main',
					'resource' => 'catalog_category',
					'privilege' => 'export',
				),
				
				'catalog_element_add' => array(
					'role' => 'main',
					'resource' => 'catalog_element',
					'privilege' => 'add',
				),
				'catalog_element_edit' => array(
					'role' => 'main',
					'resource' => 'catalog_element',
					'privilege' => 'edit',
				),
			),
		)
	),
);