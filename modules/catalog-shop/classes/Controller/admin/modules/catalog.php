<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Modules_Catalog extends Controller_Admin_Front {

	protected $top_menu_item = 'modules';
	protected $sub_title = 'Catalog';
	protected $category_id;
	protected $module_config = 'catalog';
	protected $_controller_name = array(
		'category' => 'catalog_category',
		'element' => 'catalog_element',
		'search' => 'catalog_search',
	);
	protected $is_initial;
	
	protected $injectors = array(
		'nomenclature' => array('Injector_Nomenclature')
	);
	
	public function before()
	{
		parent::before();
		
		$request = $this->request->current();
		
		$this->category_id = (int) $request->query('category');
		$this->template
			->bind_global('CATALOG_CATEGORY_ID', $this->category_id);
		
		$query_controller = $request->query('controller');
		if ( ! empty($query_controller) AND is_array($query_controller)) {
			$this->_controller_name = $this->request->query('controller');
		}
		$this->template
			->bind_global('CONTROLLER_NAME', $this->_controller_name);
		
		$this->is_initial = $request->is_initial();
	}

	protected function layout_aside()
	{
		$menu_items = array_merge_recursive(
			Kohana::$config->load('admin/aside/catalog')->as_array(),
			$this->menu_left_ext
		);
	
		return parent::layout_aside()
			->set('menu_items', $menu_items)
			->set('replace', array(
				'{CATEGORY_ID}' =>	$this->category_id,
			));
	}

	
	protected function _get_categories_list()
	{
		$categories_db = ORM::factory('Catalog_Category')
			->order_by('category_id', 'asc')
			->order_by('position', 'asc')
			->find_all();
		
		$categories = array();
		foreach ($categories_db as $_item) {
			$_key = $_item->id;
			if ($_item->category_id == 0) {
				$categories[$_key] = array(
					'id' => $_key,
					'title' => $_item->title,
					'level' => 0,
					'children' => array(),
				);
			} elseif (array_key_exists($_item->category_id, $categories)) {
				$_parent = & $categories[$_item->category_id];
				
				$_parent['children'][$_key] = array(
					'id' => $_key,
					'title' => $_item->title,
					'level' => $_parent['level'] + 1,
					'children' => array(),
				);
				unset($_parent);
			}
		}
			
		return $this->_print_list($categories);
	}
	
	protected function _print_list($categories) {
		$return = array();
		foreach ($categories as $item) {
			$_title = str_repeat('&mdash;', $item['level']).' '.$item['title'];
			$return[$item['id']] = trim($_title);
			if ( ! empty($item['children'])) {
				$return = $return + $this->_print_list($item['children']);
			}
		}
		return $return;
	}
	
	protected function left_menu_category_list()
	{
		$this->menu_left_add(array(
			'catalog' => array(
				'sub' => array(
					'list_category' => array(
						'title' => __('Categories list'),
						'link' => Route::url('modules', array(
							'controller' => $this->_controller_name['category'],
							'query' => 'category={CATEGORY_ID}'
						)),
					),
				),
			),
		));
	}
	
	protected function left_menu_category_add($orm)
	{
		if ($this->acl->is_allowed($this->user, $orm, 'add')) {
			$this->menu_left_add(array(
				'catalog' => array(
					'sub' => array(
						'add_category' => array(
							'title' => __('Add category'),
							'link' => Route::url('modules', array(
								'controller' => $this->_controller_name['category'],
								'action' => 'edit',
								'query' => 'category={CATEGORY_ID}'
							)),
						),
					),
				),
			));
		}
	}
	
	protected function left_menu_category_fix($orm)
	{
		if ($this->acl->is_allowed($this->user, $orm, 'fix_positions')) {
			$this->menu_left_add(array(
				'catalog' => array(
					'sub' => array(
						'fix' => array(
							'title' => __('Fix positions'),
							'link'  => Route::url('modules', array(
								'controller' => $this->_controller_name['category'],
								'action' => 'position',
								'query' => 'mode=fix',
							)),
						),
					),
				),
			));
		}
	}
	
	protected function left_menu_category_export($orm)
	{
		if ($this->acl->is_allowed($this->user, $orm, 'export')) {
			$this->menu_left_add(array(
				'catalog' => array(
					'sub' => array(
						'export' => array(
							'title' => __('Export categories (CSV)'),
							'link'  => Route::url('modules', array(
								'controller' => $this->_controller_name['category'],
								'action' => 'export',
							)),
							'target' => '_blank',
						),
					),
				),
			));
		}
	}
	
	protected function left_menu_element_list($orm)
	{
		if ($orm->loaded()) {
			$this->menu_left_add(array(
				'catalog_elements' => array(
					'title' => __('Positions list'),
					'link' => Route::url('modules', array(
						'controller' => $this->_controller_name['element'],
						'query' => 'category={CATEGORY_ID}'
					)),
					'sub' => array(),
				),
			));
		}
	}
	
	protected function left_menu_element_add($orm)
	{
		if ($this->acl->is_allowed($this->user, $orm, 'add')) {
			$this->menu_left_add(array(
				'catalog_elements' => array(
					'sub' => array(
						'add_element' => array(
							'title' => __('Add position'),
							'link' => Route::url('modules', array(
								'controller' => $this->_controller_name['element'],
								'action' => 'edit',
								'query' => 'category={CATEGORY_ID}'
							)),
						),
					),
				),
			));
		}
	}
	
	protected function _get_breadcrumbs()
	{
		$categories = ORM::factory('Catalog_Category')
			->order_by('category_id', 'asc')
			->order_by('position', 'asc')
			->find_all()
			->as_array('id');
		
		$query_array = array(
			'category' => '--CATEGORY_ID--'
		);
		$link_tpl = Route::url('modules', array(
			'controller' => $this->_controller_name['category'],
			'query' => Helper_Page::make_query_string($query_array),
		));
			
		$breadcrumbs = array();
		$_category = Arr::get($categories, $this->category_id);
		while ($_category) {
			$breadcrumbs[] = array(
				'title' => $_category->title,
				'link' => str_replace('--CATEGORY_ID--', $_category->id, $link_tpl),
			);
			
			$_key = $_category->category_id;
			$_category = Arr::get($categories, $_key);
		}
		
		$breadcrumbs[] = array(
			'title' => __('Catalog'),
			'link' => str_replace('--CATEGORY_ID--', 0, $link_tpl),
			'icon' => TRUE,
		);
		
		return array_reverse($breadcrumbs);
	}
} 
