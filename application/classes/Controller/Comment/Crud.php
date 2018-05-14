<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Comment_Crud extends Controller_Comment {
	/**
	 * @var	string		Model name
	 */
	protected $_model;

	/**
	 * Action for reading multiple records of the current model
	 * Pagination will be displayed in case there are more records than the page limit
	 */

	public function before()
	{
		parent::before();
		
		if ($this->_model === NULL)
		{
			throw new Kohana_Exception('$_model not defined in :controller',
				array(':controller' => $this->request->controller()));
		}
		
		// If there is no action specific view, use the CRUD default
		if ($this->auto_view === TRUE and ! $this->view)
		{
			list ($view_name, $view_path) = static::find_default_view($this->request);
//			    Log::instance()->add(Log::NOTICE, '_____'.$view_path);	
			if (Kohana::find_file('classes', $view_path))
			{
				$this->view = new $view_name();
			}
		}
		
		// If view has been detected/specified already, pass required vars to it
		if ($this->view)
		{
			$this->view->action 	= $this->request->action();			
			$this->view->controller = $this->request->controller();		
			$this->view->action 	= $this->request->directory();		
			$this->view->model 		= $this->_model;
		}
		if ($this->view_navigator)
		{
			$this->view_navigator->action 	= $this->request->action();			
			$this->view_navigator->controller = $this->request->controller();		
			$this->view_navigator->action 	= $this->request->directory();		
			$this->view_navigator->model 		= $this->_model;
		}
	}


	public function action_index()
	{
		$order_by = $this->request->param('pole','id');
		$count = ORM::factory($this->_model)->count_all();
		$pagination = Pagination::factory(array(
			'items_per_page'=> 10,
			'total_items' 	=> $count,
		))->route_params(array(
			'directory' 	=> $this->request->directory(),
			'controller' 	=> $this->request->controller(),
			'action'		=> $this->request->action(),
			'pole'			=>$order_by,
			'view'			=> 'pagination/bootstrap',
		));
		
		$items = ORM::factory($this->_model)
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->order_by($order_by)
			->find_all();
//		Log::instance()->add(Log::NOTICE,Debug::vars($items));
		// Pass to view
		$this->view->items 		= $items;
		$this->view->pagination = $pagination;
//		Log::instance()->add(Log::NOTICE,Debug::vars($this->request->directory()));
	}	
	/**
	 * Action for creating a single record
	 */
	public function action_create()
	{
		$item = ORM::factory($this->_model);

		
		if ($this->request->method() === Request::POST)
		{
			$validation = Validation::factory($this->request->post())
				->rule('token','not_empty')
				->rule('token','Security::check');
				
			try
			{
				$item->values($this->request->post());
				$code = md5(uniqid(rand(),true));
				$code = substr($code,0,64);	    
				$item->one_password = $code;		
				$item->create($validation);
					
				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),					
				)));
			}
			catch (ORM_Validation_Exception $e)
			{
//				Log::instance()->add(Log::NOTICE, Debug::vars($e->errors('validation')));
				$this->view->errors = $e->errors('models/user');
			}
		}
//		Log::instance()->add(Log::NOTICE,Debug::vars($item));			
		$this->view->item = $item;
	}
	
	/**
	 * Action for reading a single record
	 */
	public function action_read()
	{
		$item = ORM::factory($this->_model, $this->request->param('id'));
		
		if ( ! $item->loaded())
		{
//			throw new HTTP_Exception_404(':model with ID :id doesn`t exist!',
//				array(':model' => $this->_model, ':id' => $this->request->param('id')));

			$lang = Lang::instance()->get();
			if($lang == 'ru'){
				I18n::lang('ru');	
			} else {
				I18n::lang('en-us');		
			}
		    Message::error(__(':model with ID :id not exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id'))));
//		$this->view_navigator->message = __(':model with ID :id not exist!',
//				array(':model' => $this->_model, ':id' => $this->request->param('id')));
			$this->redirect($this->request->route()->uri(array(
					'directory'		=> $this->request->directory(),
					'controller' 	=> $this->request->controller(),					
				)));

		}		

//		Log::instance()->add(Log::NOTICE,Debug::vars($item->roles->as_array()));			
		$this->view->item = $item;
		$this->view_navigator->message = __(':model with ID :id',
				array(':model' => $this->_model, ':id' => $this->request->param('id')));
	}
	
	/**
	 * Action for updating a single record
	 */
	public function action_update()
	{
		$item = ORM::factory($this->_model, $this->request->param('id'));
		
		if ( ! $item->loaded())
			throw new HTTP_Exception_404('Resource not found');
			
		if ($this->request->method() === Request::POST)
		{
			$validation = Validation::factory($this->request->post())
				->rule('token','not_empty')
				->rule('token','Security::check');
				
			try
			{
				$item->values($this->request->post());
				$item->logins = 0;					
				$item->update($validation);
//				Log::instance()->add(Log::NOTICE, Debug::vars(Route::get('useradmin')));
//				$this->redirect('/');

				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),
					'action'		=> 'read',
					'id'			=> $item->id,
				)));
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->view->errors = $e->errors('validation');
			}
		}
			
		$this->view->item = $item;
	}
	
	/**
	 * Action for deleting a single record
	 */
	public function action_delete()
	{
		$item = ORM::factory($this->_model, $this->request->param('id'));
		
		if ( ! $item->loaded())
		{
			throw new HTTP_Exception_404(ucfirst($this->_model).' doesn`t exist: :id', 
				array(':id' => $this->request->param('id')));
		}
		
		if ($this->request->method() === Request::POST)
		{
			$action = $this->request->post('action');
			
			if ($action !== 'yes')
			{
				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),
				)));
			}
			
			$item->delete();
				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),
				)));
		}
		
		$this->view->item = $item;
	}
	
	/**
	 * Action for deleting multiple records
	 * 
	 * 	ORM::delete() is invoked on each of the records instead of 
	 * 	deleting them all with a single query
	 */
	public function action_deletemultiple()
	{
		$ids = ($this->request->method() === Request::POST)
			? $this->request->post('ids')
			: $this->request->query('ids');
			
		// If no IDs were specified, redirect back to referrer
		if (count($ids) === 0)
		{
				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),
				)));


		}
		
		// Create an empty instance of current model to get additional infos
		$object = ORM::factory($this->_model);
		
		// Select items requested for deletion
		$items = ORM::factory($this->_model)
			->where($object->object_name().'.'.$object->primary_key(),'IN',$ids)
			->find_all();
		
		if ($this->request->method() === Request::POST)
		{
			$validation = Validation::factory($this->request->post())
				->rule('token','not_empty')
				->rule('token','Security::check')
				->rule('action','equals',array(':value','yes'));
				
			if ($validation->check())
			{
				foreach ($items as $item)
				{
					$item->delete();
				}
			}

		    		$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),
				)));

			
		}
		
		$this->view->items = $items;
	}
	
	/**
	 * Finds the default CRUD view for Request specified (ignores the controller)
	 * 
	 * @param	Request
	 * @return	array	view_name, view_path
	 */
	
	
}
