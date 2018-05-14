<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Modules_Catalog_Element extends Controller_Admin_Modules_Catalog {

	public function action_index()
	{
		$category_orm = ORM::factory('catalog_Category')
			->and_where('id', '=', $this->category_id)
			->find();
		if ( ! $category_orm->loaded()) {
			throw new HTTP_Exception_404();
		}
		
		$orm = ORM::factory('catalog_Element')
			->where('category_id', '=', $this->category_id);
		
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
			->set_filename('modules/catalog/element/list')
			->set('list', $list)
			->set('paginator', $paginator);
		
		$this->left_menu_category_list();
		$this->left_menu_category_add($category_orm);
		$this->left_menu_category_export($category_orm);
		$this->left_menu_element_list($category_orm);
		$this->left_menu_element_add($orm);
		
		$this->title = $category_orm->title;
		$this->sub_title = __('Elements list');
	}

	public function action_edit()
	{
		$category_orm = ORM::factory('catalog_Category')
			->and_where('id', '=', $this->category_id)
			->find();
		if ( ! $category_orm->loaded()) {
			throw new HTTP_Exception_404();
		}
		
		$request = $this->request->current();
		$id = (int) $request->param('id');
		$helper_orm = ORM_Helper::factory('catalog_Element');
		$orm = $helper_orm->orm();
		if ( (bool) $id) {
			$orm
				->where('id', '=', $id)
				->find();

			if ( ! $orm->loaded() OR ! $this->acl->is_allowed($this->user, $orm, 'edit')) {
				throw new HTTP_Exception_404();
			}
			$this->title = __('Edit position');
		} else {
			$this->title = __('Add position');
		}
		
		if (empty($this->back_url)) {
			$query_array = array(
				'category' => $this->category_id,
			);
			$query_array = Paginator::query($request, $query_array);
			$this->back_url = Route::url('modules', array(
				'controller' => $this->_controller_name['element'],
				'query' => Helper_Page::make_query_string($query_array),
			));
		}

		if ($this->is_cancel) {
			$request
				->redirect($this->back_url);
		}
		
		if (empty($orm->sort)) {
			$orm->sort = 500;
		}
		
		$errors = array();
		$submit = $request->post('submit');
		if ($submit) {
			try {
				if ( (bool) $id) {
					$orm->updater_id = $this->user->id;
					$orm->updated = date('Y-m-d H:i:s');
					$reload = FALSE;
				} else {
					$orm->creator_id = $this->user->id;
					$orm->category_id = $this->category_id;
					$reload = TRUE;
				}

				$values = $this->meta_seo_reset(
					$request->post(),
					'meta_tags'
				);
				
				if (empty($values['uri'])) {
					$values['uri'] = Ku_Text::slug($values['title']);
				}
				
				$helper_orm->save($values + $_FILES);
				
				if ($reload) {
					if ($submit != 'save_and_exit') {
						$this->back_url = Route::url('modules', array(
							'controller' => $request->controller(),
							'action' => $request->action(),
							'id' => $orm->id,
							'query' => Helper_Page::make_query_string($request->query()),
						));
					}
				
					$request
						->redirect($this->back_url);
				}
			} catch (ORM_Validation_Exception $e) {
				$errors = $this->errors_extract($e);
			}
		}

		if ( ! empty($errors) OR $submit != 'save_and_exit') {
			$categories = array(
				0 => __('-- Root category --')
			) + $this->_get_categories_list();
			
			$properties = $helper_orm->property_list();
			$this->template
				->set_filename('modules/catalog/element/edit')
				->set('helper_orm', $helper_orm)
				->set('categories', $categories)
				->set('properties', $properties);
			
			$this->left_menu_category_list();
			$this->left_menu_category_add($category_orm);
			$this->left_menu_category_export($category_orm);
			$this->left_menu_element_list($category_orm);
			$this->left_menu_element_add($orm);
			
			if (Helper_Module::check_module('greor-nomenclature')) {
				$injector = $this->injectors['nomenclature'];
				if ($orm->loaded()) {
					try {
						$this->hook_list_content[] = $injector->get_hook($orm);
			
						$this->menu_left_add( $injector->menu_list($orm) );
						$this->menu_left_add( $injector->menu_add($orm) );
			
					} catch (ORM_Validation_Exception $e) {
						$errors = array_merge($errors, $this->errors_extract($e));
					}
				}
			}
			
			$this->template
				->set('errors', $errors);
		} else {
			$request
				->redirect($this->back_url);
		}
	}
	
	public function action_delete()
	{
		$request = $this->request->current();
		$id = (int) $request->param('id');
	
		$helper_orm = ORM_Helper::factory('catalog_Element');
		$orm = $helper_orm->orm();
		$orm
			->and_where('id', '=', $id)
			->find();
	
		if ( ! $orm->loaded() OR ! $this->acl->is_allowed($this->user, $orm, 'edit')) {
			throw new HTTP_Exception_404();
		}
	
		if ($this->element_delete($helper_orm)) {
			if (empty($this->back_url)) {
				$query_array = array(
					'category' => $this->category_id,
				);
				$this->back_url = Route::url('modules', array(
					'controller' => $this->_controller_name['element'],
					'query' => Helper_Page::make_query_string($query_array),
				));
			}
			
			$request
				->redirect($this->back_url);
		}
	}
	
	public function action_dyn_sort()
	{
		$this->auto_render = FALSE;
		
		$request = $this->request->current();
		$id = (int) $request->post('id');
		$field = $request->post('field');
		$value = $request->post('value');
		
		$orm = ORM::factory('catalog_Element', $id);
		if (empty($field) OR ! $orm->loaded() OR ! $this->acl->is_allowed($this->user, $orm, 'edit')) {
			throw new HTTP_Exception_404();
		}
		try {
			$orm->values(array(
				$field => $value
			))->save();
		} catch (ORM_Validation_Exception $e) {
			throw new HTTP_Exception_404();
		}
		
		Ku_AJAX::send('json', $orm->$field);
	}
	
	protected function _get_breadcrumbs()
	{
		$breadcrumbs = parent::_get_breadcrumbs();
	
		$request = $this->request->current();
		if (in_array($request->action(), array('edit'))) {
			$query_array = array(
				'category' => $this->category_id,
			);
			$query_array = Paginator::query($request, $query_array);
			$breadcrumbs[] = array(
				'title' => __('Positions list'),
				'link' => Route::url('modules', array(
					'controller' => $this->_controller_name['element'],
					'query' => Helper_Page::make_query_string($query_array),
				))
			);
			
			$id = (int) $request->param('id');
			$category_orm = ORM::factory('catalog_Element')
				->where('id', '=', $id)
				->find();
			if ($category_orm->loaded()) {
				$breadcrumbs[] = array(
					'title' => $category_orm->title.' ['.__('position edition').']',
				);
			} else {
				$breadcrumbs[] = array(
					'title' => ' ['.__('new position').']',
				);
			}
		} else {
			$breadcrumbs[] = array(
				'title' => __('Positions list'),
			);
		}
	
		return $breadcrumbs;
	}
} 
