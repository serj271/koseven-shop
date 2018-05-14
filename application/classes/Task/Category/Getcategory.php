<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Category_Getcategory extends Minion_Task {
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);

	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
#		set_exception_handler(array('Kohana_Exception_Handler','handle'));

		Kohana::$config->attach(new Config_File);

		$db = Database::instance();
		// Get the table name from the ORM model
		$this->categories = array();		
		
		$categories_db = ORM::factory('Catalog_Category')
			->order_by('catalog_category_id', 'asc')
			->order_by('position', 'asc')
			->find_all();
		
		$total = ORM::factory('Catalog_Category')->count_all();
		
		Minion_CLI::write('total category - '.$total);
		
//		$categories = array();
		/* foreach ($categories_db as $_item) {
//			Log::instance()->add(Log::NOTICE, Debug::vars('cat--------',$_item->as_array()));
			$_key = $_item->id;
			if ($_item->category_id == 0) {
				$categories[$_key] = array(
					'id' => $_key,
					'title' => $_item->title,
					'level' => 0,
					'children' => array(),
				);
			} else {
//				Log::instance()->add(Log::NOTICE, Debug::vars('cat--------',$categories_db, $categories));
				$_parent = & $categories[$_item->category_id];
				
				$_parent['children'][$_key] = array(
					'id' => $_key,
					'title' => $_item->title,
					'level' => $_parent['level'] + 1,
					'children' => array(),
				);
				unset($_parent);
			}
		} */
//		$this->buildTree($categories_db);
		$tree = $this->print_recursive($categories_db);
		$parse = $this->parse_categories($categories_db->as_array());
		
		Log::instance()->add(Log::NOTICE, Debug::vars('cat---tree----',$tree,$parse));		
		$list_category = ORM::factory('Catalog_Category')->where('id','=','2')->find_all()->as_array();
		Log::instance()->add(Log::NOTICE, Debug::vars($list_category));
		
		
		
		
			
		Minion_CLI::write('Get catalog categories');
	}

	private function print_recursive($structure)
	{
		if ($structure->count() > 0)
		{
			$recursive_items = array();
			for ($i = 0, $j = $structure->count(); $i < $j; $i++)
			{
				$parent   = $structure[$i]->title;
				$children = $this->print_recursive($structure[$i]->categories->find_all());
				$recursive_items[] = $parent . $children;
			}
			return '<ul><li>'.implode('</li><li>', $recursive_items).'</li></ul>';
		}
		return '';
	}
	
	
	
	protected function buildTree($elements, $parentId = 0) 
	{
			
		foreach ($elements as $element) {
			$_key = $element->id;			
				Log::instance()->add(Log::NOTICE, Debug::vars($element->catalog_category_id,$parentId));
				if ($element->catalog_category_id == $parentId) {
					
					$children = $this->buildTree($elements, $element->id);
					
					if ($children) {
						$element['children'] = $children;
					}
					
					$this->categories[] =  $element;
				}		
		}	
	}
	private function parse_categories(array $list)
	{
		$result = array();
		foreach ($list as $_orm) {
			$_item = array(
				'id' => $_orm->id,
				'code' => $_orm->code,
				'title' => $_orm->title,
			);
			
			if ($_orm->level == 0) {
				$_item['path'] = array(
					$_orm->title
				);
			} elseif (array_key_exists($_orm->catalog_category_id, $result)) {
				$_item['path'] = $result[$_orm->catalog_category_id]['path'];
				$_item['path'][] = 	$_orm->title;
			} else {
				continue;
			}
			
			$result[$_orm->id] = $_item;
		}
		
		return $result;
	}

	
	
}

