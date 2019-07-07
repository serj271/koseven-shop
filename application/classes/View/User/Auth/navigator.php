<?php

class View_User_Auth_Navigator extends View_User_Bootstrap_Navigator_Form
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
//	protected $_template = 'admin/create';

	public $model='user';	

	public function model()
	{
		return Inflector::humanize($this->model);
	}	
	/**
	 * Returns the form for current view
	 */
/*	public function form()
	{
		if ( ! $this->form)
		{
			// Create a CSRF token field
			$token = new View_Bootstrap_Form_Field('token', Security::token());
			$token->type('hidden');			
//			Log::instance()->add(Log::NOTICE,Debug::vars($this->item));
			$this->form = new View_User_Bootstrap_Navigator_Userform;
			$this->form->action($this->model);	
//			$this->form->load($this->item);
			$this->form->add($token);

		}		
		return $this->form;
	}
*/	
	/**
	 * @return	string	Page headline
	 */
	public function headline()
	{
		return 'Create a new '.$this->model().' '.$this->id_listing;
	}
	
	public function message(){
		return Message::display('message/basic');
	}
	
	



//    public $results;
   
}