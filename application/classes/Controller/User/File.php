<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_File extends Controller_User_Crud {
//    public $template ='main';
//    protected $_model='file';
//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
    public function action_index(){
		if (!Auth::instance()->logged_in('login')){
		
			$this->request->redirect('user/auth/login');
		}
//		$this->template->content = Message::display();
//    Log::instance()->add(Log::NOTICE, Route::url('admin'));
//    $this->request->redirect('admin/news');
//    $this->response->body('admin');
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
    }
} // End 
