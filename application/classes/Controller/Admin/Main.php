<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Main extends Controller_Admin {
//    public $template ='main';
	protected $_model = 'Product';
//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
    public function action_index(){
		

//		Log::instance()->add(Log::NOTICE,Debug::vars('item_uri----',$item_uri));
		
	}
	 public function action_4(){
		

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
