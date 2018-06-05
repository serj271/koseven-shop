<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Generic (C)REATE view model - for single record
 */
class View_Adminmodel_Main_Prepend {
	/**
	 * Alias for the options column (helps separate it from the rest)
	 */
	const OPTIONS_ALIAS = 'options::alias';
	
	/**
	 * @var	array	Field names to create table columns out of
	 */
//	protected $_includables = array('name','title','email');
	protected $_includables = array('name','description');//for display columns from table 
	/**
	 * @var	mixed	[Kostache|Formo] form
	 */
	public $form;
	public $table_columns;
	/**
	 * @var	ORM		model
	 */
	public $item;	
	/**
	 * @var	array	validation errors
	 */
	public $errors;
	
//	protected $_template = 'admin/create';

	public $model;
	
	protected $_columns;

	public function model()
	{
		return Inflector::humanize($this->model);
	}
	public function columns()
	{
		if ($this->_columns !== NULL)
			return $this->_columns;
		
		// Create an empty model to get info from
		$model = ORM::factory($this->model);
		
		$columns 	= $model->table_columns();		
		$labels 	= $model->labels();
		
		$result 	= array(
			// Always include the primary key
			 array(
				'alias' => $model->primary_key(),
				'name' 	=> 'ID',
			),
		);
		
		// Also include some default columns - if they exist
		foreach ($this->_includables as $includable)
		{
			if (isset($columns[$includable]))
			{
				$label = Arr::get($labels, $includable, $includable);
				
				$result[] = array(
					'alias' => $includable,
					'name' 	=> ucfirst($label),
				);
			}
		}
		
		// Include the created column - if it exists
		if ($created = $model->created_column())
		{
			$result[] = array(
				'type'	=> 'created_column',
				'alias' => $created['column'],
				'name' 	=> 'Created',
			);
		}
		
		// Include the updated column - if it exists
		if ($updated = $model->updated_column())
		{
			$result[] = array(
				'type'	=> 'updated_column',
				'alias' => $updated['column'],
				'name' 	=> 'Last update',
			);
		}
		
		// Append the options array the last
		$result[] = array(
			'alias' => static::OPTIONS_ALIAS,
			'name'	=> 'Options',
		);
//		Log::instance()->add(Log::NOTICE, Debug::vars($this->_includables));		
		return $this->_columns = $result;
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
				Log::instance()->add(Log::NOTICE, Debug::vars($this->columns()));
			
			$this->form = new View_Bootstrap_Form();//action
//			$this->form->load($this->item);			
			$this->form->add($token);
			
			$this->form->submit()->label(__('Create new  :model',
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
		return 'Prepend  new id to '.$this->model();
	}
	
}
