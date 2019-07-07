<?php

class View_User_Auth_Login extends View_Bootstrap_Form 
{
#	public $values = array();
#    public $labelUsername;
#    public $username;
#    public $password;
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
	public function form()
	{
		if ( ! $this->form)
		{
			$this->item = new Model_User;
			// Create a CSRF token field
			$token = new View_Bootstrap_Form_Field('token', Security::token());
			$token->type('hidden');			
//			Log::instance()->add(Log::NOTICE,Debug::vars($this->item));
			$this->form = new View_User_Bootstrap_Navigator_Userform;
			$this->form->action('/user/auth/login');	
//			$this->form->action($this->model);	
			$this->form->load($this->item);
			$this->form->add($token);

		}		
		return $this->form;
		}
	
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













	public function values()
	{
		return array('token' => Security::token()) + $this->values;

	}

    public function bolder()
    {
	return function($text)
	{
	    return '<b>'.$text.'</b>';		
	};    
    }
    public function colors()
    {
	return array('red','blue','green');
    }

//    public function __animal()
//    {
//	return __('animal');
//    }
//    public function i18n(){
//	return function ($value, $helper){
//	    return I18n::get($value);
//	};
//	return array('I18nFilter','get');
//    }

   
}