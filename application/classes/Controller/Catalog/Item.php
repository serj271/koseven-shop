<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Catalog_Item extends Controller_Common_Item {
	protected $_model = 'catalog_item';
	

	public function action_index(){	
		$request = $this->request->current();
		
		$item_uri = $this->request->param('item_uri');
		if($item_uri){
			$item = ORM::factory($this->_model)
				->where('uri','=',$item_uri)
				->find();
			if ( ! $item->loaded())
			{
	//			throw new HTTP_Exception_404(ucfirst($this->_model).' doesn`t exist: :id', 
	//				array(':id' => $this->request->param('id')));
				$this->request->redirect(Request::current()->directory().'/'.Request::current()->controller());
	//			Message::error(ucfirst($this->_model).' doesn`t exist: :id', 
	//				array(':id' => $this->request->param('id')));
			}
			Log::instance()->add(Log::NOTICE,Debug::vars($item_uri, $item->brand));
//		$query_controller = $request->query('controller');		
			$renderer = Kostache::factory(); 
			list($view_name, $view_path) = static::find_view($this->request);
//				Log::instance()->add(Log::NOTICE, $view_name);
			if (Kohana::find_file('classes', $view_path))
			{	
				$view = new $view_name(); 
				$view->item = $item;
//				$view->image = '/media/images/personal/news/22.jpg';
				$view->image = '/media/images/shopelement/1.jpg';
//				$view->image = url::site('images/22.jpg');
//				$view->image = HTML::image('media/img/logo.png', array('alt' => 'My Company'));
//				$view->results = $results;
//					$view->title = $element_orm->title;
	//			$view->toForm = URL::base()."personalviewerproperty/id/";	
	//			$view->restrict = __(Kohana::$config->load('personalviewer.result.restrict'));
	//			$view->enterprise = $enterprise;
	//				$view->tableCaption = Kohana::$config->load('personal.tableCaption.searchResultId');

				$content = $renderer->render($view);	
		
				$this->template->content=$content;
			}
			
			
			
		}
		

//		Log::instance()->add(Log::NOTICE,Debug::vars($element_uri,$element_orm->title));
//		$query_controller = $request->query('controller');		
//		$param = $this->request->param('category_uri');
//		Log::instance()->add(Log::NOTICE, Debug::vars($param));
//	$renderer = Kostache::factory(); 
//		$element_orm = ORM::factory($this->_model)
//		->where('',)
//		$this->response->body('hello, world catalog item! ');	
		
		




//		$this->template->content = 'hello, world catalog element! '.$element_orm->title;
//		$pagination  = new Pagination::$factory();
//		$this->response->body($renderer->render(new View_Test)); 
//	    $internal_request=View::factory('welcome');

	}
	
	public function action_detail(){	
		
//		Log::instance()->add(Log::NOTICE, 'My Logged Message Here');
//	$renderer = Kostache::factory(); 
		$this->response->body('hello, world catalog! detail');	
		
//		$pagination  = new Pagination::$factory();
//		$this->response->body('hello, world!');
//		$this->response->body($renderer->render(new View_Test)); 
//	    $internal_request=View::factory('welcome');

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
	
} // End Controller_Catalog

