<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Adminmodel_Main extends Controller_Adminmodel {
//    public $template ='main';
	protected $_model = 'Product1';

    public function action_index(){
//		throw new HTTP_Exception_404();
		if($this->request->method() === Request::POST){
			$post=array_map('trim',$this->request->post());
			$keys=array('model');
			$last_input=Arr::extract($post,$keys,NULL); 
			$model = $last_input['model'];
//			Log::instance()->add(Log::NOTICE,Debug::vars('model-post---',$model));		
			
			$this->redirect(Route::get($this->request->directory())		
					->uri(
						array(
							'directory' =>'Adminmodel',
							'controller' => 'Main',
							'action'     => 'index',
							'model'		=>$model
						)
					)					
			);
		}
		
		$model = $this->request->param('model');
		if($model){
			$this->model = $model;
		}
		

//		Log::instance()->add(Log::NOTICE,Debug::vars('model----',$model));
		
	}
	 public function action_read(){
		

//		Log::instance()->add(Log::NOTICE,Debug::vars('item_uri----',$item_uri));
		
	}
	
	public static function addBase($url){
			return URL::base().$url;			
	} 
	public static function createLink($uri){
		$link = Route::get('Product')->uri(array(
			'directory' =>'Product',
			'controller' => 'Main',
			'action'     => 'read',
			'item_uri' => $uri			
		));//URL::site('product');
		return URL::base().'product/read/'.$uri;			
	} 
} // End 
