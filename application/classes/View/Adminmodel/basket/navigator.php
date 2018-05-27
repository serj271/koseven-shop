<?php

class View_Admin_Basket_Navigator
{
//	public $message;	
	/**
	 * @var	mixed	[Kostache|Formo] form
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
	/*
	* 
	*/
	public $id;
//	protected $_template = 'admin/create';

//	public $model='user';
	
/*	public function headline()
	{
		return 'Create a new '.$this->model().' '.$this->id_listing;
	}
*/	
	public function message(){
		return Message::display('message/basic');
	}
	
	



//    public $results;
   
}