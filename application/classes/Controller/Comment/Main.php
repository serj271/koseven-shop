<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Comment_Main extends Controller_Comment {
    public $template ='main';
	protected $model = 'Comment';

//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
    public function action_index(){
		if (!Auth::instance()->logged_in('login')){		
//			$this->redirect('user/auth/login');
		}
//		$user = Auth::instance()->get_user();
//		$this->view->username = $user->username;
//		$this->template->content = Message::display();
//    Log::instance()->add(Log::NOTICE, Route::url('admin'));
//    $this->request->redirect('admin/news');
		
//		Log::instance()->add(Log::NOTICE, Debug::vars($comment));
		$form = View::factory('comment/form')
			->bind('legend', $legend)
			->set('submit', __('Create'))
			->bind('errors',$errors)
			->bind('comment', $comment);
		$this->view_content = $form;
		$comment = Sprig::factory($this->model)->values($this->request->post());
		$legend = 'form action';
		
		if ($this->request->method() === Request::POST)
		{
			$validation = Validation::factory($this->request->post())
				->rule('token','not_empty')
				->rule('name','not_empty')
				->rule('token','Security::check');
				
			Log::instance()->add(Log::NOTICE, Debug::vars('post-----',$this->request->post()));
			if($validation->check()){
				try
				{
					$comment->parent = '1';
					$comment->create();					
					$this->redirect($this->request->route()->uri(array(
						'controller' 	=> $this->request->controller(),					
					)));
//					throw new Sprig_Validation_Exception( 'comment', $validation,'valid error');				
				}catch(Sprig_Validation_Exception $e)
				{
					$errors = $e->errors('comment');
					Log::instance()->add(Log::NOTICE, Debug::vars('valid error',$errors));				
				}	
			
				
			} else {
				$errors = $validation->errors('comment');
//				$this->view->errors = $errors;
				Log::instance()->add(Log::NOTICE, Debug::vars('valid error',$validation->errors('comment')));	
			}
				
			
			
			
		
		}	
		
		
//		$errors = array('name'=>'not');
		
//    $this->response->body('admin');
//		$login = View::factory('user/menulogout');
//		$this->template->menu=$login;
    }
} // End 
