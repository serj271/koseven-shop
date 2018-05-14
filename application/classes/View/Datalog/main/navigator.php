<?php

class View_Datalog_Main_Navigator extends View_Bootstrap_Navigator_Useradminform
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

	public $model='datalog';

	
//	public $checked_show_all;
//	public $checked_show_select;

	public function model()
	{
		return Inflector::humanize($this->model);
	}	

	public function form()
	{
		if ( ! $this->form)
		{
			// Create a CSRF token field
//			Log::instance()->add(Log::NOTICE, Debug::vars($this->model()));
			$token = new View_Bootstrap_Form_Field('token', Security::token());
			$token->type('hidden');
			
//			$this->item = new Model_Useradmin();
			$this->form = new View_Bootstrap_Navigator_Useradminform;
			$this->form->action($this->model);	
//			$this->form->load($this->item);
			$this->form->add($token);

			$navigation = new View_Bootstrap_Form_Field('navigation', 'navigation');
			$navigation->type('select');
//			$navigation->value('rm');//selected
//			$navigation->attrs(array('class'=>'test'));//id, onchange
			$navigation->options(Kohana::$config->load('datalog.models'));
			$this->form->add($navigation);
			
//			$ragion = new View_Bootstrap_Form_Field('show_all','ragion');
//			$show_all = array('name'=>'ragion','value'=>'show_all','checked'=>$this->checked_show_all, 'label'=>'show_all','attrs'=>array('id'=>'show_all'));
//			$show_select = array('name'=>'ragion','value'=>'show_select','checked'=>$this->checked_show_select, 'label'=>'show_select','attrs'=>array('id'=>'show_select'));
//			$options = array();
//			$options[] = $show_all;
//			$options[] = $show_select;			
			
//			$ragion->options($options);
//			$ragion->type('radio');
//			$this->form->add($ragion);						
			
			$this->form->submit()->label(__('Search'));

			$this->form->submit()->attrs(array('type'=>'submit','class'=>'btn'));
			
			if ($this->errors)
			{
				$fields = $this->form->fields();
//				Log::instance()->add(Log::NOTICE,Debug::vars($this->errors));	
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
	 * Returns the form for current view
	 */
	
	public function message(){
		return Message::display('message/basic');
	}
	
	



//    public $results;
   
}