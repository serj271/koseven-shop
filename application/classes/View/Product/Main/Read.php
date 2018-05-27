<?php defined('SYSPATH') or die('No direct script access.');

class View_Product_Main_Read {
	public $model;
/* 
	public function model()
	{
		return Inflector::humanize($this->model);
	}	 */
	public $item;	
	/**
	 * @return	array	Available buttons
	 */
	public function buttons()
	{
		return array(
			array(
				'class' => 'large error',
				'text' => 'Add shop cart',
				'url' => Route::url('basket', array(
					'directory'	=>'Basket',
					'controller' 	=> 'index',
					'action' 		=> 'create',
					'id' 			=> $this->item->id,
				)),
			),
		);
	}
	
	/**
	 * @return	string	Page headline
	 */
	public function headline()
	{
//		return ucfirst($this->model()).' #'.$this->item->id;
	}
	public function token(){
		return Security::token();
	}
	public function charset(){
		return 'UTF-8';
	}
	public function sendtext(){
		return 'Add shop cart';
	}
	public function cart_id(){
		return Cart::GetCartId();
	}
	
	public function value()
	{
		$item 	= $this->item->object();
//		$labels = $this->item->labels();
//		Log::instance()->add(log::NOTICE, Debug::vars( $item, $item['uri']));		
			
		$photo = $this->item->primary_photo()->as_array();			
		$photo = Arr::map(array(array(__CLASS__,'addBase')), $photo, array('path_fullsize','path_thumbnail'));	
		
		$item['photo'] = $photo;		
		
		return $item;
	} 
	
	public static function addBase($url){
		return URL::base().$url;			
	} 
	
}
