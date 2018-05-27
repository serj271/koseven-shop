<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Main_Index {


	public function model()
	{
		
		$model = ORM::factory($this->model)
			->find();
//		Log::instance()->add(Log::NOTICE, Debug::vars($model->as_array()));
		return Inflector::humanize($this->model);
	}	




    public function message(){
		return 'Hello admin22 - ';	

    }   

	
}
