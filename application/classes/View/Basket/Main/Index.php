<?php defined('SYSPATH') or die('No direct script access.');

class View_Basket_Main_Index {
	/**
	 * Alias for the options column (helps separate it from the rest)
	 */
	const OPTIONS_ALIAS = 'options::alias';

	public $model; 
	
	public $total_amount;
	
	public $carts;

	public $referer;
//	protected $_includables = array('cart_id','name','quantity','attributes','price','subtotal');//for display columns from table
		
	public $items;	
	
	protected $_labels = array();
	
	public $navigator='users ind';
	
   	public function model()
	{
		return Inflector::humanize($this->model);
	}

	public function headline()
	{
		return ucfirst(Inflector::plural($this->model()));
	} 
	
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

	public function buttons()
	{
		return array(
			array(
				'class' => 'large',
				'text' => 'Logout',
				'url' => Route::url('user', array(
					'directory' =>'user',
					'controller' => 'auth',
					'action' 		=> 'logout',
				)),
			),
		);
	}
	
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

				$options = array();
				
				foreach ($this->options() as $action => $details)
				{
					$options[] = array(
						'class' => $details['class'],
						'text' 	=> $details['text'],
						'url'	=> Route::url('basket', array(
							'directory'		=> $this->directory,
							'controller' 	=> $this->controller,
							'action'		=> $action,
							'id'			=> $item['id'],
						)),
					);
				}
				$result['rows'][] = array(
					'item'		=> $item,
					'total_amount'	=> $this->total_amount,
					'options' 	=> $options,
//					'values' 	=> $values,
				);



			}
		}
		$labels = ORM::factory($this->model)->labels();
//		$columns = ORM::factory($this->model)->list_columns();
		/* foreach($columns as $name=>$column){
			$label = Arr::get($labels, $name, Inflector::humanize($name));
			$this->_labels[$name] = __($label);
		} */
		$this->_labels = $labels;
		$result['labels'] = $labels;
//		Log::instance()->add(Log::NOTICE, Debug::vars('result',$result));
		return $this->_result = $result;		
	}

	public function labels(){
		return $this->_labels;
	}
	
/*
	public function repo(){
		return array('name'=>'repo33');
		
	}

	public function norepo(){
		return array();		
	}
*/
	public function caption(){
		return __('Shop Cart');
	}

	public static function addBase($url){		
			return URL::base().'product/read/'.$url;			
	} 
	
	public function in_ca(){
	    return $this->total_amount > 0;
	}
	public function message_empty_shopping_cart(){
	    return __("Your shopping cart is empty");
	}


	public function backwards_message(){
	    return __('backwards');
	}

	public function message_to_product(){
	    return __('To product');
	}

	public function to_product(){
			return	array(
				'class' => 'large',
				'text' => __('To product'),
				'url' => Route::url('Product', array(
					'directory' =>'product',
					'controller' => 'main',
					'action' 	=> 'index',
				)),
			);

	}

	
	
}
