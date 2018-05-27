<?php defined('SYSPATH') or die('No direct script access.');

class View_Product_Main_Index {


//	public function model()
//	{
//		return Inflector::humanize($this->model);
//	}	
	public $items;
   
	public $pagination;
    
	/* public function buttons()
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
	 */
	
	
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
		if ($this->_result !== NULL)
			return $this->_result;
		
		$result = array();
		
		if (count($this->items) > 0)
		{
			$result['rows'] = array();
			foreach ($this->items as $item)
			{			
				// Map all values to array('value' => $value)
			/* 	$values = array_map(function($val) { 					
					return array('value' => $val);				
				}, $values);	 */			
				$item = Arr::map(array(array(__CLASS__,'addBase')), $item, array('uri'));//replace uri
				// Push data to the rows array

//				$options = array();
			
					$basket = array(
						'class' => 'btn primary',
						'text' 	=> __('Add shopping cart'),
						'url'	=> Route::url('basket', array(
							'directory'		=> 'basket',
							'controller' 	=> 'main',
							'action'		=> 'create',
							'id'			=> $item->id,
						)),
					);
				
				$product=new stdClass();
				$product->name = $item->name;
				$photo = $item->primary_photo()->as_array();
				$photo = Arr::map(array(array(__CLASS__,'addBase')), $photo, array('path_fullsize','path_thumbnail'));//photo model
				$product->photo = $photo;
				$reviews = $item->reviews->find()->as_array();
				$specifications = $item->specifications->find()->as_array();
//				Log::instance()->add(Log::NOTICE, Debug::vars($item->specifications->find()));
				$variations = $item->variations->find()->as_array();

				$product->reviews = $reviews;
				$product->specifications = $specifications;
				$labels_variations = $item->variations->labels();
				/* $value = Arr::map(array(array(__CLASS__,'createValue')), array($variations), array_keys($variations))[0];
				$label = Arr::map(array(array(__CLASS__,'createLabel')), array($labels_variations), array_keys($labels_variations))[0]; */
				$variation_items = array();
//				Log::instance()->add(Log::NOTICE, Debug::vars($value));
				foreach ($variations as $key=>$val){				
					$variation_items[$key]['value'] = $val;
					$variation_items[$key]['label'] = isset($labels_variations[$key]) ? $labels_variations[$key] : '';
				}
//				$res = Arr::map(array(array(__CLASS__,'merge')), array($labels_variations), array_keys($labels_variations));
//				Log::instance()->add(Log::NOTICE, Debug::vars(URL::site(Route::get('Product')->uri($params=NULL), $protocol=NULL, $index = FALSE)));		
		
				$url_detail = URL::site(Route::get('Product')->uri(array('item_uri'=>$item->uri)), $protocol=NULL, $index = FALSE);
				
				$result['rows'][] = array(
					'product'		=> $product,
					'basket'		=> $basket,
					'variations'		=>$variation_items,
					'url_detail'	=> $url_detail
//					'total_amount'	=> $this->total_amount,
//					'options' 	=> $options,
//					'values' 	=> $values,
				);
			}
		}
//		$labels = ORM::factory($this->model)->labels();
//		$columns = ORM::factory($this->model)->list_columns();
		/* foreach($columns as $name=>$column){
			$label = Arr::get($labels, $name, Inflector::humanize($name));
			$this->_labels[$name] = __($label);
		} */
//		$this->_labels = $labels;
//		$result['labels'] = $labels;
		return $this->_result = $result;		
	}


	public function labels(){
		return $this->_labels;
	}

	public static function addBase($url){		
		return URL::base().$url;			
	}
	
	public function in_ca(){
//	    return $this->total_amount > 0;
	}
/* 	public function message_empty_shopping_cart(){
	    return __("Your shopping cart is empty");
	} */
	

	
}
