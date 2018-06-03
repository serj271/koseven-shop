<?php defined('SYSPATH') or die('No direct script access.');

class View_Basket_Create {
	
	const OPTIONS_ALIAS = 'options::alias';

	public $model; 
	
	public $product;
	
	public $product_id;
	
	public $cart_id;
	
	public $referer;
//	protected mCartId;;

	protected $_includables = array('added_on','quantity','attributes','buy_now','cart_id','product_id');//for display columns from table
		
	/**
	 * @var	array	Mustache template
	 */
//	protected $_template = 'useradmin/index';

	public function model()
	{
		return Inflector::humanize($this->model);
	}

	public function create_button()
	{
		return array(
			'url' => Route::url('useradmin', array(
				'controller' 	=> $this->controller,
				'action'		=> 'create',
			)),
			'text' => 'Create  new id to '.$this->model(),
		);
	} 	

	public function buttons()
	{
		return array(
			array(
				'class' => 'large',
				'text' => __('backwards'),
				'url' => Route::url('product', array(
					'directory' =>$this->directory,
					'controller' => 'auth',
					'action' 		=> 'logout',
				)),
			),	
			
		);
	}

//	protected $_columns;
	/**
	 * List of available actions to display for each individual row
	 *
	 * @return	array
	 */
	public function options()
	{
		return array(
			'read' => array(
				'class' 	=> 'btn primary',
				'text' 		=> 'View',
			),
//			'update' => array(
//				'class' 	=> 'btn success',
//				'text' 		=> 'Edit',
//			),
		);
	}
	
	/**
	 * @var	mixed	local cache for self::results()
	 */
	public $form;
	/**
	 * @var	ORM		model
	 */
	public $item;	
	/**
	 * @var	array	validation errors
	 */
	public $errors;	
	
	/**
	 * Returns the form for current view
	 */
	public function form()
	{
		if ( ! $this->form)
		{
			// Create a CSRF token field
			$token = new View_Bootstrap_Form_Field('token', Security::token());
			$token->type('hidden');
			/* $action = Request::uri('basket', array(
				'directory'=>'basket',
				'controller'=>'main',
				'action'=>'index'
			)); */
//			Log::instance()->add(Log::NOTICE, Debug::vars('view bask create',$this->item));
			$action = strtolower($this->directory).'/'.strtolower($this->action);
			$this->form = new View_Bootstrap_ModelForm($action);//action array attrs
			$this->form->includables($this->_includables);
//			$this->form->load($this->item);			
			$this->form->add($token);
			$product_id = new View_Bootstrap_Form_Field('product_id',$this->product_id);
			$product_id->type('hidden');
			$this->form->add($product_id);
			$cart_id = new View_Bootstrap_Form_Field('cart_id',$this->cart_id);
			$cart_id->type('hidden');
			$this->form->add($cart_id);


			$this->form->submit()->label(__('Add to basket',
				array(':model' => $this->model())));
			
			if ($this->errors)
			{
				$fields = $this->form->fields();
				
				foreach ($this->errors as $field => $error)
				{
					if ($field = Arr::get($fields, $field))
					{
						$field->error($error);
					}
				}
			}
		}
		
		return $this->form;
	}
	
	/**
	 * @return	string	Page headline
	 */
	public function headline()
	{
		return 'Create a new '.$this->model();
	}

	public function repo(){
		return array('name'=>'repo');
		
	}

	public function norepo(){
		return array();		
	}
		
	public function value()
	{
		$array 	= $this->product->object();
		$labels = $this->product->labels();
		$variations = $this->product->variations->find()->as_array();
		$photos = $this->product->photos->find()->as_array();
/* 		$product_item = $product->as_array();
		$product_item['photos'] = $photos;
		$product_item['variations'] = $variations; */		
		
		
		$photos = Arr::map(array(array(__CLASS__,'addBase')), $photos, array('path_fullsize','path_thumbnail'));
			
		
		$result = array(
				'name' => $labels['name'],
				'photos' =>$photos,
				'variations'=>$variations,
				
		);
		return $result;
	} 
	
	public function backwards_message(){
	    return __('backwards');
	}

	public static function addBase($url){
			return URL::base().$url;			
	} 
}
