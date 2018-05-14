<?php

class View_Useradmin_Users_Navigator
{
	public $message;	

	public $item;	
	/**
	 * @var	array	validation errors
	 */
	public $errors;	
	/*
	* 
	*/
	public $form;
	
	public $id;
//	protected $_template = 'admin/create';

	/**
	 * @return	string	Page headline
	 */
	
//	public function message(){
//		return Message::display('message/basic');
//	}
	
	
	
	public function buttons()
	{
		return array(
			array(
				'class' => 'large success',
				'text' => 'Update',
				'url' => '/'.$this->controller,
				
			),
		);
	}
	



//    public $results;
   
}