<?php defined('SYSPATH') or die('No direct script access.');
/** 
 * Generic (U)PDATE view model - for single record
 */
class View_Basket_Increment {
	public $item;
	public $model;

	/* public function model()
	{
		return Inflector::humanize($this->model);
	}

	public function headline()
	{
		return 'Update '.$this->model().' #'.$this->item->id;
	} */
	public function updated_value(){
		return $this->item->quantity +1;
	}
	
	public function token(){
		return Security::token();
	}
	
}
