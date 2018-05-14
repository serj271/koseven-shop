<?php defined('SYSPATH') or die('No direct script access.');

class View_Product_Main_Index {


//	public function model()
//	{
//		return Inflector::humanize($this->model);
//	}	
	public $items;
   
	public $pagination;
    
	public function buttons()
	{
		return array(
			array(
				'class' => 'large success',
				'text' => 'Product',
				'url' => Route::url('product', array(
					'directory' =>'product',
					'controller' => 'main',
					'action'     => 'index',
				)),
			),			
		);
	} 
	
	
	
   	public function model()
	{
		return Inflector::humanize($this->model);
	}

	public function headline()
	{
		return ucfirst(Inflector::plural($this->model()));
	} 
/*	
	public function options()
	{
		return array(
			'decrement' => array(
				'class' 	=> 'btn primary',
				'text' 		=> __('Decrement'),
			),
			'increment' => array(
				'class' 	=> 'btn success',
				'text' 		=> __('Increment'),
			),
			'delete' => array(
				'class' 	=> 'btn danger',
				'text' 		=> __('Delete'),
			),
		);
	}
/*	
	/**
	 * @var	mixed	local cache for self::results()
	 */
	protected $_result;
	
	public function result_count(){
		return count($this->items);
	}
	
	/**
	 * Resultset (table body rows)
	 * 
	 * @return	array	(empty if no results)
	 */
	public function result()
	{
		
		
	}

	public function labels(){
		return $this->_labels;
	}

	public static function addBase($url){		
		return URL::base().$url;			
	} 
	
	/* public static function createValue($value){
		return array('value'=>$value);			
	}
	public static function createLabel($label){
		return array('label'=>$label);			
	}
	
	public static function merge($item){
		Log::instance()->add(Log::NOTICE, Debug::vars('merge',$item));
		return array('item'=>$item);			
	} */
	
	public function in_ca(){
//	    return $this->total_amount > 0;
	}
/* 	public function message_empty_shopping_cart(){
	    return __("Your shopping cart is empty");
	} */
	

	
}
