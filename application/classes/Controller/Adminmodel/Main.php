<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Adminmodel_Main extends Controller_Adminmodel {
//    public $template ='main';
	protected $_model = 'Product1';

    public function action_index(){
//		throw new HTTP_Exception_404();
		if($this->request->method() === Request::POST){
			$post=array_map('trim',$this->request->post());
			$keys=array('model');
			$last_input=Arr::extract($post,$keys,NULL); 
			$model = $last_input['model'];
			Log::instance()->add(Log::NOTICE,Debug::vars('model-post---',$model));		
			
			$this->redirect(Route::get($this->request->directory())		
					->uri(
						array(
							'directory' =>'Adminmodel',
							'controller' => 'Main',
							'action'     => 'read',
							'model'		=>$model
						)
					)					
			);
		}		
		$model = $this->request->param('model');
		if($model){
			$this->model = $model;
		}
//		Log::instance()->add(Log::NOTICE,Debug::vars('model----',$model));		
	}

	public function action_read()
	{
		$model = $this->request->param('model');		
		$item = ORM::factory($this->_model, $this->request->param('id'));		
//		Log::instance()->add(Log::NOTICE, Debug::vars($model->belongs_to(),$item->enterprise_id));		
		
		if ( ! $item->loaded())
		{
			throw new HTTP_Exception_404(':model with ID :id doesn`t exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id')));

			$lang = Lang::instance()->get();
			if($lang == 'ru'){
				I18n::lang('ru');	
			} else {
				I18n::lang('en-us');		
			}
		    Message::error(__(':model with ID :id not exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id'))));
			$this->view_navigator->message = __(':model with ID :id not exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id')));
				$this->redirect(Route::get($this->request->directory())->uri(array(
					'controller' 	=> 'index',
					'action'		=> 'index',
					'id'			=> $item->id,
				)));		    
		}
		
		$this->view->belongs_to = $model->belongs_to();		
		
		$this->view->item = $item;
		$this->view_navigator->message = __(':model with ID :id',
				array(':model' => $this->_model, ':id' => $this->request->param('id')));
	}
	
	public function action_readall()
	{
		$model = ORM::factory($this->_model);
		$id = $this->request->param('id');
		if(empty($id)){
			$id = 'id';
		}		
		
		$options = [];
		foreach($model->list_columns() as $key=>$value){
			$options[$key] = $value['column_name'];
		}
		$this->view_navigator->options = $options;
		$order = 'id';
		if(in_array($id, $options, TRUE)){
			$order = $id;
		}
		
		$count = ORM::factory($this->_model)->count_all();
		
		$pagination = Pagination::factory(array(
			'items_per_page'=> 10,
			'total_items' 	=> $count,
		))->route_params(array(
			'directory' 	=> $this->request->directory(),
			'controller' 	=> $this->request->controller(),
			'action'		=> $this->request->action(),
			'id'			=>$order,
			'view'			=> 'pagination/bootstrap',
		));
		
		$items = ORM::factory($this->_model)
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->order_by($order)
			->find_all();
		
		// Pass to view
		
		$this->view->items 		= $items;
		$this->view->pagination = $pagination;
	}
	
	public function action_update()
	{
		$model = ORM::factory($this->_model);
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
				$item->values($this->request->post())
					->update($validation);

				$this->redirect(Route::get($this->request->directory())//uppercase
						->uri(
							array(
								'controller' 	=> strtolower($this->request->controller()),
								'action'		=> 'read',
								'id'			=> $item->id,
							)
						)
				);
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->view->errors = $e->errors('validation');
			}
		}
		$this->view->belongs_to = $model->belongs_to();	
		$this->view->item = $item;
	}
	
	public function action_create()
	{
		if(empty($this->request->param('model'))){
			throw new HTTP_Exception_404('model is empty!');				
		}
		Log::instance()->add(Log::NOTICE,Debug::vars('model',$this->request->param('model')));
//		$item = ORM::factory($this->request->param('model'));
		/* 
		if ($this->request->method() === Request::POST)
		{
//			
			$validation = Validation::factory($this->request->post())
				->rule('token','not_empty')
				->rule('token','Security::check');
				
			try
			{
				$item->values($this->request->post())
					->create($validation);
					
				$this->redirect(Route::get($this->request->directory())
					->uri(array(
						'controller' => strtolower($this->request->controller())
					)
				));
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->view->errors = $e->errors('');
//				Log::instance()->add(Log::NOTICE,Debug::vars($e->errors()));
			}
		} */
//		$this->view->tab_number = $tab_number;
//		$this->view->item = $item;
	}
	
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
					$this->redirect(Route::get($this->request->directory())
						->uri(array(
							'controller' => strtolower($this->request->controller())
						)
					));
				}
				
				$item->delete();
				
				$this->redirect(Route::get($this->request->directory())
					->uri(array(
						'controller' => strtolower($this->request->controller())
					)
				));
			}
			
			$this->view->item = $item;
	}
	
	public static function addBase($url){
			return URL::base().$url;			
	} 
	public static function createLink($uri){
		$link = Route::get('Product')->uri(array(
			'directory' =>'Product',
			'controller' => 'Main',
			'action'     => 'read',
			'item_uri' => $uri			
		));//URL::site('product');
		return URL::base().'product/read/'.$uri;			
	} 
} // End 
