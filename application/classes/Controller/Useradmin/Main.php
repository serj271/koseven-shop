<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Useradmin_Main extends Controller_Useradmin_Crud {
//    public $template ='main';
    protected $_model='User';

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
//    $this->response->body('admin');
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
    }
} // End 
