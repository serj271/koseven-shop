<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Catalog extends Controller_Common_Catalog {
//Kohana_Controller	
	/**
	 * @var	bool	Should View be automatically included?
	 */
	public $auto_view = TRUE;
//	public $auto_view = FALSE;	
	/**
	 * @var	Kostache	View model
	 */
	public $view;
	/**
	config menu
	*/
	public $menu='menu.users';
	
	public $view_navigator;

	public function before()
	{
		parent::before();
		
		// Set security headers
		$this->response
			->headers('x-content-type-options','nosniff')
			->headers('x-frame-options','SAMEORIGIN')
			->headers('x-xss-protection','1; mode=block');
		$session = Session::instance('native');
		Cart::SetCartId();//		
		$this->_mCartId = $session->get('mCartId', false);			
		// Check if user is allowed to continue
//		static::check_permissions($this->request);
		
		// Automatically figure out the ViewModel for the current action 
		if ($this->auto_view === TRUE)
		{
			list($view_name, $view_path) = static::find_view($this->request);	
			
			if (Kohana::find_file('classes', $view_path))
			{			
				$this->view = new $view_name();				
			}
//			list($view_name_navigator, $view_path_navigator) = static::find_view_navigator($this->request);	
//			if (Kohana::find_file('classes', $view_path_navigator))
//			{			
//				$this->view_navigator = new $view_name_navigator();
//			}

		}
	}
	
	public function after()
	{
		if ($this->view !== NULL)
		{
			// Render the content only in case of AJAX and subrequests
			if ($this->request->is_ajax() OR ! $this->request->is_initial())
			{
				$this->view->render_layout = FALSE;
			}			
			// Response body isn't set yet, set it to this controllers' view
			if ( ! $this->response->body())
			{
				$renderer = Kostache::factory(); 
				$this->response->body($renderer->render($this->view));
//				$this->response->body($this->view);
//				$this->view = $renderer->render($view);
			}
		}
		$renderer = Kostache::factory(); 
//		$this->view = $renderer->render($view);		
		$this->template->content=$renderer->render($this->view);	
//		Message::set(Message::SUCCESS, 'ok');
//		$message = Message::display('message/bootstrap');	
		$message='ok';	
		$this->template->navigator = $message;

		$login = FALSE;
		if (Auth::instance()->logged_in('login'))
		{
		    $login = TRUE;
		}

		$quantity = Helpers_Cart::getQuantity($this->_mCartId);
		$total_amount = Helpers_Cart::getTotal($this->_mCartId);
		$fixedTop = View::factory('fixed/top')
			->bind('quantity',$quantity)
			->bind('total_amount',$total_amount)
			->bind('login', $login);
		$this->template->fixedTop = $fixedTop;



		$navbar_items  = array(
			array(
				'url'=>'',
				'text'=>__('Home'),
				'active'=>Helpers_Navbar::home($this->request->uri()),
			),			
			array(
				'url'=>'catalog',
				'text'=>__('List Catalog'),
				'active'=>Helpers_Navbar::active($this->request->uri(),'catalog'),
			),	
			array(
				'url'=>'product',
				'text'=>__('List Product'),
				'active'=>Helpers_Navbar::active($this->request->uri(),'product'),
			),	
			array(
				'url'=>'basket',
				'text'=>__('Basket'),
				'active'=>Helpers_Navbar::active($this->request->uri(),'basket'),
			),
		
		); 
		$navbar = View::factory('navbar/inner')
			->bind('navbar_items',$navbar_items);
		$this->template->navbar = $navbar;


//		$navigator=View::factory($this->request->directory().'/navigator/'.$this->request->controller());
//	    $navigator->message=$message;
//	    $navigator = Menu::factory($this->menu)->render();   
		
		$session = Session::instance();
//		$session->set('ragion',$ragion);		
//		$ragion_checked = $session->get('ragion_checked', array());

		$header = View::factory('header/row');
		$this->template->header=$header;	
		return parent::after();
	}
	
	/**
	 * Check permissions for a certain Request
	 * 	Uses late static binding so child classes can override this 
	 * 	in order to replace its functionality
	 *
	 * @param	Request	$request
	 */
	public static function check_permissions(Request $request)
	{
		if ( ! Auth::instance()->logged_in('admin'))
		{
//			throw new HTTP_Exception_403('Access denied.');

			if ($request->action() !== 'login')
			{
				// Get the reverse route and redirect user to the login page
//				$request->redirect('admin/auth/login');
//				Request::current()->redirect('admin/auth');
			}
		}
	}
	
	/**
	 * Find the view name and view path for Request specified
	 *
	 * @param	Request
	 * @return	array	view_name, view_path
	 */	
	
	public static function find_view_navigator(Request $request)
	{
		// Empty array for view name chunks
		$view_name = array('View');		
		// If current request's route is set to a directory, prepend to view name

		$request->directory() and array_push($view_name, $request->directory(), $request->controller());
		
		// Append controller and action name to the view name array
		array_push($view_name, 'navigator');
		
		// Merge all parts together to get the class name
		$view_name = implode('_', $view_name);
		
		// Get the path respecting the class naming convention
		$view_path = strtolower(str_replace('_', '/', $view_name));
	
		return array($view_name, $view_path);
	}
	public static function find_view(Request $request)
	{
		// Empty array for view name chunks
		$view_name = array('View');
		
		// If current request's route is set to a directory, prepend to view name
		$request->directory() and array_push($view_name, $request->directory());
		
		// Append controller and action name to the view name array
//		array_push($view_name, $request->controller(), $request->action(), $request->param('pole'));
		array_push($view_name, $request->controller(), $request->action());
		
		// Merge all parts together to get the class name
		$view_name = implode('_', $view_name);
		
		// Get the path respecting the class naming convention
		$view_path = strtolower(str_replace('_', '/', $view_name));
		
		return array($view_name, $view_path);
	}
}
