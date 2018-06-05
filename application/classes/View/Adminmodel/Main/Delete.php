<?php

class View_Adminmodel_Main_Delete
{
//protected $_template = 'admin/delete';

	/**
	 * @var	ORM		model
	 */
	public $item;
	public $model;

	public function model()
	{
		return Inflector::humanize($this->model);
	}

	
	/**
	 * @return	string	Page headline
	 */
	public function headline()
	{
		return 'Confirm '.$this->model().' deletion';
	} 
   




}