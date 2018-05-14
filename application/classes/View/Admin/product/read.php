<?php defined('SYSPATH') or die('No direct script access.');
/** 
 * Generic (R)EAD view model - for single record
 */
class View_Admin_Product_Read {
	public $model;

	public function model()
	{
		return Inflector::humanize($this->model);
	}	
//	protected $_template = 'admin/read';
	protected $_includables = array('logins','password');//for not sho columns from table
	/**
	 * @var	Model
	 */
	public $item;


	public $user_roles = array();
	
	/**
	 * @return	array	Available buttons
	 */
	public function buttons()
	{
		return array(
			array(
				'class' => 'large success',
				'text' => 'Update',
				'url' => Route::url('admin/product', array(
					'directory'	=>'admin',
					'controller' 	=> $this->controller,
					'action' 		=> 'update',
					'id' 			=> $this->item->id,
				)),
			),
			array(
				'class' => 'large error',
				'text' => 'Delete',
				'url' => Route::url('admin/product', array(
					'directory'	=>'admin',
					'controller' 	=> $this->controller,
					'action' 		=> 'delete',
					'id' 			=> $this->item->id,
				)),
			),
		);
	}
	
	/* public function user_roles(){
		
	} */
	
	
	
	/**
	 * @return	string	Page headline
	 */
	public function headline()
	{
		return ucfirst($this->model()).' #'.$this->item->id;
	}
	
	/**
	 * @return	array	field => value
	 */
	public function values()
	{
		$array 	= $this->item->object();
		$labels = $this->item->labels();

		
		$result = array();
		
		foreach ($array as $field => $value)
		{
			if(in_array($field, $this->_includables)){
			    continue;
			}
			$push = array(
				'label' => Arr::get($labels, $field),
				'value' => $value,
			);
			
			if ($push['label'] === NULL)
			{
				// Call the Inflector only if label hasn't been retrieved
				$push['label'] = ucfirst(Inflector::humanize($field));
			}			
						
			$result[] = $push;	
			
		}
		$roles = '';

//		foreach ($this->user_roles as $key=>$role){
//			Log::instance()->add(log::NOTICE, Debug::vars( $key,$role));
//			
//				$roles = $roles.' '.$key;
			
//		}
		
		$result[] = array(
				'label' => 'role',
				'value' =>$roles,
		);
		return $result;
	}
	
}
