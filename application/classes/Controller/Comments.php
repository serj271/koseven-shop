<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Controller_Comments extends Controller_Comments_Core { 
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
		
	}
	
	public function after()
	{
		/* if ($this->view !== NULL)
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
		} */
//		$renderer = Kostache::factory(); 
//		$this->view = $renderer->render($view);		
//		$this->template->content=$renderer->render($this->view);	
//		$message = Message::display('message/bootstrap');			
//		$navigator=View::factory($this->request->directory().'/navigator/'.$this->request->controller());
//	    $navigator->message=$message;
//	    $navigator = Menu::factory($this->menu)->render();   
		
//		$session = Session::instance();
//		$session->set('ragion',$ragion);		
//		$ragion_checked = $session->get('ragion_checked', array());
//		$this->template->navigator=$renderer->render($this->view_navigator);	
//		$this->template->content = $this->view_content;
		$this->template->navigator = '';	
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
		if ( ! Auth::instance()->logged_in('login'))
		{
//			throw new HTTP_Exception_403('Access denied.');
			if ($request->action() !== 'login')
			{
				// Get the reverse route and redirect user to the login page
//				$request->redirect('user/login');
			}
		}
	}

}
