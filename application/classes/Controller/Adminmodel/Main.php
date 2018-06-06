<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Adminmodel_Main extends Controller_Adminmodel {
//    public $template ='main';
	protected $_model;

    public function action_index(){
//		throw new HTTP_Exception_404();
		if($this->request->method() === Request::POST)
		{
			$post=array_map('trim',$this->request->post());
			$keys=array('model');
			$last_input=Arr::extract($post,$keys,NULL); 
			$model = $last_input['model'];
//			Log::instance()->add(Log::NOTICE,Debug::vars('model-post---',$model));		
			
			
			$this->redirect(Route::get($this->request->directory())		
					->uri(
						array(
							'directory' =>'Adminmodel',
							'controller' => 'Main',
							'action'     => 'prepend',
							'model'		=>$model
						)
					)					
			);
		}		
		$model = $this->request->param('model');
		
//		Log::instance()->add(Log::NOTICE,Debug::vars('model----',$model));		
	}
	
	public function action_prepend()
	{
		if(empty($this->request->param('model'))){
			throw new HTTP_Exception_404('model doesn`t exist!');
		}
		$model_orm = ORM::factory($this->request->param('model'));
		if($this->request->method() === Request::POST)
		{
			$post=array_map('trim',$this->request->post());
			$keys=array('entries','search');
			$last_input=Arr::extract($post,$keys,NULL); 
			$entries = $last_input['entries'];
			$items = $model_orm
				->where($entries,'=',2)
				->find_all()
				->as_array();
			Log::instance()->add(Log::NOTICE,Debug::vars('model-post---',$entries,$items));		
			
			
			$this->redirect(Route::get($this->request->directory())		
					->uri(
						array(
							'directory' =>'Adminmodel',
							'controller' => 'Main',
							'action'     => 'index',
//							'model'		=>$model,
//							'id'		=>2
						)
					)					
			);
		}
		
//		Log::instance()->add(Log::NOTICE, Debug::vars($model->belongs_to(),$model->table_columns()));
		
		$this->view->belongs_to = $model_orm->belongs_to();		
		$this->view->model = $this->request->param('model');
		$this->view->table_columns = $model_orm->table_columns();
//		$this->view->item = $item;
		$this->view->message = __(':model with ID :id',
				array(':model' => $this->request->param('model'), ':id' => $this->request->param('id')));
	}

	public function action_read()
	{
		if(empty($this->request->param('model'))){
			throw new HTTP_Exception_404('model doesn`t exist!');
		}
		$model = ORM::factory($this->request->param('model'));
		$item = ORM::factory($this->request->param('model'), $this->request->param('id'));
//		Log::instance()->add(Log::NOTICE, Debug::vars($model->belongs_to(),$item->enterprise_id));		
		
		if ( ! $item->loaded())
		{
			throw new HTTP_Exception_404(':model with ID :id doesn`t exist!',
				array(':model' => $this->request->param('model'), ':id' => $this->request->param('id')));

			$lang = Lang::instance()->get();
			if($lang == 'ru'){
				I18n::lang('ru');
			} else {
				I18n::lang('en-us');		
			}
		    Message::error(__(':model with ID :id not exist!',
				array(':model' => $this->request->param('model'), ':id' => $this->request->param('id'))));
			$this->view->message = __(':model with ID :id not exist!',
				array(':model' => $this->request->param('model'), ':id' => $this->request->param('id')));
				$this->redirect(Route::get($this->request->directory())
					->uri(array(
						'action'		=> 'index',
				)));		    
		}
		
		$this->view->belongs_to = $model->belongs_to();		
		$this->view->model = $this->request->param('model');
		$this->view->item = $item;
		$this->view->message = __(':model with ID :id',
				array(':model' => $this->request->param('model'), ':id' => $this->request->param('id')));
	}
	
	public function action_readall()
	{
		if(empty($this->request->param('model'))){
			throw new HTTP_Exception_404('model doesn`t exist!');
		}
		$model = ORM::factory($this->request->param('model'));
		$id = $this->request->param('id');
		if(empty($id)){
			$id = 'id';
		}		
		
		$options = [];
		foreach($model->list_columns() as $key=>$value){
			$options[$key] = $value['column_name'];
		}
		$this->view->options = $options;
		$order = 'id';
		if(in_array($id, $options, TRUE)){
			$order = $id;
		}
		
		$count = ORM::factory($this->request->param('model'))->count_all();
		
		$pagination = Pagination::factory(array(
			'items_per_page'=> 10,
			'total_items' 	=> $count,
		))->route_params(array(
			'directory' 	=> $this->request->directory(),
			'controller' 	=> $this->request->controller(),
			'action'		=> $this->request->action(),
			'model'			=> $this->request->param('model'),
			'id'			=>$order,
			'view'			=> 'pagination/bootstrap',
		));
		
		$items = ORM::factory($this->request->param('model'))
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->order_by($order)
			->find_all();
		
		// Pass to view
//		
		$this->view->items 		= $items;
		$this->view->pagination = $pagination;
		$this->view->model = $this->request->param('model');
	}
	
	public function action_update()
	{
		if(empty($this->request->param('model'))){
			throw new HTTP_Exception_404('model doesn`t exist!');
		}
		$model = ORM::factory($this->request->param('model'));
		$item = ORM::factory($this->request->param('model'), $this->request->param('id'));
		
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
								'directory' 	=> $this->request->directory(),
								'controller' 	=> $this->request->controller(),
								'action'		=> 'read',
								'model'			=> $this->request->param('model'),
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
//		$this->_model = $this->request->param('model');
		$item_orm = ORM::factory($this->request->param('model'));
		
		if ($this->request->method() === Request::POST)
		{			
			$validation = Validation::factory($this->request->post())
				->rule('token','not_empty')
				->rule('token','Security::check');
				
			try
			{
				$item = $item_orm->values($this->request->post())
					->create($validation);
				Log::instance()->add(Log::NOTICE, Debug::vars($item));
				$this->redirect(Route::get($this->request->directory())
					->uri(array(
						'directory' 	=> $this->request->directory(),
						'controller' 	=> $this->request->controller(),
						'action'		=> 'read',
						'model'			=> $this->request->param('model'),
						'id'			=> $item->id,
					)
				));
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->view->errors = $e->errors('');
				Log::instance()->add(Log::NOTICE,Debug::vars($e->errors()));
			}
		}
//		$this->view->tab_number = $tab_number;
		$this->view->item = $item_orm;
		$this->view->model = $this->request->param('model');
	}
	
	public function action_delete()
	{
		if(empty($this->request->param('model'))){
			throw new HTTP_Exception_404('model doesn`t exist!');
		}
		$model = ORM::factory($this->request->param('model'));
		$id = $this->request->param('id');
			$item = ORM::factory($this->request->param('model'), $this->request->param('id'));
			
			if ( ! $item->loaded())
			{
				throw new HTTP_Exception_404(ucfirst($this->request->param('model').' doesn`t exist: :id'),
					array(':id' => $this->request->param('id')));
			}
			
			if ($this->request->method() === Request::POST)
			{
				$action = $this->request->post('action');
				
				if ($action !== 'yes')
				{
					$this->redirect(Route::get($this->request->directory())
						->uri(array(
							'directory'	=> $this->request->directory(),
							'controller' =>$this->request->controller(),
							'action'		=>$this->request->action(),
							'model'			=> $this->request->param('model'),
							'id'			=> $this->request->param('id')
						)
					));
				}
				
				$item->delete();
				
				$this->redirect(Route::get($this->request->directory())
					->uri(array(
						'directory'	=> $this->request->directory(),
						'controller' => $this->request->controller(),
						'model'			=> $this->request->param('model'),
						'action'		=>'index'
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
