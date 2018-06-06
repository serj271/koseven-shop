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
	
	protected $_options;

	public function model()
	{
		return Inflector::humanize($this->model);
	}
	public function create_button()
	{
		return array(
			'url' => Route::url('Adminmodel', array(
				'controller' 	=> $this->controller,
				'action'		=> 'create',
				'model'			=> $this->model
			)),
			'text' => 'Create  new id to '.$this->model(),
		);
	}
	public function buttons()
	{
		return array(
			array(
				'class' => 'large success',
				'text' =>'Create '.$this->model(),
				'url' => Route::url('Adminmodel', array(
				'controller' 	=> $this->controller,
				'action'		=> 'create',
				'model'			=> $this->model
			)),
			),
		);
	} 
	public function options()
	{
		if ($this->_options !== NULL)
			return $this->_options;
		
		// Create an empty model to get info from
		$model = ORM::factory($this->model);
		
		$columns 	= $model->table_columns();		
		$labels 	= $model->labels();
		
		foreach ($columns as $key=>$value)
		{
				$label = Arr::get($labels, $key, $key);
				
				$result[$key] = ucfirst($label);
				
		}
		
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
//				Log::instance()->add(Log::NOTICE, Debug::vars($this->options()));
			
			$this->form = new View_Bootstrap_Form();//action
			$action = Route::get('Adminmodel')->uri(
				array(
					'controller' 	=> $this->controller,
					'action'		=> $this->action,
					'model'			=> $this->model
				)
			);
			$this->form->action($action);
//			$this->form->load($this->item);			
			$this->form->add($token);
			
			$entries = new View_Bootstrap_Form_Field('entries','entries');
			$entries->type('select');
			$entries->attrs(array('class'=>'select'));//onchange
			$entries->options($this->options());
			$this->form->add($entries);
			
			$search = new View_Bootstrap_Form_Field('search');
			$search->type('text');
			$search->label('search');
			$this->form->add($search);
			
			$this->form->submit()->label(__('Read  :model',
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
