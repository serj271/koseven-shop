<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Main_Index {


	public function model()
	{
		return Inflector::humanize($this->model);
	}	




    public function message(){
	return 'Hello admin22';	

    }   

	
}
