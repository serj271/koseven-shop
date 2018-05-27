<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Product_Main extends Controller_Product {
//    public $template ='main';
	protected $_model = 'Product';
//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
    public function action_index(){		

//		if (!Auth::instance()->logged_in('login')){		
//			$this->redirect('user/auth/login');
//		}
//		$user = Auth::instance()->get_user();
//		$this->view->username = $user->username;
		$item_uri = $this->request->param('item_uri');
		$model = 'Product';
		$result = array();
//		Log::instance()->add(Log::NOTICE,Debug::vars('item_uri----',$item_uri));
		
	
		$products_count = ORM::factory('Product')->count_all();
		
		$pagination = Pagination::factory(array(
			'items_per_page'=> 1,
			'total_items' 	=> $products_count,
		))->route_params(array(
			'directory' 	=> $this->request->directory(),
			'controller' 	=> $this->request->controller(),
			'action'		=> $this->request->action(),
			'pole'			=>'id',
			'view'			=> 'pagination/basic',
			));
				
		$products_orm = ORM::factory('Product')
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->order_by('id')
			->find_all();	
		
			foreach ($products_orm as $product){
				$products_as_array = $product->as_array();				
				$photo = $product->primary_photo()->as_array();
				$photo = Arr::map(array(array(__CLASS__,'addBase')), $photo, array('path_fullsize','path_thumbnail'));
				$products_as_array['photo'] = $photo;
				$reviews = $product->reviews->find()->as_array();
				$specifications = $product->specifications->find()->as_array();
				$products_as_array['specifications'] = $specifications;
				$products_as_array['reviews'] = $reviews;
				$link = $this->createLink($product->uri);
				$products_as_array['link'] = $link;
				$result[] = $products_as_array;	
			}
			$this->view->pagination = $pagination;
			$this->view->items = $products_orm;
//			$this->view->product = $result;
		
	
    }
	
	public function action_read()
	{
		$item_uri = $this->request->param('item_uri');
		$item = ORM::factory($this->_model)
			->where('uri','=',$item_uri)
			->find();			
//		Log::instance()->add(Log::NOTICE,Debug::vars('item----',$item));
		if ( ! $item->loaded())
		{
			throw new HTTP_Exception_404(':model with ID :id doesn`t exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id')));

//			$lang = Lang::instance()->get();
//			if($lang == 'ru'){
//				I18n::lang('ru');	
//			} else {
//				I18n::lang('en-us');		
//			}
		   /*  Message::error(__(':model with ID :id not exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id'))));
		$this->view_navigator->message = __(':model with ID :id not exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id'))); */
//			$this->redirect($this->request->route()->uri(array(
//					'directory'		=> $this->request->directory(),
//					'controller' 	=> $this->request->controller(),					
//				)));
		}
		$this->view->item = $item;
	/* 	$this->view_navigator->message = __(':model with ID :id',
				array(':model' => $this->_model, ':id' => $this->request->param('id'))); */
	}
	
	public function action_create()
	{
		$item = ORM::factory($this->_model);		
		if ($this->request->method() === Request::POST)
		{
			$validation = Validation::factory($this->request->post())
				->rule('token','not_empty')
				->rule('token','Security::check');
//			$date = Arr::get($this->request->post(),'cart_id',NULL);
			$post=array_map('trim',$this->request->post());
			$keys=array('cart_id','attributes','product_id');
			$last_input=Arr::extract($post,$keys,NULL); 	
			$session = Session::instance('native');			

			$mCartId = $session->get('mCartId', false);	
			if(!$mCartId){
				$session->set('mCartId',md5(uniqid(rand(), true)));
				$mCartId = $session->get('mCartId', false);	
			}
			Cart::AddProduct($mCartId,$last_input['product_id'],$last_input['attributes']);
		/* 	$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),					
				))); */
			$this->redirect(Route::get('basket')->uri(array(
					'directory' =>'basket',
					'controller' => 'main',
					'action'     => 'index',					
				)));
			
			try
			{
			/* 	$item->values($this->request->post());
				$code = md5(uniqid(rand(),true));
				$code = substr($code,0,64);	    
				$item->one_password = $code;		
				$item->create($validation);
					
				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),					
				))); */
			}
			catch (ORM_Validation_Exception $e)
			{
//				Log::instance()->add(Log::NOTICE, Debug::vars($e->errors('validation')));
				$this->view->errors = $e->errors('models/user');
			}
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
