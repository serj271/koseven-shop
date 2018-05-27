<?php

class View_Adminmodel_Main_Navigator
{
//	public $message;	
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

//	public $model='user';
	
/*	public function headline()
	{
		return 'Create a new '.$this->model().' '.$this->id_listing;
	}
*/	
	public function message(){
		return Message::display('message/basic');
	}
	
	public function form()
	{
		if ( ! $this->form)
		{
			// Create a CSRF token field
			$token = new View_Bootstrap_Form_Field('token', Security::token());
			$token->type('hidden');
			
			/* $this->item = new Model_Useradmin(); */
			$this->form = new View_Bootstrap_Modelform;
			$route = Route::get('Adminmodel')->uri();
			$action = URL::site($route, $protocol=NULL, $index=FALSE);
//			Log::instance()->add(Log::NOTICE, Debug::vars($action));
//			Log::instance()->add(Log::NOTICE,Debug::vars('request----',Request::current()->uri()));
			$this->form->action(Request::current());//Request::current()
//			$this->form->action(strtolower($this->directory).'/'.strtolower($this->controller));	
			/* $this->form->load($this->item); */
			$this->form->add($token);
			$this->form->attrs(array('method'=>'POST'));

			$navigation = new View_Bootstrap_Form_Field('model', 'model');
			$navigation->type('select');
			/* $navigation->value('rm');//selected
			$navigation->attrs(array('class'=>'test'));//id, onchange */
			$navigation->options(array('Product'=>'product','Catalog_Category'=>'Catalog_Category'));//value=>label
			$this->form->add($navigation);
			
			$search = new View_Bootstrap_Form_Field('search');
			$search->type('text');
			$search->label('search');
//			$search->attrs(array('class'=>'test'));//id, onchange
//			$this->form->add($search);
			
			/* $ragion = new View_Bootstrap_Form_Field('show_all','ragion');
			$show_all = array('name'=>'ragion','value'=>'show_all','checked'=>$this->checked_show_all, 'label'=>'show_all','attrs'=>array('id'=>'show_all'));
			$show_select = array('name'=>'ragion','value'=>'show_select','checked'=>$this->checked_show_select, 'label'=>'show_select','attrs'=>array('id'=>'show_select'));
			$options = array();
			$options[] = $show_all;
			$options[] = $show_select;			
			
			$ragion->options($options);
			$ragion->type('radio');
			$this->form->add($ragion);	 */					
			
			/* $this->form->submit()->label(__('Search :model',
				array(':model' => $this->model())));
			$this->form->submit()->attrs(array('type'=>'submit','class'=>'btn')); */
			
			/* if ($this->errors)
			{
				$fields = $this->form->fields();
				Log::instance()->add(Log::NOTICE,Debug::vars($this->errors));	
				foreach ($this->errors as $field => $error)
				{
					if ($field = Arr::get($fields, $field))
					{
						$field->error($error);
					}
				}
			} */
		}		
		return $this->form;
	}
	



//    public $results;
   
}