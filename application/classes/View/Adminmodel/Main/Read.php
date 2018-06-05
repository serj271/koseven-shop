<?php

class View_Adminmodel_Main_Read
{
	public $model;

	public function model()
	{
		return Inflector::humanize($this->model);
	}	
//	protected $_template = 'admin/read';

	/**
	 * @var	Model
	 */
	public $item;
	
	/**
	 * @return	array	Available buttons
	 */
	public function buttons()
	{
		return array(
			array(
				'class' => 'large success',
				'text' => 'Update',
				'url' => Route::url('Adminmodel', array(
					'controller' 	=> strtolower($this->controller),
					'action' 		=> 'update',
					'model'			=> $this->model,
					'id' 			=> $this->item->id,
				)),
			),
			array(
				'class' => 'large error',
				'text' => 'Delete',
				'url' => Route::url('Adminmodel', array(
					'controller' 	=> $this->controller,
					'action' 		=> 'delete',
					'model'			=> $this->model,
					'id' 			=> $this->item->id,
				)),
			),
		);
	}
	
	/**
	 * @return	string	Page headline
	 */
	public function headline()
	{
		return ucfirst($this->model()).' #'.$this->item->id;
	}
	
	/**
	 * @return	array	field => value
	 */
	public function values()
	{
		$array 	= $this->item->object();
		$labels = $this->item->labels();
		
		$result = array();
		
//		$model = ORM::factory('Employee');
//		Log::instance()->add(Log::NOTICE, Debug::vars($model->find()->enterprise->title, $model->has_many(),array_keys($model->belongs_to())));
		
		foreach ($array as $field => $value)
		{
			$push = array(
				'label' => Arr::get($labels, $field),
				'value' => $value,
			);
			
			if ($push['label'] === NULL)
			{
				// Call the Inflector only if label hasn't been retrieved
				$push['label'] = ucfirst(Inflector::humanize($field));
			}
			
			$result[] = $push;
		}
		
		return $result;
	} 
   




}