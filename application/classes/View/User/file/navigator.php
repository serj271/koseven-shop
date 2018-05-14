<?php

class View_User_File_Navigator extends View_Bootstrap_Navigator_Useradminform
{
	public $message;	
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

//	public $model='useradmin';
	
	public $checked_show_all;
	public $checked_show_select;

	public function model()
	{
		return Inflector::humanize($this->model);
	}	
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
			
		}		
		return $this->form;
	}
	
	/**
	 * @return	string	Page headline
	 */
	public function headline()
	{
//		return 'Create a new '.$this->model().' '.$this->id_listing;
	}
	
	public function message(){
		return Message::display('message/basic');
	}
	
	



//    public $results;
   
}