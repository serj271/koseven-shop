<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Useradmin_Users extends Controller_Useradmin_Crud{
	protected $_model='User';
	public $menu = 'menu.useradmin';

	public function action_read()
	{
		$user = ORM::factory($this->_model, $this->request->param('id'));
		
		if ( ! $user->loaded())
		{
//			throw new HTTP_Exception_404(':model with ID :id doesn`t exist!',
//				array(':model' => $this->_model, ':id' => $this->request->param('id')));
			
		    Message::error(__(':model with ID :id not exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id'))));
//		$this->view_navigator->message = __(':model with ID :id not exist!',
//				array(':model' => $this->_model, ':id' => $this->request->param('id')));
			$this->redirect($this->request->route()->uri(array(
					'directory'		=> $this->request->directory(),
					'controller' 	=> $this->request->controller(),					
				)));

		}		



            $user_roles = array();
            foreach ( $user->roles->select('name')->find_all() as $role )
            {
                $user_roles[$role->name] = true;
            }
//			if ( ! Auth::instance()->logged_in('admin') AND $this->request->action !== 'login')  
//		Log::instance()->add(Log::NOTICE,Debug::vars($user_roles));

		$this->view->user_roles = $user_roles;















		$this->view->item = $user;
		$this->view_navigator->message = __(':model with ID :id',
				array(':model' => $this->_model, ':id' => $this->request->param('id')));
	}
}
