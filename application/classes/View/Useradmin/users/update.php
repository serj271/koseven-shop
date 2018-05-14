<?php defined('SYSPATH') or die('No direct script access.');
/** 
 * Generic (U)PDATE view model - for single record
 */
class View_Useradmin_Users_Update {
	
//	protected $_template = 'admin/update';

	/**
	 * @var	mixed	[Kostache|Formo] form
	 */
	public $form;

	/**
	 * @var	Model
	 */
	public $item;
	
	/**
	 * @var	array	validation errors
	 */

	protected $_includables = array('logins','one_password','password','last_login','timestamp');//for not display columns from table
	 
	public $model;

	public function model()
	{
		return Inflector::humanize($this->model);
	}
	public $errors;

	public function buttons()
	{
		return array(
			array(
				'class' => 'large success',
				'text' => 'Return',
				'url' => Route::url('useradmin', array(
					'directory' =>'useradmin',
					'controller' => 'users',
					'action'     => 'index',
				)),
			),			
		);
	} 


	
	public function form()
	{
//	    Log::instance()->add(Log::NOTICE, Debug::vars($this->item));
		if ( ! $this->form)
		{
			// Create a CSRF token field
			$token = new View_Bootstrap_Form_Field('token', Security::token());
			$token->type('hidden');
			//name value attrs
//			$cancel = new View_Bootstrap_Form_Field('cancel', 'cancel', array('type'=>'reset'));
//			$cancel->type('button');


			// Create a bootstrap form, load the model and add the token field to it
			$this->form = new View_Bootstrap_ModelForm();
			$this->form->includables($this->_includables);
			$this->form->load($this->item);			
			$this->form->add($token);
//			$this->form->add($cancel);

			$this->form->submit()->label(__('Update this :model',
				array(':model' => $this->model())));
			$this->form->reset()->label(__('Cancel this :model',
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
		return 'Update '.$this->model().' #'.$this->item->id;
	}
	
}
