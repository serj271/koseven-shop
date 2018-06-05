<?php

class View_Adminmodel_Main_Update
{	
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
	 
	public $model;

	public function model()
	{
		return Inflector::humanize($this->model);
	}	 
	 
	public $errors;
	
	public function form()
	{
		if ( ! $this->form)
		{
			// Create a CSRF token field
			$token = new View_Bootstrap_Form_Field('token', Security::token());
			$token->type('hidden');
			
			// Create a bootstrap form, load the model and add the token field to it
			$this->form = new View_Bootstrap_Modelform;
			$this->form->load($this->item);
		
			$this->form->add($token);
			$this->form->submit()->label(__('Update this :model',
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