<?php

class View_Adminmodel_Main_Create
{
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

	public $model = 'product_description';

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
			
			$this->form = new View_Bootstrap_Modelform;
			$this->form->action(strtolower($this->directory).'/'.strtolower($this->controller).'/'.$this->action);
			$this->form->load($this->item);	

			
			$this->form->add($token);
			$this->form->remove('timestamp');
			$this->form->remove('id');
			$this->form->submit()->label(__('Create :model',
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
		return 'Create a new '.$this->model().' '.$this->tab_number;
	}
	
   




}