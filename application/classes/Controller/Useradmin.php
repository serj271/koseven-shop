<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Useradmin extends Controller_Common_Useradmin {
//Kohana_Controller	
	/**
	 * @var	bool	Should View be automatically included?
	 */
	public $auto_view = TRUE;
	protected $_model;
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
			
		// Check if user is allowed to continue
//		static::check_permissions($this->request);
		if ( ! Auth::instance()->logged_in(array('admin')))
		{
//			throw new HTTP_Exception_403('Access denied.');
//			Log::instance()->add(Log::NOTICE, $request->action());
//			if ($request->action() !== 'login')
//			{
//				Request::current()->redirect('user');
				// Get the reverse route and redirect user to the login page
				$this->redirect('user/auth/login');
//				$request->redirect('user/auth/login');
//			}
		}	
		$belongs_to = array();
		if($this->_model){
			$model = ORM::factory($this->_model);
			$belongs_to = $model->belongs_to();
		}
	
		// Automatically figure out the ViewModel for the current action 
		if ($this->auto_view === TRUE)
		{
			list($view_name, $view_path) = static::find_view($this->request);
//Log::instance()->add(Log::NOTICE, Debug::vars($view_name,$view_path));		
			
			if (Kohana::find_file('classes', $view_path))
			{		
				$this->view = new $view_name();
			}
			list($view_name_navigator, $view_path_navigator) = static::find_view_navigator($this->request);			
			if (Kohana::find_file('classes', $view_path_navigator))
			{			
				$this->view_navigator = new $view_name_navigator();
			}
		}
		if ($this->view)
		{			
			$this->view->directory 	= $this->request->directory();
			$this->view->action 	= $this->request->action();				
			$this->view->controller = $this->request->controller();			
			$this->view->model 		= $this->_model;
			$this->view->belongs_to = $belongs_to;
		};
		if ($this->view_navigator)
		{
			$this->view_navigator->directory 	= $this->request->directory();
			$this->view_navigator->action 	= $this->request->action();				
			$this->view_navigator->controller = $this->request->controller();			
			$this->view_navigator->model 		= $this->_model;
			$this->view_navigator->belongs_to = $belongs_to;
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
//				$this->response->body($renderer->render($this->view));
//				$this->response->body($this->view);
//				
//				$this->view = $renderer->render($view);
//				Log::instance()->add(Log::NOTICE, Debug::vars($renderer->render($view)));	
			}
		}
		$renderer = Kostache::factory(); 
		$this->template->content=$renderer->render($this->view);	
//		$message = Message::display('message/bootstrap');			
//Log::instance()->add(Log::NOTICE, Debug::vars($this->view->errors));		
//		$navigator=View::factory($this->request->directory().'/navigator/'.$this->request->controller());
//	    $navigator->message=$message;
//	    $navigator = Menu::factory($this->menu)->render();   
		
		$session = Session::instance();
//		$session->set('ragion',$ragion);		
//		$ragion_checked = $session->get('ragion_checked', array());
//		Log::instance()->add(Log::NOTICE, Debug::vars($ragion_checked));		
	
		$this->template->navigator=$renderer->render($this->view_navigator);			
		$menu = View::factory('/useradmin/menu');		
		$this->template->menu = $menu;	
		$this->template->breadcrumbs = '';			
		
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
//	    Log::instance()->add(Log::NOTICE, Debug::vars('ol', $request));
		if ( ! Auth::instance()->logged_in('admin'))
		{
//			throw new HTTP_Exception_403('Access denied.');
//			Log::instance()->add(Log::NOTICE, $request->action());
//			if ($request->action() !== 'login')
//			{
//				Request::current()->redirect('user');
				// Get the reverse route and redirect user to the login page
//				$request->redirect('admin/auth/login');
//				$request->redirect('user/auth/login');
//			}
		}
	}
	
	/**
	 * Find the view name and view path for Request specified
	 *
	 * @param	Request
	 * @return	array	view_name, view_path
	 */
	public static function find_view(Request $request)
	{
		$view_name = array('View');		
		// If current request's route is set to a directory, prepend to view name
		if ($request->directory())
		{
			array_push($view_name, $request->directory());
		}
		if ($request->controller())
		{
			array_push($view_name, $request->controller());
		}	
		// Append controller and action name to the view name array
		$view_name[] = ucfirst($request->action());		
		// Merge all parts together to get the class name
		$view_name = implode('_', $view_name);		
		// Get the path respecting the class naming convention
		$view_path = str_replace('_', DIRECTORY_SEPARATOR, $view_name);
		
		return array($view_name, $view_path);
	}
	public static function find_view_navigator(Request $request)
	{
		// Empty array for view name chunks
//		Log::instance()->add(Log::NOTICE, Debug::vars($request->pole));
		$view_name = array('View');		
		// If current request's route is set to a directory, prepend to view name
		if ($request->directory())
		{
			array_push($view_name, $request->directory());
		}
		if ($request->controller())
		{
			array_push($view_name, $request->controller());
		}	
		// Append controller and action name to the view name array
//		$view_name[] = ucfirst($request->action());	
		array_push($view_name, ucfirst('navigator'));
		// Merge all parts together to get the class name
		$view_name = implode('_', $view_name);		
		// Get the path respecting the class naming convention
		$view_path = str_replace('_', DIRECTORY_SEPARATOR, $view_name);
		
		return array($view_name, $view_path);
	}

}
