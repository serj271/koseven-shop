<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Basket_Main extends Controller_Basket_Crud {
//    public $template ='main';
	public $_model='Shopping_Cart';
//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
	public function action_index(){
//		$user = Auth::instance()->get_user();
//		$this->view->username = $user->username;		
		$results = Cart::GetProducts($this->_mCartId);
		$carts = array();
		Log::instance()->add(Log::NOTICE, Debug::vars($results));
		foreach($results as $result){
			$carts[] =  $result;							
		}
		$results = Cart::GetTotalAmount($this->_mCartId);
		$total_amount = $results[0]['total_amount'];
//		Log::instance()->add(Log::NOTICE,Debug::vars($results->as_array()));
//		$this->view->carts = $carts;//id, cart_id, name from variontion, attributes, price, quantity, subtotal, uri 
//		$this->view->items = $carts;//id, cart_id, name from variontion, attributes, price, quantity, subtotal, uri 
//		$this->view->total_amount = $total_amount;
//		$this->template->content = Message::display();
//    Log::instance()->add(Log::NOTICE, Route::url('admin'));
//		$count = ORM::factory($this->_model)->count_all();

		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
	}
	
	
	public function action_delete(){//dlete product from basket
		$item = ORM::factory($this->_model, $this->request->param('id'));//id
		
		if ( ! $item->loaded())
		{
			throw new HTTP_Exception_404(ucfirst($this->_model).' doesn`t exist: :id', 
				array(':id' => $this->request->param('id')));
		}
		
		if ($this->request->method() === Request::POST)
		{
			if($post = $this->request->post()){
				$post = array_map('trim', $post);
				$last_input = Arr::extract($post, array('action'), NULL);
				if($last_input['action'] == 'yes'){
					Cart::MoveProduct( $this->request->param('id'));
				}
			}
//			$this->redirect(strtolower($this->request->directory()),303);	
			$this->redirect($this->request->route()->uri(array(
					'directory'		=> $this->request->directory(),
					'controller' 	=> $this->request->controller(),
					'action'		=>'index',
			)));	
		}		
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
	}
	
	public function action_update()
	{
		$item = ORM::factory($this->_model, $this->request->param('id'));
		
		if ( ! $item->loaded())
			throw new HTTP_Exception_404(ucfirst($this->_model).' doesn`t exist: :id', 
				array(':id' => $this->request->param('id')));
			
		if ($this->request->method() === Request::POST)
		{
			if($post = $this->request->post()){
				$post = array_map('trim', $post);
				$last_input = Arr::extract($post, array('action','quantity'), NULL);
				if($last_input['action'] == 'yes'){
					$validation = Validation::factory($this->request->post())
						->rule('token','not_empty')
						->rule('token','Security::check');
					if($validation->check()){
						Cart::UpdateProduct($this->request->param('id'),$last_input['quantity']);
					} else {
//						 Log::instance()->add(Log::NOTICE,Debug::vars($validation->errors('validation', TRUE)));
					}					
				}
				$this->redirect($this->request->route()->uri(array(
						'directory'		=> $this->request->directory(),
						'controller' 	=> $this->request->controller(),
						'action'		=>'index',
				)));
			}
		}			
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
		$this->view->item = $item;
	}
	
	public function action_increment()
	{
		$item = ORM::factory($this->_model, $this->request->param('id'));
		
		if ( ! $item->loaded())
			throw new HTTP_Exception_404(ucfirst($this->_model).' doesn`t exist: :id', 
				array(':id' => $this->request->param('id')));
			
		if ($this->request->method() === Request::POST)
		{
			if($post = $this->request->post()){
				$post = array_map('trim', $post);
				$last_input = Arr::extract($post, array('action','quantity'), NULL);
				if($last_input['action'] == 'yes'){
					$validation = Validation::factory($this->request->post())
						->rule('token','not_empty')
						->rule('token','Security::check');
					if($validation->check()){
						Cart::UpdateProduct($this->request->param('id'),$last_input['quantity']);
					} else {
//						 Log::instance()->add(Log::NOTICE,Debug::vars($validation->errors('validation', TRUE)));
					}					
				}
				$this->redirect($this->request->route()->uri(array(
						'directory'		=> $this->request->directory(),
						'controller' 	=> $this->request->controller(),
						'action'		=>'index',
				)));
			}
		}			
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
		$this->view->item = $item;
	}
	
	public function action_decrement()
	{
		$item = ORM::factory($this->_model, $this->request->param('id'));
		
		if ( ! $item->loaded())
			throw new HTTP_Exception_404(ucfirst($this->_model).' doesn`t exist: :id', 
				array(':id' => $this->request->param('id')));
			
		if ($this->request->method() === Request::POST)
		{
			if($post = $this->request->post()){
				$post = array_map('trim', $post);
				$last_input = Arr::extract($post, array('action','quantity'), NULL);
				if($last_input['action'] == 'yes'){
					$validation = Validation::factory($this->request->post())
						->rule('token','not_empty')
						->rule('token','Security::check');
					if($validation->check()){
						Cart::UpdateProduct($this->request->param('id'),$last_input['quantity']);
					} else {
//						 Log::instance()->add(Log::NOTICE,Debug::vars($validation->errors('validation', TRUE)));
					}					
				}
				$this->redirect($this->request->route()->uri(array(
						'directory'		=> $this->request->directory(),
						'controller' 	=> $this->request->controller(),
						'action'		=>'index',
				)));
			}
		}			
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
		$this->view->item = $item;
	}
	
} // End 
