<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Datalog_Main extends Controller_Admin_Crud {
//    public $template ='main';
    protected $_model='datalog';
//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
    public function action_read(){		
		$result = '';		
//		Log::instance()->add(Log::NOTICE, Debug::vars($this->request->param('table_name')));
//		$obj = new stdClass;
//		$obj->username = "This is the content";
		if ($this->request->method() === Request::POST)
		{
			list($navigation,) = array_values(Arr::extract(
					$this->request->post(), array(
						'navigation'
					)));
//			Log::instance()->add(Log::NOTICE, Debug::vars(Route::get($this->request->directory()->uri(
//				array('controller'=> $this->request->controller())
//			))));
			$this->request->redirect(Route::get($this->request->directory())->uri(
				array(
					'controller'=> $this->request->controller(),
					'action'=>'read'
				)
			).'/'.$navigation);
		
		}
		$table_name = $this->request->param('table_name');
		if($table_name){
			$datalog = $this->_get_datalog($table_name);
			$result = View::factory('datalog')
				->set('show_table',TRUE)
				->set('datalog',$datalog);
		}
		
			
		
		
		$this->view->result = $result;

//		$this->template->content = Message::display();
//    Log::instance()->add(Log::NOTICE, Route::url('admin'));
//    $this->request->redirect('admin/news');
//    $this->response->body('admin');
    }
	
	public function action_delete()
	{		
		$row_pk =  $this->request->param('row_pk');
		$table_name = $this->request->param('table_name');
		
		if($row_pk & $table_name){
//			
			
			
			$items = ORM::factory('datalog')
				->where('row_pk','=',$row_pk)
				->find_all();
//			Log::instance()->add(Log::NOTICE, Debug::vars($items));	
		}
		
		
//		if ( ! $item->loaded())
//		{
//			throw new HTTP_Exception_404(ucfirst($this->_model).' doesn`t exist: :id', 
//				array(':id' => $this->request->param('id')));
//		}
		
		if ($this->request->method() === Request::POST)
		{
			$action = $this->request->post('action');
			
			if ($action !== 'yes')
			{
				$this->request->redirect(Route::get($this->request->directory())->uri(array(
					'controller' => $this->request->controller()
				)));
			}
			
			$item->delete();
			
			$this->request->redirect(Route::get($this->request->directory())->uri(array(
				'controller' => $this->request->controller()
			)));
		}
	
	
	
	
	
	}	 
	 
    private function _get_datalog($table_name)
    {
		$datalog = ORM::factory('Datalog')
			->where('table_name', '=', $table_name)
			->find_all();
		$out = array();
		foreach ($datalog as $dl)
		{
			$out[] = array(
				'table_name' => $dl->table_name,
				'column_name' => $dl->column_name,
				'row_pk' => $dl->row_pk,
				'username' => $dl->username,
				'old_value' => $dl->old_value,
				'new_value' => $dl->new_value,
				'date_and_time'=>$dl->date_and_time,
			);
		}
		return $out;
    }
    
} // End 
