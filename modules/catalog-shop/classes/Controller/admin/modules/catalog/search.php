<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Modules_Catalog_Search extends Controller_Admin_Modules_Catalog {

	public function action_index()
	{
		$orm = ORM::factory('Catalog_Element');
		
		$query_filter = $this->request->query('filter');
		if ( ! empty($query_filter) AND ! empty($query_filter['article'])) {
			$orm->where('code', 'LIKE', "%{$query_filter['article']}%");
			$this->sub_title = $query_filter['article'];
		} else {
			$this->sub_title = '';
		}
		
		$paginator_orm = clone $orm;
		$paginator = new Paginator('admin/layout/paginator');
		$paginator
			->per_page(20)
			->count($paginator_orm->count_all());
		unset($paginator_orm);

		$list = $orm
			->paginator($paginator)
			->find_all();

		$this->template
			->set_filename('modules/catalog/search/list')
			->set('list', $list)
			->set('paginator', $paginator);
		
		$this->left_menu_category_list();
		
		$this->title = __('Search result');
	}
	
	protected function _get_breadcrumbs()
	{
		$breadcrumbs = parent::_get_breadcrumbs();
	
		$breadcrumbs[] = array(
			'title' => __('Search result'),
		);
	
		return $breadcrumbs;
	}
} 
