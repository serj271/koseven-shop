<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Main extends Controller_User {
//    public $template ='main';
    protected $_model='User';
//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
    public function action_index(){
		if (!Auth::instance()->logged_in('login'))
		{		
//			$this->redirect('user/auth/login');
        		HTTP::redirect('user/auth/login');
        		exit;
		}
		$user = Auth::instance()->get_user();
		$this->view->username = $user->username;		
		
//	Log::instance()->add(Log::NOTICE,Debug::vars(Auth::instance()->get_user_roles()));
//		$this->template->content = Message::display();
//    Log::instance()->add(Log::NOTICE, Route::url('admin'));
//    $this->request->redirect('admin/news');
//    $this->response->body('admin');
//		$login = View::factory('user/menulogout');
//		$this->template->menu=$login;
    }
} // End 
