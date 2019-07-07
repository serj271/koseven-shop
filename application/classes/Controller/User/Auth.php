<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Auth extends Controller_User {
	protected $_model='User';
	public function action_index()
	{
		// Redirect logged-in admins to the administration index
		// All users which make it to the action are considered admins		
//	Log::instance()->add(Log::NOTICE, Debug::vars(Auth::instance()->logged_in()));
		if (Auth::instance()->logged_in()){
        		HTTP::redirect('user');
        		exit;
//			$this->redirect('user');
		} else {
			$this->redirect('user/auth/login');
		}
			$login = View::factory('user/menulogin');
			$this->template->menu=$login;
	}
	public function action_login(){
		if ($this->request->method() === Request::POST)
		{			
			$validation = Validation::factory($this->request->post())
				->rule('username','not_empty')
				->rule('password','not_empty')
				->rule('token','not_empty')
				->rule('token','Security::check');
				
			if ($validation->check())
			{
				list($username, $password, $remember) = array_values(Arr::extract(
					$this->request->post(), array(
						'username','password','remember',
					)));
				
				if (Auth::instance()->login($username, $password, TRUE))
				{
//					$this->redirect('user');
        				HTTP::redirect('user');
        				exit;
				}
				
				$this->view->errors = array(
					'username' => __('Invalid username or password')
				);
			
			}
			else
			{
				$this->view->errors = $validation->errors('validation');	
				if(isset($validation->errors('validation')['password'])){
					Message::error($validation->errors('validation')['password']);					
				}
				if(isset($validation->errors('validation')['username'])){
					Message::error($validation->errors('validation')['username']);					
				}
//				Log::instance()->add(Log::NOTICE, Debug::vars($validation->errors('validation')));
			}
			
			$this->view->values = $this->request->post();
		} 
//		   $this->view = 'login';		
//			$this->view = 
			$login = View::factory('user/menulogin');
			$this->template->menu=$login;
//			$this->breadcrumbs = '';
	}
	/**
	 * Action for logging out the user
	 * 
	 * 	Additional query params can be specified:
	 *
	 * 		destroy - to completely destroy the session
	 * 		all 	- to remove all user tokens (logout from everywhere)
	 *
	 */
	public function action_logout()
	{
		// Log out only if the token is ok
		if (Security::token() === $this->request->param('id'))
		{
//			$destroy = (bool) $this->request->query('destroy');
//			$all	 = (bool) $this->request->query('all');			
//			Auth::instance()->logout($destroy, $all);
//			Auth::instance()->logout();
			Auth::instance()->logout(TRUE, TRUE);
        		HTTP::redirect('user/auth/login');
        		exit;
		}
		Auth::instance()->logout();
        	HTTP::redirect('user/auth/login');
        	exit;
	}
	
	public function action_join()
	{
		$user = Auth::instance()->get_user();
		if($user){
			$this->redirect('/user');		
		}	
		if ($this->request->method() === Request::POST)
		{	
			$member = ORM::factory('User')
				// The ORM::values() method is a shortcut to assign many values at once
				->values($_POST, array('username', 'password', 'email'));
			$code = md5(uniqid(rand(),true));
			$code = substr($code,0,64);	    
			$member->one_password = $code;
			$external_values = array(
				// The unhashed password is needed for comparing to the password_confirm field
				'password' => Arr::get($_POST, 'password'),
			// Add all external values
			) + Arr::get($_POST, '_external', array());
			$extra = Validation::factory($external_values)
				->rule('password_confirm', 'matches', array(':validation', ':field', 'password'));
			$captcha = Arr::get($_POST, 'captcha');
//			Log::instance()->add(Log::NOTICE, Debug::vars(Captcha::valid($captcha)));
			if(Captcha::valid($captcha)){
				try
				{
					$member->save($extra);
					$member->add('roles', ORM::factory('Role', array('name' => 'login')));
					// Redirect the user to his page
					$this->redirect('/');				
				}
				catch (ORM_Validation_Exception $e)
				{
					$errors = $e->errors('models');
					$this->view->errors = $errors;
				}
			} else {
				$this->view->errors = array(
					'captchaError'=>__('captcha error')
				);				
			}	
			$this->view->values = $this->request->post();
			
		} 
//		   $this->view = 'login';		
			$login = View::factory('user/menulogin');
			$this->template->menu=$login;
//			$this->view->captcha_image = $this->captcha->render();
//			Log::instance()->add(Log::NOTICE, Debug::vars($this->captcha->render()));
	}
	

}
